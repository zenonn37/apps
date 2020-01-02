<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimerProjectRequest;
use App\Http\Resources\TimerProjectResource;
use App\TimerProject;
use App\TimerTask;
use Illuminate\Http\Request;

class TimerProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = TimerProject::where('user_id', auth()->user()->id)->get();






        return TimerProjectResource::collection($projects);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
