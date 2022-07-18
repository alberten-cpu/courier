<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\getTimeframe;
use App\Models\TimeFrame;
use Illuminate\Http\Request;

class TimeFrameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimeFrame  $timeFrame
     * @return \Illuminate\Http\Response
     */
    public function show(TimeFrame $timeFrame)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimeFrame  $timeFrame
     * @return \Illuminate\Http\Response
     */
    public function edit(TimeFrame $timeFrame)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeFrame  $timeFrame
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeFrame $timeFrame)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeFrame  $timeFrame
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeFrame $timeFrame)
    {
        //
    }

    public function getTimeframe()
    {
        if (\request()->ajax()) {
            $search = request()->search;
            $areas = Timeframe::select('id', 'time_frame')->when(
                $search,
                function ($query) use ($search) {
                    $query->where('time_frame', 'like', '%' . $search . '%');
                }
            )->limit(15)->get();
            $response = array();
            foreach ($areas as $area) {
                $response[] = array(
                    "id" => $area->id,
                    "text" => $area->time_frame
                );
            }
            return response()->json($response);
        }
    }
}
