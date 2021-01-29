<?php

namespace App\Http\Controllers;

use App\Clock;
use App\TimerTask;
use Carbon\Carbon;
use App\TimerProject;
use Illuminate\Http\Request;
use App\Http\Requests\TimerProjectUpdate;
use App\Http\Requests\TimerProjectRequest;
use App\Http\Resources\TimerProjectResource;

class TimerProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bool)
    {

      
        $projects = TimerProject::where('user_id', auth()->user()->id)
            ->where('completed',$bool)
            ->orderBy('updated_at', 'ASC')
            ->get();

        return TimerProjectResource::collection($projects);
    }

    public function search(Request $request){

        $term = $request->term;
        $projects = TimerProject::where('user_id', auth()->user()->id)
        //refactor before final go. escape like term
        ->where('name','like',"%$term%" )
        ->orderBy('updated_at', 'DESC')
        ->get();
        return TimerProjectResource::collection($projects);
       // return response()->json($term);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimerProjectRequest $request)
    {
        $project = new TimerProject;

        $project->name = $request->name;
        $project->goal = $request->goal;
        $project->user_id = auth()->user()->id;

        $project->save();

        return new TimerProjectResource($project);
    }





    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TimerProjectUpdate $request, $id)
    {
        $project  = TimerProject::find($id);

        $project->name = $request->name;
        $project->goal = $request->goal;

        Clock::where('timer_project_id','=',$id)
         ->update(['project' => $request->name ]);
        
       

        if ($request->completed) {
            $project->completed = 1;
            $project->complete = Carbon::today()->toDateTimeString(); # code...
        } else {
            $project->completed = 0;
            $project->complete = NULL; #
        }

        $project->save();

        return new TimerProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TimerProject::destroy($id);

        return response()->json('Deleted', 200);
    }
}
