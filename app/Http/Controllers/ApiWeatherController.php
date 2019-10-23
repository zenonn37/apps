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
        $address = $request->address;

        $url =  "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&region=us,+CA&key={$appid}";

        //get city name, possibly state name or country,
        //use geocode api to translate city to lat & lng to city name for darksky api
        //send lat and lng to darkcity api
        $response = $dark->request('GET', $url);
        $status = $response->getStatusCode();
        $body = $response->getBody()->getContents();



        return $body;
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
