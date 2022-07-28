<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\JobDataTable;
use App\Http\Controllers\Controller;
use App\Models\AddressBook;
use App\Models\DailyJob;
use App\Models\Job;
use App\Models\JobAssign;
use DataTables;
use DB;
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
            $fromAddress = $this->createNewAddress(Auth::id(), $request->from_address);
            $toAddress = $this->createNewAddress(Auth::id(), $request->to_address);

            $job_id = Job::create([
                'user_id' => $request->customer,
                'customer_reference' => $request->customer_ref,
                'from_address_id' => $fromAddress,
                'to_address_id' => $toAddress,
                'from_area_id' => $request->from_area_id,
                'to_area_id' => $request->to_area_id,
                'timeframe_id' => $request->timeframe_id,
                'notes' => $request->notes,
                'van_hire' => $vanHire,
                'number_box' => $request->number_box,
                'job_increment_id' => $dailyJobs,
                'status_id' => '1'
            ])->id;

            DailyJob::create([
                'job_id' => $job_id,
                'job_number' => $dailyJobs,
            ]);
            if ($request->has('driver_id')) {
                JobAssign::create([
                    'job_id' => $job_id,
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
                'from_address' => ['required', 'string'],
                'from_area_id' => ['required', 'integer'],
                'to_address' => ['required', 'string'],
                'to_area_id' => ['required', 'integer']
            ]
        );
    }

    private function createNewAddress($user_id, $address)
    {
        $checkIfMatch = AddressBook::where('user_id', $user_id)->where('address_line_1', $address)->firstOrFail();
        if (!$checkIfMatch) {
            return AddressBook::create([
                'user_id' => $user_id,
                'address_line_1' => $address,
                'status' => true,
            ])->id;
        } else {
            return $checkIfMatch->id;
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
            $fromAddress = $this->createNewAddress(Auth::id(), $request->from_address);
            $toAddress = $this->createNewAddress(Auth::id(), $request->to_address);
            $job->user_id = $request->customer;
            $job->customer_reference = $request->customer_ref;
            $job->from_address_id = $fromAddress;
            $job->to_address_id = $toAddress;
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
