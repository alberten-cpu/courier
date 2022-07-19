<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\AddressBook;
use App\Models\DailyJob;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use phpDocumentor\Reflection\Types\True_;


class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $request->has('van_hire') ? $van_hire = true : $van_hire = false;
        $today =  date('Y-m-d');
        $job_number = DailyJob::where('date', 'like', '%' . $today . '%')->orderBy('id', 'desc')->first();
        if($job_number == null)
        {
            $job_number = $job_number + 1;
        }
        else{
            $job_number = $job_number->job_number + 1;
        }


        $from_addr = AddressBook::create([

            'user_id' => Auth::user()->id,
            'address_line_1' => $request->from_address,
            'status' => True,
        ]);
        $to_addr = AddressBook::create([

            'user_id' => Auth::user()->id,
            'address_line_1' => $request->to_address,
            'status' => True,
        ]);


        $job = Job::create([

            'user_id' => $request->customer,
            'customer_reference' => $request->customer_ref,
            'from_address_id' => $from_addr->id,
            'to_address_id' => $to_addr->id,
            'from_area_id' => $request->from_area_id,
            'to_area_id' => $request->to_area_id,
            'timeframe_id' => $request->timeframe_id,
            'notes' => $request->notes,
            'van_hire' => $van_hire,
            'number_box' => $request->number_box,
            'job_increment_id' => $job_number,
            'status_id' => '1',
            'created_by' => Auth::user()->id,
        ]);
        $daily_job = DailyJob::create([

            'job_id' => $job->id,
            'job_number' => $job_number,
            'date' => $today,
        ]);

        return back()->with('success', 'Job Created successfully');
    }

    /**
     * Validator for validate data in the request.
     *
     * @param array $data The data
     * @param int|null $id The identifier for update validation
     *
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     **/
    protected function validator(array $data , integer $id = null)
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
                'customer_ref' => ['required', 'string'],
                'from_address' => ['required', 'string'],
                'from_area_id' => ['required', 'integer'],
                'to_address' => ['required', 'string'],
                'to_area_id' => ['required', 'integer']
            ]
        );
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
    public function edit(Job $job)
    {
        //
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
