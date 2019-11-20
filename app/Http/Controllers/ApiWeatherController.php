<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiWeatherController extends Controller
{




    public function getCity(Request $request)
    {
        // https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&key=YOUR_API_KEY

        $city = new Client();
        $appid = config('services.googlegeo.appid');
        $lat = $request->lat;
        $lng = $request->lng;


        $url =  "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&region=us,+CA&key={$appid}";

        //get city name, possibly state name or country,
        //use geocode api to translate city to lat & lng to city name for darksky api
        //send lat and lng to darkcity api
        $response = $city->request('GET', $url);
        $status = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        $geo = json_decode($body);

        $final = $geo->results[0]->address_components;
        return response($final);
    }



    public function dark(Request $request)
    {



        $dark = new Client();
        $appid = config('services.googlegeo.appid');
        $city = $request->city;
        //$state = $request->state;
        // $address = $city . '' . $state;
        //&region=us
        $url =  "https://maps.googleapis.com/maps/api/geocode/json?address={$city},+CA&key={$appid}";

        //get city name, possibly state name or country,
        //use geocode api to translate city to lat & lng to city name for darksky api
        //send lat and lng to darkcity api
        $response = $dark->request('GET', $url);
        $status = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        $geo = json_decode($body);

        if ($geo->status != 'ZERO_RESULTS') {

            $weather =  $this->darkSky($geo->results[0]->geometry->location);

            $final = json_decode($weather);

            $data = [
                'dark' => $final,
                'address' => [
                    'city' => $geo->results[0]->address_components[0]->long_name,
                    'county' => $geo->results[0]->address_components[1]->long_name,
                    'state' => $geo->results[0]->address_components[2]->short_name,
                    'country' => $geo->results[0]->address_components[3]->short_name,

                ]

            ];
            //$export = json_encode($data);
            return response()->json($data, 200);
        } else {
            return response()->json($geo->status, 404);
        }
















        //return response()->json($lat, 200);
    }

    public function darkSky(Request $request)
    {

        $lat = $request->lat;
        $lng = $request->lng;
        $dark = new Client();
        $appid = config('services.darksky.appid');
        $url = "https://api.darksky.net/forecast/{$appid}/{$lat},{$lng}";

        $response = $dark->request('GET', $url);
        $status = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        return $body;
    }
    public function geoDarkSky(Request $request)
    {

        $lat = $request->lat;
        $lng = $request->lng;
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
