<?php

namespace App\Http\Controllers\Driver;

use App\DataTables\Driver\JobDataTable;
use App\DataTables\Driver\AcceptedJobDataTable;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobAssign;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;

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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(AcceptedJobDataTable $dataTable)
    {
        return $dataTable->render('template.admin.job.index_job');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
     * @return Response
     */
    public function edit(Job $myjob)
    {
        $jobAssign = JobAssign::where('job_id', $myjob->id)->where('status', false)->where('user_id', Auth::id())->latest()->first();
        $jobAssign->status = true;
        $jobAssign->save();
        $myjob->status_id = 2;
        $myjob->save();
        return back()->with('success', 'Job Accepted successfully');
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
    public function destroy(Job $myjob)
    {
        $jobAssign = JobAssign::where('job_id', $myjob->id)->where('status', false)->where('user_id', Auth::id())->latest()->first();
        $jobAssign->delete();
        return back()->with('success', 'Job Rejected successfully');
    }
}
