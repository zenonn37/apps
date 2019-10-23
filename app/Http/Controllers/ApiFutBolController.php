<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Unirest;


class ApiFutBolController extends Controller
{

    public function teamsPlayers($id)
    {
        $key = config('services.futbol.appid');

        $response = Unirest\Request::get(
            "https://api-football-v1.p.rapidapi.com/v2/players/team/{$id}",
            array(
                "X-RapidAPI-Host" => "api-football-v1.p.rapidapi.com",
                "X-RapidAPI-Key" => "{$key}"
            )
        );

        $test = $response->body;

        //$array = array_unique($test);

        return response()->json($test);
    }

    public function teamLeague($id)
    {

        $key = config('services.futbol.appid');

        $response = Unirest\Request::get(
            "https://api-football-v1.p.rapidapi.com/v2/teams/league/{$id}",
            array(
                "X-RapidAPI-Host" => "api-football-v1.p.rapidapi.com",
                "X-RapidAPI-Key" => "{$key}"
            )
        );

        return response()->json($response->body);
    }
    public function country(Request $request)
    {
        $key = config('services.futbol.appid');

        $country = $request->country;
        $season = $request->season;


        $response = Unirest\Request::get(
            "https://api-football-v1.p.rapidapi.com/v2/leagues/country/{$country}/{$season}",
            array(
                "X-RapidAPI-Host" => "api-football-v1.p.rapidapi.com",
                "X-RapidAPI-Key" => "{$key}"
            )
        );

        return response()->json($response->body);
    }
}
