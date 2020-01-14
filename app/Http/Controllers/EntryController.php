<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Http\Requests\EntryRequest;
use App\Http\Resources\EntryResource;


class EntryController extends Controller
{

    //index
    public function index($id)
    {
        //hold off until charting
    }


    public function store(EntryRequest $request)
    {

        $user_id = auth()->user()->id;
        $entries = new Entry();

        $entries->user_id = $user_id;
        $entries->seconds = $request->time;
        $entries->timer_project_id = $request->project_id;
        $entries->clock_id = $request->clock_id;
        $entries->start_time = $request->start;
        $entries->end_time = $request->end;

        $entries->save();

        return new EntryResource($entries);

        // return response()->json('testing');
    }
}
