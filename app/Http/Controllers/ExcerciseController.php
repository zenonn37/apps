<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ExcerciseResource;
use App\Http\Requests\ExcerciseRequest;
use App\Excercise;

class ExcerciseController extends Controller
{



    public function index()
    {
        //get the excercise model
        $excercise = Excercise::where('user_id', auth()->user()->id)->get();

        return ExcerciseResource::collection($excercise);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExcerciseRequest $request)
    {

        $excercise = new Excercise;

        $excercise->user_id = auth()->user()->id;

        $excercise->name = $request->name;
        $excercise->sets = $request->sets;
        $excercise->reps = $request->reps;
        $excercise->level = $request->level;
        $excercise->instructions = $request->instructions;
        $excercise->failure = $request->failure;
        $excercise->program_id = $request->program_id;

        $excercise->save();

        return new ExcerciseResource($excercise);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Excercise $excercise)

    {
        return new ExcerciseResource($excercise);
    }

    public function update(Excercise $excercise, ExcerciseRequest $request)
    {
        $excercise->name = $request->get('name', $excercise->name);
        $excercise->sets = $request->get('sets', $excercise->sets);
        $excercise->reps = $request->get('reps', $excercise->reps);
        $excercise->level = $request->get('level', $excercise->level);
        $excercise->instructions = $request->get('instructions', $excercise->instructions);
        $excercise->failure = $request->get('failure', $excercise->failure);

        $excercise->save();

        return new ExcerciseResource($excercise);
    }





    public function destroy(Excercise $excercise)
    {
        $excercise->delete();

        return  response()->json('Deleted', 200);
    }
}
