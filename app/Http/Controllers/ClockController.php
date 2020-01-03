<?php

namespace App\Http\Controllers;

use App\Clock;
use App\Http\Requests\ClockRequest;
use App\Http\Resources\ClockResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClockRequest $request)
    {
        //save project clock time
        $clock = new Clock();

        $clock->seconds =  $request->time;
        $clock->timer_project_id = $request->project_id;
        $clock->date = Carbon::today()->toDateTimeString();

        $clock->save();

        return new ClockResource($clock);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
