<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClockChartRequest;
use App\Http\Requests\TaskTimerUpdateRequest;
use App\Http\Requests\TimerTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TimerTaskResource;
use App\TimerTask;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class TimerTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //get current date
        $today = Carbon::today();
        $tasks = TimerTask::where('timer_project_id', $id)
            ->where('date', $today->toDateTimeString())
            ->orderBy('created_at', 'desc')
            ->get();

        return TimerTaskResource::collection($tasks);

        //return response()->json($today->toDateTimeString());
    }

    public function getAllTasks($id)
    {
        $tasks = TimerTask::where('timer_project_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        return TimerTaskResource::collection($tasks);
    }

    public function getPastWeek($id)
    {
        $pastSixDays = Carbon::today()->subDays(6);

        // $test =  DB::table('timer_tasks')
        //     ->select(DB::raw('date'), DB::raw('count(*) as tasks '))
        //     ->where('timer_project_id', $id)
        //     ->where('completed', true)
        //     ->groupBy('date')
        //     ->get();

        $task = TimerTask::whereBetween('date', array($pastSixDays->toDateTimeString(), Carbon::today()->toDateTimeString()))
            ->where('timer_project_id', $id)
            ->where('completed', true)
            ->groupBy('date')
            ->get(array(
                DB::raw('date'),
                DB::raw('count(*) as tasks')
            ));
        return response()->json($task);

        //         $tasks = TimerTask::whereBetween('date', array($pastSixDays->toDateTimeString(), Carbon::today()->toDateTimeString()))
        //             ->where('timer_project_id', $id)
        //             ->orderBy('date', 'desc')
        //             ->get();



        //         //$collection->duplicates();
        //   //$retVal = (condition) ? a : b ;
        //         $collection = TimerTaskResource::collection($tasks);

        //         $newCollection = $collection->map(function($item, $key){
        //                if ($item->date) {
        //                    # code...
        //                }
        //         });
    }


    public function globalTaskChart()
    {

        $user_id = auth()->user()->id;

        $pastSixDays = Carbon::today()->subDays(6);

        $task = TimerTask::whereBetween('date', array($pastSixDays->toDateTimeString(), Carbon::today()->toDateTimeString()))
            ->where('user_id', $user_id)
            ->where('completed', true)
            ->groupBy('date')
            ->get(array(
                DB::raw('date'),
                DB::raw('count(*) as tasks')
            ));
        return response()->json($task);
    }

    public function filterTaskChart(ClockChartRequest $request)
    {
        $user_id = auth()->user()->id;
        $clock = TimerTask::whereBetween('date', array($request->start, $request->end))
            ->where('user_id', $user_id)
            ->groupBy('date')
            ->get(array(
                DB::raw('date'),
                DB::raw('count(*) as tasks')
            ));

        return response()->json($clock);
    }
    public function filterTaskChartProject(ClockChartRequest $request, $id)
    {

        $clock = TimerTask::whereBetween('date', array($request->start, $request->end))
            ->where('timer_project_id', $id)
            ->groupBy('date')
            ->get(array(
                DB::raw('date'),
                DB::raw('count(*) as tasks')
            ));

        return response()->json($clock);
    }

    public function filterDateRange($id, $startDate)
    {
        //$id timer_project_id
        //$startDate number of days to search in the past

        //set var to today minus days set by user
        $pastDays = Carbon::today()->subDays($startDate);

        $tasks = TimerTask::whereBetween('date', array($pastDays->toDateTimeString(), Carbon::today()->toDateTimeString()))
            ->where('timer_project_id', $id)
            ->orderBy('date', 'desc')
            ->get();

        return TimerTaskResource::collection($tasks);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimerTaskRequest $request)
    {
        $task = new TimerTask();

        $task->user_id = auth()->user()->id;
        $task->timer_project_id = $request->timer_project_id;
        $task->name = $request->name;
        $task->actual = $request->actual;
        $task->goal = $request->goal;
        $task->completed = $request->completed;
        $task->complete = Carbon::now();
        $task->date = Carbon::today()->toDateTimeString();

        $task->save();

        return new TimerTaskResource($task);
    }





    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskTimerUpdateRequest $request, $id)
    {
        $task = TimerTask::find($id);

        $task->name = $request->name;

        $task->save();

        return new TimerTaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TimerTask::destroy($id);

        return response()->json('Destroyed', 200);
    }
}
