<?php

namespace App\Http\Controllers;

use App\Clock;
use App\Entry;
use App\TimerProject;
use App\Http\Requests\ClockChartRequest;
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






    public function clock_all(){
        $user = auth()->user()->id;
        $oneDay = Carbon::today()->subDays(0);


        $clock = Clock::whereBetween('date',array($oneDay->toDateTimeString(),Carbon::today()->toDateTimeString()))
         ->where('user_id',$user)
         ->orderBy('created_at', 'DESC')
        ->get();

        return ClockResource::collection($clock);
        
    }

    public function clockChart()
    {
        //MYSQL
        //SELECT date, SUM('seconds') AS time
        //FROM clocks 
        //WHERE user_id = $id
        //GROUP BY date

        //we need to total the entries first from ENTRY Model by timer_project_id

        //input that value into TIMERTASK Model seconds column

        //SELECT date, Sum(seconds) as seconds FROM clocks
        //WHERE user_id = $id
        //GROUP BY date

        $user_id = auth()->user()->id;
        $pastSixDays = Carbon::today()->subWeeks(1)->toDateTimeString();
        // $clock = Clock::whereBetween('date', array($pastSixDays, Carbon::today()->toDateTimeString()))
        //     ->where('user_id', $user_id)
        //     ->groupBy('date')
        //     ->get(array(
        //         DB::raw('date'),
        //         DB::raw('SUM(seconds) as seconds'),

        //     ));


            $entry = Entry::whereBetween('new_entry',array($pastSixDays, Carbon::today()->toDateTimeString()))
              ->where('user_id',$user_id)
              ->groupBy('new_entry')
              ->get(array(
                  DB::raw('new_entry as date' ),
                  DB::raw('SUM(seconds) as seconds')

              ));



        return response()->json( $entry);
    }





    public function clockChartProject($id)
    {



        $pastSixDays = Carbon::today()->subWeeks(1)->toDateTimeString();
        $clock = Clock::whereBetween('date', array($pastSixDays, Carbon::today()->toDateTimeString()))
            ->where('timer_project_id', $id)
             ->groupBy('date')
            ->get(array(
                DB::raw('date'),
                DB::raw('SUM(seconds) as seconds'),

            ));



        return response()->json($clock);
    }

    public function filterClockChart(Request $request)
    {
        $user_id = auth()->user()->id;
        $clock = Entry::whereBetween('new_entry', array($request->start, $request->end))
            ->where('user_id', $user_id)
            ->groupBy('new_entry')
            ->get(array(
                DB::raw('new_entry'),
                DB::raw('SUM(seconds) as seconds'),

            ));

        return response()->json($clock);
    }

    public function filterClockChartProject(ClockChartRequest $request, $id)
    {

        $clock = Clock::whereBetween('date', array($request->start, $request->end))
            ->where('timer_project_id', $id)
            ->groupBy('date')
            ->get(array(
                DB::raw('date'),
                DB::raw('SUM(seconds) as seconds'),

            ));

        return response()->json($clock);
    }

    public function clockReport($startDate)
    {
        //$id timer_project_id
        //$startDate number of days to search in the past
        $user_id = auth()->user()->id;
        //set var to today minus days set by user
        $pastDays = Carbon::today()->subDays($startDate);

        $clock = Clock::whereBetween('date', array($pastDays->toDateTimeString(), Carbon::today()->toDateTimeString()))
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->get();

            return ClockResource::collection($clock);
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

        //get project name
        $project = TimerProject::find($request->project_id);

        $clock->date = Carbon::today()->toDateTimeString();
        $clock->user_id = $user_id;
        $clock->project = $project->name;

        $clock->save();
        //add clock entries

        $entries = new Entry();

        $entries->user_id = $user_id;
        $entries->seconds = $req->time;
        $entries->timer_project_id = $req->project_id;
        $entries->clock_id = $clock->id;
        $entries->start_time = $req->start;
        $entries->end_time = $req->end;
        $entries->new_entry = Carbon::today()->toDateString();

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
