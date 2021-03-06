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
Route::get('/projects/{boolean}', 'ProjectController@index')->middleware('auth:api');
Route::post('/projects', 'ProjectController@store')->middleware('auth:api');
Route::get('/projects/{project}', 'ProjectController@show')->middleware('auth:api');
Route::patch('/projects/{project}', 'ProjectController@update')->middleware('auth:api');
Route::delete('/projects/{project}', 'ProjectController@destroy')->middleware('auth:api');



Route::get('/tasks', 'TaskController@index')->middleware('auth:api');
Route::get('/tasks/{task}', 'TaskController@search')->middleware('auth:api');
Route::post('/tasks', 'TaskController@store')->middleware('auth:api');
Route::patch('/tasks/{task}', 'TaskController@update')->middleware('auth:api');
Route::delete('/tasks/{task}', 'TaskController@destroy')->middleware('auth:api');




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
Route::get('/account_worth/{id}', 'TransactionsController@acct')->middleware('auth:api');
Route::post('/total/{id}', 'TransactionsController@total');
Route::post('/day/{id}', 'TransactionsController@singleDay');
Route::post('/range/{id}', 'TransactionsController@dateRange')->middleware('auth:api');
Route::get('/transactions/{id}', 'TransactionsController@index')->middleware('auth:api');
Route::get('/transactions/{transactions}', 'TransactionsController@show')->middleware('auth:api');
Route::post('/transactions', 'TransactionsController@store')->middleware('auth:api');
Route::patch('/transactions/{transactions}', 'TransactionsController@update')->middleware('auth:api');
Route::delete('/transactions/{id}', 'TransactionsController@destroy')->middleware('auth:api');
Route::get('/category/{term}/{id}', 'TransactionsController@category')->middleware('auth:api');
Route::get('/search/{term}/{id}', 'TransactionsController@search')->middleware('auth:api');
Route::get('/monthly/{id}','TransactionsController@monthly')->middleware('auth:api');
//expeneses
Route::get('/expense', 'ExpenseController@index')->middleware('auth:api');
Route::get('/expense_total', 'ExpenseController@expense_total')->middleware('auth:api');
Route::post('/expense', 'ExpenseController@store')->middleware('auth:api');
Route::patch('/expense/{expense}', 'ExpenseController@update')->middleware('auth:api');
Route::delete('/expense/{expense}', 'ExpenseController@destroy')->middleware('auth:api');

//expense filters
Route::get('/expense-category/{category}', 'ExpenseController@category')->middleware('auth:api');


//timer projects
Route::get('/timer-projects/{boolean}', 'TimerProjectsController@index')->middleware('auth:api');
Route::post('/timer-projects', 'TimerProjectsController@search')->middleware('auth:api');
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
Route::get('/past-week/{id}', 'TimerTasksController@getPastWeek')->middleware('auth:api');
Route::post('/filter_task_chart', 'TimerTasksController@filterTaskChart')->middleware('auth:api');
Route::get('/global_task_chart', 'TimerTasksController@globalTaskChart')->middleware('auth:api');
Route::post('/filter-task-chart-project/{id}', 'TimerTasksController@filterTaskChartProject')->middleware('auth:api');

//timer clock
Route::post('/clock-new', 'ClockController@store')->middleware('auth:api');
Route::get('/clock_all', 'ClockController@clock_all')->middleware('auth:api');
Route::get('/clock/{id}', 'ClockController@index')->middleware('auth:api');
Route::patch('/clock-update/{clock}', 'ClockController@update')->middleware('auth:api');
Route::delete('/clock-delete/{clock}', 'ClockController@destroy')->middleware('auth:api');
Route::get('/filter-clock/{id}/{days}', 'ClockController@filterDateRange')->middleware('auth:api');
Route::get('/clock-all/{id}', 'ClockController@getAllClocks')->middleware('auth:api');
Route::get('/clock-chart', 'ClockController@clockChart')->middleware('auth:api');
Route::get('/clock-chart/{id}', 'ClockController@clockChartProject')->middleware('auth:api');
Route::post('/clock-chart-filter', 'ClockController@filterClockChart')->middleware('auth:api');
Route::post('/clock-chart-filter-project/{id}', 'ClockController@filterClockChartProject')->middleware('auth:api');
Route::get('/clock_report/{entry}','ClockController@clockReport')->middleware('auth:api');
//Entries
Route::post('/entries-new', 'EntryController@store')->middleware('auth:api');
Route::get('/entries/{id}', 'EntryController@index')->middleware('auth:api');
Route::patch('/entries-update/{id}', 'EntryController@update')->middleware('auth:api');
Route::delete('/entries-delete/{id}', 'EntryController@destroy')->middleware('auth:api');
Route::get('/entry_all','EntryController@entryAll')->middleware('auth:api');

