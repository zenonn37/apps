<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Http\Resources\TaskResource;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $task = Task::where('user_id', auth()->user()->id)->get();
       return TaskResource::collection($task);
    }

    public function search($task){

    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $task = new Task();

        $task->user_id = auth()->user()->id;
        $task->title = $request->title;
        $task->notes = $request->notes;
        $task->priority = $request->priority;
        $task->due_date = $request->due_date;
        $task->project_id = $request->project_id;

        $task->save();



        return new TaskResource($task);


    }

    public function complete(Task $task){


    }

    

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Task $task, TaskRequest $request)
    {
        $task->title = $request->get('title',$request->title);
        $task->notes = $request->get('notes',$request->notes);
        $task->priority = $request->get('priority ',$request->priority);
        $task->due_date = $request->get('due_date ',$request->due_date );

        $task->save();

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json('Destroyed',200);
    }
}
