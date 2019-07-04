<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiRecipeController extends Controller
{
    public function index()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://jsonplaceholder.typicode.com/users');
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        return $body;
    }

    public function recipe($food)
    {

        $app_id = "2ca6f6ca";
        $APP_KEY = "28c1c3572cc75b97828a779955f2f70a";


        $api = "https://api.edamam.com/search?q={$food}&app_id={$app_id}&app_key={$APP_KEY}";



        $client = new Client();
        $response = $client->request('GET', $api);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        return $body;
    }
}
