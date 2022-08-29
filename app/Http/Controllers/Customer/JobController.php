<?php

/**
 * PHP Version 7.4.25
 * Laravel Framework 8.83.18
 *
 * @category Controller
 *
 * @package Laravel
 *
 * @author CWSPS154 <codewithsps154@gmail.com>
 *
 * @license MIT License https://opensource.org/licenses/MIT
 *
 * @link https://github.com/CWSPS154
 *
 * Date 28/08/22
 * */

namespace App\Http\Controllers\Customer;

use App\DataTables\Customer\JobDataTable;
use App\Http\Controllers\Controller;
use App\Models\AddressBook;
use App\Models\CustomerContact;
use App\Models\DailyJob;
use App\Models\Job;
use App\Models\JobAddress;
use App\Models\JobAssign;
use App\Models\JobStatus;
use App\Models\User;
use DataTables;
use DB;
use Helper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param JobDataTable $dataTable
     * @return Application|Factory|View
     */
    public function index(JobDataTable $dataTable)
    {
        return $dataTable->render('template.customer.job.index_job');
    }

    /**
     * @param Request $request
     * @return JsonResponse|Collection
     */
    public function getAddress(Request $request)
    {
        if ($request->ajax()) {
            if ($request->search) {
                $search = $request->search;
                $id = $request->id;
                $addressBooks = AddressBook::when(
                    $search,
                    function ($query) use ($search) {
                        $query->where('company_name', 'like', '%' . $search . '%');
                    }
                )->when($id, function ($query) use ($id) {
                    $query->where('user_id', $id);
                })->limit(15)->get();
                $response = array();
                foreach ($addressBooks as $addressBook) {
                    $response[] = array(
                        "id" => $addressBook->id,
                        "text" => $addressBook->company_name
                    );
                }
                return response()->json($response);
            }
            if ($request->user_id) {
                $user = User::with('defaultAddress', 'customer:company_name,user_id,id,area_id', 'customer.area')
                    ->findOrFail($request->user_id);
                $data = collect($user->defaultAddress);
                $data->push(['customer_name' => $user->customer->company_name]);
                return $data->push(['area' => $user->customer->area]);
            }
            if ($request->company_name) {
                return AddressBook::where('company_name', $request->company_name)->latest()->first();
            }
            if ($request->id) {
                return AddressBook::findOrFail($request->id);
            }
        }
    }

    /**
     * @return JsonResponse|void
     */
    public function getCustomerContact()
    {
        if (\request()->ajax()) {
            $search = request()->search;
            $id = request()->id;
            $customerContacts = CustomerContact::when(
                $search,
                function ($query) use ($search) {
                    $query->where('customer_contact', 'like', '%' . $search . '%');
                }
            )->when($id, function ($query) use ($id) {
                $query->where('user_id', $id);
            })->limit(15)->get();
            $response = array();
            foreach ($customerContacts as $customerContact) {
                $response[] = array(
                    "id" => $customerContact->id,
                    "text" => $customerContact->customer_contact
                );
            }
            return response()->json($response);
        }
    }

    /**
     * @param Request $request
     * @return void
     */
    public function getAddressBook(Request $request)
    {
        if ($request->ajax()) {
            return Helper::getAddressBook($request->user_id);
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse|void
     */
    public function assignDriver(Request $request)
    {
        if (\App\Helpers\Helper::isJSON($request->job_id)) {
            $job_ids = json_decode($request->job_id, true);
            if (is_array($job_ids)) {
                foreach ($job_ids as $job_id) {
                    $jobAssign = JobAssign::where('job_id', $job_id)->first();
                    if (end($job_ids)) {
                    }
                    if ($jobAssign && ($jobAssign->status == JobAssign::NOT_ASSIGNED || $jobAssign->status == JobAssign::JOB_REJECTED || $jobAssign->status == JobAssign::ASSIGNED)) {
                        $jobAssign->user_id = $request->driver_id;
                        $jobAssign->status = JobAssign::NOT_ASSIGNED;
                        $jobAssign->save();
                        $result = back()->with('success', 'Mass jobs assigned updated successfully');
                    } else {
                        JobAssign::create([
                            'job_id' => $job_id,
                            'user_id' => $request->driver_id,
                            'status' => JobAssign::NOT_ASSIGNED,
                        ]);
                        $result = back()->with('success', 'Mass jobs assigned successfully');
                    }
                }
                return $result;
            }
        } else {
            $jobAssign = JobAssign::where('job_id', $request->job_id)->first();
            if ($jobAssign && ($jobAssign->status == JobAssign::NOT_ASSIGNED || $jobAssign->status == JobAssign::JOB_REJECTED || $jobAssign->status == JobAssign::ASSIGNED)) {
                $jobAssign->user_id = $request->driver_id;
                $jobAssign->status = JobAssign::NOT_ASSIGNED;
                $jobAssign->save();
                return back()->with('success', 'Job Assigned updated successfully');
            } else {
                JobAssign::create([
                    'job_id' => $request->job_id,
                    'user_id' => $request->driver_id,
                    'status' => JobAssign::NOT_ASSIGNED,
                ]);
                return back()->with('success', 'Job Assigned successfully');
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('template.customer.job.create_job');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $request->has('van_hire') ? $vanHire = true : $vanHire = false;
        $dailyJobs = DailyJob::getTodaysJobCount();
        if ($dailyJobs) {
            $dailyJobs += 1;
        } else {
            $dailyJobs = 1;
        }
        DB::beginTransaction();
        try {
            if ($request->from_add_to_address_book) {
                $this->makeNewAddress($request->customer, $request->all(), 'from');
            }
            if ($request->to_add_to_address_book) {
                $this->makeNewAddress($request->customer, $request->all(), 'to');
            }

            $job = Job::create([
                'user_id' => $request->customer,
                'customer_contact_id' => $this->updateOrCreate($request->customer, $request->customer_contact),
                'from_area_id' => $request->from_area_id,
                'to_area_id' => $request->to_area_id,
                'timeframe_id' => $request->timeframe_id,
                'notes' => $request->notes,
                'van_hire' => $vanHire,
                'number_box' => $request->number_box,
                'status_id' => JobStatus::ORDER_PLACED
            ]);

            $this->makeNewJobAddress($job->id, $request->all(), 'from');
            $this->makeNewJobAddress($job->id, $request->all(), 'to');

            $job->job_increment_id = $job->createIncrementJobId($job->id);
            $job->save();

            DailyJob::create([
                'job_id' => $job->id,
                'job_number' => $dailyJobs,
            ]);
            if ($request->has('driver_id')) {
                JobAssign::create([
                    'job_id' => $job->id,
                    'user_id' => $request->driver_id,
                    'status' => JobAssign::NOT_ASSIGNED,
                ]);
            }
            DB::commit();
            return redirect()->route('jobs.index')->with('success', 'Job Created successfully');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Validator for validate data in the request.
     *
     * @param array $data The data
     * @param int|null $id The identifier for update validation
     *
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     **/
    protected function validator(array $data, int $id = null)
    {
        \Validator::extend(
            'without_spaces',
            function ($attr, $value) {
                return preg_match('/^\S*$/u', $value);
            }
        );

        return Validator::make(
            $data,
            [
                'customer' => ['required', 'integer'],
                'customer_contact' => ['string'],
                'company_name_from' => ['required'],
                'company_name_to' => ['required'],
                'street_address_from' => ['required'],
                'street_number_from' => ['required'],
                'suburb_from' => ['required'],
                'city_from' => ['required'],
                'state_from' => ['required'],
                'zip_from' => ['required'],
                'country_from' => ['required'],
                'place_id_from' => ['required'],
                'latitude_from' => ['required'],
                'longitude_from' => ['required'],
                'location_url_from' => ['required'],
                'json_response_from' => ['required'],
                'from_area_id' => ['required', 'integer'],
                'street_address_to' => ['required'],
                'street_number_to' => ['required'],
                'suburb_to' => ['required'],
                'city_to' => ['required'],
                'state_to' => ['required'],
                'zip_to' => ['required'],
                'country_to' => ['required'],
                'place_id_to' => ['required'],
                'latitude_to' => ['required'],
                'longitude_to' => ['required'],
                'location_url_to' => ['required'],
                'json_response_to' => ['required'],
                'to_area_id' => ['required', 'integer']
            ]
        );
    }

    /**
     * @param $user_id
     * @param $address
     * @param $input_id
     * @return void
     */
    private function makeNewAddress($user_id, $address, $input_id)
    {
        $newAddress = AddressBook::where('place_id', $address['place_id_' . $input_id])->first();
        if ($newAddress) {
            $newAddress->company_name = $address['company_name_' . $input_id];
            $newAddress->street_address = $address['street_address_' . $input_id];
            $newAddress->street_number = $address['street_number_' . $input_id];
            $newAddress->suburb = $address['suburb_' . $input_id];
            $newAddress->city = $address['city_' . $input_id];
            $newAddress->state = $address['state_' . $input_id];
            $newAddress->zip = $address['zip_' . $input_id];
            $newAddress->country = $address['country_' . $input_id];
            $newAddress->place_id = $address['place_id_' . $input_id];
            $newAddress->latitude = $address['latitude_' . $input_id];
            $newAddress->longitude = $address['longitude_' . $input_id];
            $newAddress->location_url = $address['location_url_' . $input_id];
            $newAddress->full_json_response = $address['json_response_' . $input_id];
            $newAddress->status = true;
            $newAddress->set_as_default = false;
            if (!$newAddress->isDirty()) {
                $newAddress->save();
            } else {
                AddressBook::create([
                    'user_id' => $user_id,
                    'company_name' => $address['company_name_' . $input_id],
                    'street_address' => $address['street_address_' . $input_id],
                    'street_number' => $address['street_number_' . $input_id],
                    'suburb' => $address['suburb_' . $input_id],
                    'city' => $address['city_' . $input_id],
                    'state' => $address['state_' . $input_id],
                    'zip' => $address['zip_' . $input_id],
                    'country' => $address['country_' . $input_id],
                    'place_id' => $address['place_id_' . $input_id],
                    'latitude' => $address['latitude_' . $input_id],
                    'longitude' => $address['longitude_' . $input_id],
                    'location_url' => $address['location_url_' . $input_id],
                    'full_json_response' => $address['json_response_' . $input_id],
                    'status' => true,
                    'set_as_default' => false
                ]);
            }
        } else {
            AddressBook::create([
                'user_id' => $user_id,
                'company_name' => $address['company_name_' . $input_id],
                'street_address' => $address['street_address_' . $input_id],
                'street_number' => $address['street_number_' . $input_id],
                'suburb' => $address['suburb_' . $input_id],
                'city' => $address['city_' . $input_id],
                'state' => $address['state_' . $input_id],
                'zip' => $address['zip_' . $input_id],
                'country' => $address['country_' . $input_id],
                'place_id' => $address['place_id_' . $input_id],
                'latitude' => $address['latitude_' . $input_id],
                'longitude' => $address['longitude_' . $input_id],
                'location_url' => $address['location_url_' . $input_id],
                'full_json_response' => $address['json_response_' . $input_id],
                'status' => true,
                'set_as_default' => false
            ]);
        }
    }

    /**
     * @param int $user_id
     * @param string $customer_contact
     * @return int
     */
    private function updateOrCreate(int $user_id, string $customer_contact): int
    {
        return CustomerContact::updateOrCreate(
            ['user_id' => $user_id,
                'customer_contact' => $customer_contact
            ],
            [
                'user_id' => $user_id,
                'customer_contact' => $customer_contact
            ]
        )->id;
    }

    /**
     * @param $job_id
     * @param $address
     * @param $type
     * @return mixed
     */
    private function makeNewJobAddress($job_id, $address, $type)
    {
        $newAddress = JobAddress::where('job_id', $job_id)->where('type', $type)->first();
        if ($newAddress) {
            $newAddress->company_name = $address['company_name_' . $type];
            $newAddress->street_address = $address['street_address_' . $type];
            $newAddress->street_number = $address['street_number_' . $type];
            $newAddress->suburb = $address['suburb_' . $type];
            $newAddress->city = $address['city_' . $type];
            $newAddress->state = $address['state_' . $type];
            $newAddress->zip = $address['zip_' . $type];
            $newAddress->country = $address['country_' . $type];
            $newAddress->place_id = $address['place_id_' . $type];
            $newAddress->latitude = $address['latitude_' . $type];
            $newAddress->longitude = $address['longitude_' . $type];
            $newAddress->location_url = $address['location_url_' . $type];
            $newAddress->full_json_response = $address['json_response_' . $type];
            $newAddress->save();
            return $newAddress;
        } else {
            return JobAddress::create([
                'job_id' => $job_id,
                'type' => $type,
                'company_name' => $address['company_name_' . $type],
                'street_address' => $address['street_address_' . $type],
                'street_number' => $address['street_number_' . $type],
                'suburb' => $address['suburb_' . $type],
                'city' => $address['city_' . $type],
                'state' => $address['state_' . $type],
                'zip' => $address['zip_' . $type],
                'country' => $address['country_' . $type],
                'place_id' => $address['place_id_' . $type],
                'latitude' => $address['latitude_' . $type],
                'longitude' => $address['longitude_' . $type],
                'location_url' => $address['location_url_' . $type],
                'full_json_response' => $address['json_response_' . $type]
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $job
     * @return RedirectResponse
     */
    public function show($job): RedirectResponse
    {
        if ($job == 'notify') {
            $jobNotify = JobAssign::where('status', JobAssign::NOT_ASSIGNED)->update(['status' => JobAssign::ASSIGNED]);
            if ($jobNotify) {
                return back()->with('success', 'Jobs notified successfully');
            } else {
                return back()->with('info', 'All drivers are notified');
            }
        }
        return back()->with('error', 'Invalid param!!!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Job $job
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Job $job): RedirectResponse
    {
        $this->validator($request->all(), $job->id)->validate();
        $request->has('van_hire') ? $vanHire = true : $vanHire = false;
        DB::beginTransaction();
        try {
            if ($request->from_add_to_address_book) {
                $this->makeNewAddress($request->customer, $request->all(), 'from');
            }
            if ($request->to_add_to_address_book) {
                $this->makeNewAddress($request->customer, $request->all(), 'to');
            }
            $job->user_id = $request->customer;
            $job->customer_contact_id = $this->updateOrCreate($request->customer, $request->customer_contact);
            $job->from_area_id = $request->from_area_id;
            $job->to_area_id = $request->to_area_id;
            $job->timeframe_id = $request->timeframe_id;
            $job->notes = $request->notes;
            $job->van_hire = $vanHire;
            $job->number_box = $request->number_box;
            $job->save();

            $fromJobAddress = $this->makeNewJobAddress($job->id, $request->all(), 'from');
            $toJobAddress = $this->makeNewJobAddress($job->id, $request->all(), 'to');

            if ($request->has('driver_id')) {
                $jobAssign = JobAssign::where('job_id', $job->id)->where('status', JobAssign::ASSIGNED)->firstOrFail();
                if ($jobAssign->user_id != $request->driver_id) {
                    $jobAssign->status = JobAssign::NOT_ASSIGNED;
                    $jobAssign->save();
                    JobAssign::create([
                        'job_id' => $job->id,
                        'user_id' => $request->driver_id,
                        'status' => JobAssign::NOT_ASSIGNED,
                    ]);
                }
            }
            DB::commit();
            if ($job->wasChanged() || $fromJobAddress->wasChanged() || $toJobAddress->wasChanged()) {
                return redirect()->route('jobs.index')->with('success', 'Job Updated successfully');
            }
            return back()->with('info', 'No changes have made.');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Job $job
     * @return Application|Factory|View
     */
    public function edit(Job $job)
    {
        return view('template.customer.job.edit_job', compact('job'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Job $job
     * @return RedirectResponse
     */
    public function destroy(Job $job): RedirectResponse
    {
        DailyJob::where('job_id', $job->id)->delete();
        JobAssign::where('job_id', $job->id)->delete();
        JobAddress::where('job_id', $job->id)->delete();
        $job->delete();
        return back()->with('success', 'Job Deleted successfully');
    }
}
