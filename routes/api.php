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


//programs
Route::get('/programs', 'ProgramController@index')->middleware('auth:api');
Route::get('/programs/{program}', 'ProgramController@show')->middleware('auth:api');
Route::post('/programs', 'ProgramController@store')->middleware('auth:api');
Route::patch('/programs/{program}', 'ProgramController@update')->middleware('auth:api');
Route::delete('/programs/{program}', 'ProgramController@destroy')->middleware('auth:api');


Route::get('/excercises/{id}', 'ExcerciseController@index');
Route::get('/excercises/{excercise}', 'ExcerciseController@show');
Route::post('/excercises', 'ExcerciseController@store');
Route::patch('/excercises/{excercise}', 'ExcerciseController@update');
Route::delete('/excercises/{excercise}', 'ExcerciseController@destroy');
