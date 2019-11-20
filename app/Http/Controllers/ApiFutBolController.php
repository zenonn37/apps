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

        $players = $response->body->api->players;

        $pl = json_encode($players, true);

        $en = json_decode($pl);

        $player = array();

        $test = array('test', 'test', 'call');

        $go = array_values(array_unique($players));

        // $compact = [];
        // foreach ($en as $row) {
        //     if (!in_array($row[$key], $compact)) {
        //         $compact[] = $row;
        //     }
        // }
        // $array = array_unique($players);
        //$array =   array_map("array_unique", $test);
        // $array = array_unique($players, SORT_REGULAR);
        // foreach ($array as  $p) {
        //     array_push($player, $p->player_id);
        // }

        return $go; //response()->json($players);
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
