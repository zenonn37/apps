<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Requests\CityRequest;
use App\Http\Resources\CityResource;
use Illuminate\Http\Request;

class SaveCityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $city = City::all();

        return CityResource::collection($city);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        $city = new City;

        $city->name = $request->name;
        $city->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        return new CityResource($city);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(City $city, CityRequest $request)
    {
        $c = $request->get('name', $city->name);
        $city->name = $c;

        $city->save();



        //return new CityResource($city);

        return response($city);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();

        return response('Deleted', 201);
    }
}
