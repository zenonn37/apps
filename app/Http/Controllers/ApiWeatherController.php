<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiWeatherController extends Controller
{






    public function dark(Request $request)
    {



        $dark = new Client();
        $appid = config('services.googlegeo.appid');
        $city = $request->city;
        $state = $request->state;
        $address = $city . '' . $state;

        $url =  "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&region=us,+CA&key={$appid}";

        //get city name, possibly state name or country,
        //use geocode api to translate city to lat & lng to city name for darksky api
        //send lat and lng to darkcity api
        $response = $dark->request('GET', $url);
        $status = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        $geo = json_decode($body);

        $lat = $geo->results[0]->geometry->location;


        return $this->darkSky($lat);



        //return response()->json($lat, 200);
    }

    public function darkSky($geo)
    {

        $lat = $geo->lat;
        $lng = $geo->lng;
        $dark = new Client();
        $appid = config('services.darksky.appid');
        $url = "https://api.darksky.net/forecast/{$appid}/{$lat},{$lng}";

        $response = $dark->request('GET', $url);
        $status = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        return response($body);
    }




    public function daily(Request $request)
    {

        $client = new Client();
        $city = $request->city;

        $appid = config('services.openweather.appid');


        $api = "api.openweathermap.org/data/2.5/weather?q={$city}&units=imperial&appid={$appid}";

        $response = $client->request('GET', $api);
        $status = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        return $body;
    }

    public function forecast(Request $request)
    {
        $client = new Client();
        $city = $request->city;
        $appid = config('services.openweather.appid');

        $api = "api.openweathermap.org/data/2.5/forecast?q={$city}&units=imperial&appid={$appid}";

        $response = $client->request('GET', $api);
        $status = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        return $body;
    }
}
