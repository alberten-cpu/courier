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

namespace App\Http\Controllers\Driver;

use App\DataTables\Driver\JobDataTable;
use App\DataTables\Driver\AcceptedJobDataTable;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobAssign;
use App\Models\JobStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
     * @param AcceptedJobDataTable $dataTable
     * @return Application|Factory|View
     */
    public function create(AcceptedJobDataTable $dataTable)
    {
        return $dataTable->render('template.driver.job.index_job');
    }

    /**
     * Display the specified resource.
     *
     * @param Job $myjob
     * @return Application|Factory|View
     */
    public function show(Job $myjob)
    {
        return view('template.driver.job.view_job', compact('myjob'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Job $myjob
     * @return RedirectResponse
     */
    public function edit(Job $myjob): RedirectResponse
    {
        $jobAssign = JobAssign::where('job_id', $myjob->id)->where('status', JobAssign::ASSIGNED)
            ->where('user_id', Auth::id())->latest()->first();
        $jobAssign->status = JobAssign::JOB_ACCEPTED;
        $jobAssign->save();
        $myjob->status_id = JobStatus::DELIVERY_ACCEPTED;
        $myjob->save();
        if ($jobAssign->wasChanged() && $myjob->wasChanged()) {
            return back()->with('success', 'Job Accepted successfully');
        }
        return back()->with('info', 'Job Is Not Accepted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Job $myjob
     * @return RedirectResponse
     */
    public function destroy(Job $myjob): RedirectResponse
    {
        $jobAssign = JobAssign::where('job_id', $myjob->id)->where('status', JobAssign::ASSIGNED)
            ->where('user_id', Auth::id())->latest()->first();
        $jobAssign->status = JobAssign::JOB_REJECTED;
        $jobAssign->save();
        $myjob->status_id = JobStatus::DELIVERY_REJECTED;
        $myjob->save();
        if ($jobAssign->wasChanged() && $myjob->wasChanged()) {
            return back()->with('success', 'Job Rejected successfully');
        }
        return back()->with('info', 'Job Is Not Rejected');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Job $myjob
     * @return RedirectResponse
     */
    public function update(Request $request, Job $myjob): RedirectResponse
    {
        $myjob->status_id = $request->status;
        $myjob->save();
        if ($myjob->wasChanged()) {
            return back()->with('success', 'Job Status changed');
        }
        return back()->with('info', 'Job Status is not changed');
    }
}
