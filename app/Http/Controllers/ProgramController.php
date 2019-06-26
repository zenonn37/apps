<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;
use App\Http\Resources\ProgramResource;
use App\Http\Requests\ProgramRequest;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Program::all();

        return ProgramResource::collection($programs);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramRequest $request)
    {
        $program = new Program;

        $program->name = $request->name;
        $program->level = $request->level;
        $program->time = $request->time;
        $program->calories = $request->calories;
        $program->description = $request->description;
        $program->last_workout = $request->last_workout;
        $program->user_id = $request->user_id;

        $program->save();


        return new ProgramResource($program);
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
