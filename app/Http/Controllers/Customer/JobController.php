<?php

namespace App\Http\Controllers\Customer;

use App\DataTables\Customer\JobDataTable;
use App\Http\Controllers\Controller;
use App\Models\AddressBook;
use App\Models\DailyJob;
use App\Models\Job;
use App\Models\JobAssign;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;

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
                'user_id' => Auth::id(),
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
    protected function validator(array $data, integer $id = null)
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
        return AddressBook::create([
            'user_id' => $user_id,
            'address_line_1' => $address,
            'status' => true,
        ])->id;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('template.customer.job.create_job');
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
     * @return Application|Factory|View|Response
     */
    public function edit(Job $job)
    {
        return view('template.customer.job.edit_job', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Job $job
     * @return Response
     */
    public function update(Request $request, Job $job)
    {
        //
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
