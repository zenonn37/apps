<?php

namespace App\Http\Controllers;

use App\Clock;
use App\Entry;
use App\TimerProject;
use App\Http\Requests\EntryRequest;
use App\Http\Resources\EntryResource;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EntryController extends Controller
{

    //index
    public function index($id)
    {
        //hold off until charting
    }

    public function entryAll(){

  
        
        $user_id = auth()->user()->id;
         
        

        $pastSixDays = Carbon::today()->subWeeks(1)->toDateTimeString();

        $entry = Entry::where('user_id',$user_id)
        ->whereBetween('new_entry',array($pastSixDays, Carbon::today()->toDateTimeString()))
         
        ->groupBy('new_entry')
        ->get(array(
         DB::raw('new_entry'),

         DB::raw('SUM(seconds) as seconds')
        ));

        return response()->json($entry);
    }


    public function store(EntryRequest $request)
    {

        $user_id = auth()->user()->id;
        $timer_project_id = $request->project_id;
        $entries = new Entry();
        $today = Carbon::today()->toDateString();
       
        $entries->user_id = $user_id;
        $entries->seconds = $request->time;
        $entries->timer_project_id = $timer_project_id;
        $entries->clock_id = $request->clock_id;
        $entries->start_time = $request->start;
        $entries->end_time = $request->end;
        $entries->new_entry = $today;

        $entries->save();
        

        $project = TimerProject::find($timer_project_id);

        $project->touch();


        // $entry = DB::table('entries')->insert(
        //     [
        //         'user_id' => $user_id,
        //          'seconds' => $request->time,
        //          'timer_project_id' => $timer_project_id,
        //          'clock_id' => $request->clock_id,
        //          'start_time' => $request->start,
        //          'end_time' => $request->end,
        //          'new_entry' => DB::raw('curdate()')
        //     ]
        // );



        //we need to total the entries first from ENTRY Model by timer_project_id

        //input that value into TIMERTASK Model seconds column

        // $entry = Entry::where('timer_project_id', $timer_project_id)

        //     ->get(DB::raw('SUM(seconds) as seconds'));

        // $clock = Clock::find($request->clock_id);

        // $clock->seconds = $entry[0]->seconds;

        // $clock->save();


        //output for charts clocks
        // $clock = Clock::where('timer_project_id', $request->project_id)
        // ->get(array(
        //  DB::raw('date'),
        //  DB::raw('seconds')
        // ));





        return new EntryResource($entries);

        // return response()->json('testing');
    }

   
}
