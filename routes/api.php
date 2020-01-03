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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//user
Route::get('/user', 'UserController@index')->middleware('auth:api');

//auth
Route::post('/new', 'AuthenicateController@register');
Route::post('/register', 'AuthenicateController@register');
Route::post('/login', 'AuthenicateController@login');
Route::post('/logout', 'AuthenicateController@logout')->middleware('auth:api');


//programs
Route::get('/programs', 'ProgramController@index')->middleware('auth:api');
Route::get('/programs/{program}', 'ProgramController@show')->middleware('auth:api');
Route::post('/programs', 'ProgramController@store')->middleware('auth:api');
Route::patch('/programs/{program}', 'ProgramController@update')->middleware('auth:api');
Route::delete('/programs/{program}', 'ProgramController@destroy')->middleware('auth:api');

//excercise
Route::get('/excercises', 'ExcerciseController@index')->middleware('auth:api');
Route::get('/excercises/{excercise}', 'ExcerciseController@show')->middleware('auth:api');
Route::post('/excercises', 'ExcerciseController@store')->middleware('auth:api');
Route::patch('/excercises/{excercise}', 'ExcerciseController@update')->middleware('auth:api');
Route::delete('/excercises/{excercise}', 'ExcerciseController@destroy')->middleware('auth:api');

Route::get('/activity', 'ActivityController@index');
Route::get('/activity/{activity}', 'ActivityController@show');
Route::post('/activity', 'ActivityController@store');
Route::patch('/activity/{activity}', 'ActivityController@update');
Route::delete('/activity/{activity}', 'ActivityController@destroy');



//Recipe API only
Route::get('/test', 'ApiRecipeController@index');
Route::get('/food/{food}', 'ApiRecipeController@recipe');


//Task API
Route::get('/projects', 'ProjectController@index')->middleware('auth:api');
Route::post('/projects', 'ProjectController@store')->middleware('auth:api');
Route::get('/projects/{project}', 'ProjectController@show')->middleware('auth:api');
Route::patch('/projects/{project}', 'ProjectController@update')->middleware('auth:api');
Route::delete('/projects/{project}', 'ProjectController@destroy')->middleware('auth:api');



Route::get('/tasks', 'TaskController@index')->middleware('auth:api');
Route::get('/tasks/{task}', 'TaskController@search')->middleware('auth:api');
Route::post('/tasks', 'TaskController@store')->middleware('auth:api');
Route::patch('/tasks/{task}', 'TaskController@update')->middleware('auth:api');
Route::delete('/tasks/{task}', 'TaskController@destroy')->middleware('auth:api');


//weatherapi
// Route::get('/city', 'SaveCityController@index');
// Route::get('/city/{city}', 'SaveCityController@search');
// Route::get('/city/{city}', 'SaveCityController@show');
// Route::post('/city', 'SaveCityController@store');
// Route::patch('/city/{city}', 'SaveCityController@update');
// Route::delete('/city/{city}', 'SaveCityController@destroy');

Route::post('/city', 'ApiWeatherController@getCity');
Route::post('/dark', 'ApiWeatherController@dark');
Route::get('/daily', 'ApiWeatherController@daily');
Route::get('/forecast', 'ApiWeatherController@forecast');
Route::post('/darksky', 'ApiWeatherController@darkSky');
Route::post('/geosky', 'ApiWeatherController@geoDarkSky');

//budget api
//accounts
Route::get('/accounts', 'AccountsController@index')->middleware('auth:api');
Route::get('/accounts/{accounts}', 'AccountsController@show')->middleware('auth:api');
Route::post('/accounts', 'AccountsController@store')->middleware('auth:api');
Route::patch('/accounts/{accounts}', 'AccountsController@update')->middleware('auth:api');
Route::delete('/accounts/{accounts}', 'AccountsController@destroy')->middleware('auth:api');
//transactions
Route::get('/month', 'TransactionsController@transMonth')->middleware('auth:api');
Route::get('/worth', 'TransactionsController@netWorth')->middleware('auth:api');
Route::post('/total/{id}', 'TransactionsController@total');
Route::post('/day/{id}', 'TransactionsController@singleDay');
Route::post('/range/{id}', 'TransactionsController@dateRange')->middleware('auth:api');
Route::get('/transactions/{id}', 'TransactionsController@index')->middleware('auth:api');
Route::get('/transactions/{transactions}', 'TransactionsController@show')->middleware('auth:api');
Route::post('/transactions', 'TransactionsController@store')->middleware('auth:api');
Route::patch('/transactions/{transactions}', 'TransactionsController@update')->middleware('auth:api');
Route::delete('/transactions/{id}', 'TransactionsController@destroy')->middleware('auth:api');
//expeneses
Route::get('/expenese', 'ExpenseController@index')->middleware('auth:api');
Route::post('/expenese', 'ExpenseController@store')->middleware('auth:api');
Route::patch('/expenese/{expenese}', 'ExpenseController@update')->middleware('auth:api');
Route::delete('/expenese/{expenese}', 'ExpenseController@destroy')->middleware('auth:api');


//futbol api

// Route::post('/country', 'ApiFutBolController@country');
// Route::get('/teams_league/{id}', 'ApiFutBolController@teamLeague');
// Route::get('/teams_players/{id}', 'ApiFutBolController@teamsPlayers');
//timer projects
Route::get('/timer-projects', 'TimerProjectsController@index')->middleware('auth:api');
Route::post('/timer-projects-new', 'TimerProjectsController@store')->middleware('auth:api');
Route::patch('/timer-projects-update/{project}', 'TimerProjectsController@update')->middleware('auth:api');
Route::delete('/timer-projects-delete/{id}', 'TimerProjectsController@destroy')->middleware('auth:api');

//timer tasks
Route::get('/timer-task/{id}', 'TimerTasksController@index')->middleware('auth:api');
Route::post('/timer-task-new', 'TimerTasksController@store')->middleware('auth:api');
Route::patch('/timer-task-update/{task}', 'TimerTasksController@update')->middleware('auth:api');
Route::delete('/timer-task-delete/{id}', 'TimerTasksController@destroy')->middleware('auth:api');
Route::get('/filter-range/{id}/{days}', 'TimerTasksController@filterDateRange')->middleware('auth:api');
Route::get('/timer-tasks-all/{id}', 'TimerTasksController@getAllTasks')->middleware('auth:api');

//timer clock
Route::post('/clock-new', 'ClockController@store')->middleware('auth:api');
Route::get('/clock', 'ClockController@index')->middleware('auth:api');
Route::patch('/clock-new/{clock}', 'ClockController@update')->middleware('auth:api');
Route::delete('/clock-new/{clock}', 'ClockController@destroy')->middleware('auth:api');
Route::get('/filter-clock/{id}/{days}', 'ClockController@filterDateRange')->middleware('auth:api');
Route::get('/clock-all/{id}', 'ClockController@getAllClocks')->middleware('auth:api');
