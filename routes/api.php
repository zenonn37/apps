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



Route::get('/programs', 'ProgramController@index');
Route::get('/programs/{program}', 'ProgramController@show');
Route::post('/programs', 'ProgramController@store');
Route::patch('/programs/{program}', 'ProgramController@update');
Route::delete('/programs/{program}', 'ProgramController@delete');
