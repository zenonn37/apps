<?php

namespace App\Http\Controllers;

use App\Clock;
use App\Entry;
use App\Http\Requests\ClockRequest;
use App\Http\Requests\EntryRequest;
use App\Http\Resources\ClockResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //user id
        $user_id = auth()->user()->id;

        //clock collection
        $pastSixDays = Carbon::today()->subDays(6);
        $clock = Clock::whereBetween('date', array($pastSixDays->toDateTimeString(), Carbon::today()->toDateTimeString()))
            ->where('timer_project_id', $id)
            ->orderBy('date', 'DESC')
            ->get();

        return ClockResource::collection($clock);
    }

    public function clockChart()
    {
        $user_id = auth()->user()->id;
        $pastSixDays = Carbon::today()->subDays(6)->toDateTimeString();
        $clock = Clock::whereBetween('date', array($pastSixDays, Carbon::today()->toDateTimeString()))
            ->where('user_id', $user_id)
            ->groupBy('date')
            ->get(array(
                DB::raw('date'),
                DB::raw('count(*) as clocks')
            ));

        return response()->json($clock);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClockRequest $request, EntryRequest $req)
    {

        $user_id = auth()->user()->id;
        //save project clock time
        $clock = new Clock();

        $clock->seconds =  $request->time;
        $clock->timer_project_id = $request->project_id;
        $clock->date = Carbon::today()->toDateTimeString();
        $clock->user_id = $user_id;

        $clock->save();
        //add clock entries

        $entries = new Entry();

        $entries->user_id = $user_id;
        $entries->seconds = $req->time;
        $entries->timer_project_id = $req->project_id;
        $entries->clock_id = $clock->id;
        $entries->start_time = $req->start;
        $entries->end_time = $req->end;

        $entries->save();



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
