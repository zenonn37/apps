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
        $programs = Program::where('user_id', auth()->user()->id)->get();

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

        $program->user_id = auth()->user()->id;
        $program->name = $request->name;
        $program->level = $request->level;
        $program->time = $request->time;
        $program->calories = $request->calories;
        $program->description = $request->description;



        $program->save();


        return new ProgramResource($program);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        return new ProgramResource($program);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Program $program, ProgramRequest $request)
    {
        $program->name = $request->get('name', $program->name);
        $program->description = $request->get('description', $program->description);
        $program->level = $request->get('level', $program->level);
        $program->time = $request->get('time', $program->time);
        $program->calories = $request->get('calories', $program->calories);

        $program->save();

        return new ProgramResource($program);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {

        $program->delete();

        $programs = Program::all();

        return ProgramResource::collection($programs);
    }
}
