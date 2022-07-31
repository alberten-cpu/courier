<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\JobDataTable;
use App\Http\Controllers\Controller;
use App\Models\AddressBook;
use App\Models\DailyJob;
use App\Models\Job;
use App\Models\JobAssign;
use App\Models\User;
use DataTables;
use DB;
use Helper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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
        return $dataTable->render('template.admin.job.index_job');
    }

    public function getAddress(Request $request)
    {
        if ($request->ajax()) {
            if ($request->user_id) {
                $user = User::with('defaultAddress', 'customer.area')->findOrFail($request->user_id);
                $data = collect($user->defaultAddress);
                return $data->push($user->customer->area);
            }
            if ($request->id) {
                return AddressBook::findOrFail($request->id);
            }
        }
    }

    public function getAddressBook(Request $request)
    {
        if ($request->ajax()) {
            return Helper::getAddressBook($request->user_id);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
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
            $fromAddress = $this->makeNewAddress($request->customer, $request->all(), 'from');
            $toAddress = $this->makeNewAddress($request->customer, $request->all(), 'to');

            $job = Job::create([
                'user_id' => $request->customer,
                'customer_reference' => $request->customer_ref,
                'from_address_id' => $fromAddress->id,
                'to_address_id' => $toAddress->id,
                'from_area_id' => $request->from_area_id,
                'to_area_id' => $request->to_area_id,
                'timeframe_id' => $request->timeframe_id,
                'notes' => $request->notes,
                'van_hire' => $vanHire,
                'number_box' => $request->number_box,
                'status_id' => '1'
            ]);

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
                    'status' => false,
                ]);
            }
            DB::commit();
            return back()->with('success', 'Job Created successfully');
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
                'customer_ref' => ['string'],
                'street_address_from' => ['required'],
                'suburb_from' => ['required'],
                'city_from' => ['required'],
                'state_from' => ['required'],
                'zip_from' => ['required'],
                'country_from' => ['required'],
                'latitude_from' => ['required'],
                'longitude_from' => ['required'],
                'location_url_from' => ['required'],
                'json_response_from' => ['required'],
                'from_area_id' => ['required', 'integer'],
                'street_address_to' => ['required'],
                'suburb_to' => ['required'],
                'city_to' => ['required'],
                'state_to' => ['required'],
                'zip_to' => ['required'],
                'country_to' => ['required'],
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
     * @return AddressBook
     */
    private function makeNewAddress($user_id, $address, $input_id): AddressBook
    {
        if (isset($address[$input_id . '_address_id'])) {
            $newAddress = AddressBook::findOrFail($address[$input_id . '_address_id']);
            $newAddress->street_address = $address['street_address_' . $input_id];
            $newAddress->suburb = $address['suburb_' . $input_id];
            $newAddress->city = $address['city_' . $input_id];
            $newAddress->state = $address['state_' . $input_id];
            $newAddress->zip = $address['zip_' . $input_id];
            $newAddress->country = $address['country_' . $input_id];
            $newAddress->latitude = $address['latitude_' . $input_id];
            $newAddress->longitude = $address['longitude_' . $input_id];
            $newAddress->location_url = $address['location_url_' . $input_id];
            $newAddress->full_json_response = $address['json_response_' . $input_id];
            if (!$newAddress->isDirty()) {
                $newAddress->save();
                return $newAddress;
            } else {
                return AddressBook::create([
                    'user_id' => $user_id,
                    'street_address' => $address['street_address_' . $input_id],
                    'suburb' => $address['suburb_' . $input_id],
                    'city' => $address['city_' . $input_id],
                    'state' => $address['state_' . $input_id],
                    'zip' => $address['zip_' . $input_id],
                    'country' => $address['country_' . $input_id],
                    'latitude' => $address['latitude_' . $input_id],
                    'longitude' => $address['longitude_' . $input_id],
                    'location_url' => $address['location_url_' . $input_id],
                    'full_json_response' => $address['json_response_' . $input_id],
                    'status' => true,
                    'set_as_default' => false
                ]);
            }
        } else {
            return AddressBook::create([
                'user_id' => $user_id,
                'street_address' => $address['street_address_' . $input_id],
                'suburb' => $address['suburb_' . $input_id],
                'city' => $address['city_' . $input_id],
                'state' => $address['state_' . $input_id],
                'zip' => $address['zip_' . $input_id],
                'country' => $address['country_' . $input_id],
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
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('template.admin.job.create_job');
    }

    /**
     * Display the specified resource.
     *
     * @param Job $job
     * @return Response
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Job $job
     * @return Application|Factory|View
     */
    public function edit(Job $job)
    {
        return view('template.admin.job.edit_job', compact('job'));
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
//        dd($request->from_area_id);
        $this->validator($request->all(), $job->id)->validate();
        $request->has('van_hire') ? $vanHire = true : $vanHire = false;
        DB::beginTransaction();
        try {
            $fromAddress = $this->makeNewAddress($request->customer, $request->all(), 'from');
            $toAddress = $this->makeNewAddress($request->customer, $request->all(), 'to');
            $job->user_id = $request->customer;
            $job->customer_reference = $request->customer_ref;
            $job->from_address_id = $fromAddress->id;
            $job->to_address_id = $toAddress->id;
            $job->from_area_id = $request->from_area_id;
            $job->to_area_id = $request->to_area_id;
            $job->timeframe_id = $request->timeframe_id;
            $job->notes = $request->notes;
            $job->van_hire = $vanHire;
            $job->number_box = $request->number_box;
            $job->save();

            if ($request->has('driver_id')) {
                $jobAssign = JobAssign::where('job_id', $job->id)->where('status', true)->firstOrFail();
                if ($jobAssign->user_id != $request->driver_id) {
                    $jobAssign->status = false;
                    $jobAssign->save();
                    JobAssign::create([
                        'job_id' => $job->id,
                        'user_id' => $request->driver_id,
                        'status' => false,
                    ]);
                }
            }
            DB::commit();
            return back()->with('success', 'Job Updated successfully');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Job $job
     * @return Response
     */
    public function destroy(Job $job)
    {
        //
    }
}
