<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', 'AuthenicateController@register');
Route::post('/login', 'AuthenicateController@login');


Route::post('/logout', 'AuthenicateController@logout')->middleware('auth:api');



Route::get('/programs', 'ProgramController@index')->middleware('auth:api');;
Route::get('/programs/{program}', 'ProgramController@show')->middleware('auth:api');;
Route::post('/programs', 'ProgramController@store')->middleware('auth:api');;
Route::patch('/programs/{program}', 'ProgramController@update')->middleware('auth:api');;
Route::delete('/programs/{program}', 'ProgramController@destroy')->middleware('auth:api');;
