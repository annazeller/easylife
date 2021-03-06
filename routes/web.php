<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'ToDoController@welcome');

Route::get('/home', 'HomeController@index')->name('index');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('cal', 'gCalendarController');
	Route::get('oauth', ['as' => 'oauthCallback', 'uses' => 'gCalendarController@oauth']);
	Route::get('calendar', 'gCalendarController@index');
    Route::get('/dashboard', 'gCalendarController@dashboard')->name('dashboard');

    Route::get('/event/create', 'gCalendarController@createEvent');
    Route::post('/event/create', 'gCalendarController@doCreateEvent');

    Route::get('/calendar/sync', 'gCalendarController@syncCalendar');
    Route::post('/calendar/sync', 'gCalendarController@doSyncCalendar');

    Route::get('/events', 'gCalendarController@listEvents')->name('events');

    Route::get('users/{user}',  ['as' => 'users.edit', 'uses' => 'UserController@edit']);
    Route::patch('users/{user}/update',  ['as' => 'users.updateProfile', 'uses' => 'UserController@updateProfile']);

    Route::get('/statistics', function() {
        return view('stats');
    });

    Route::get('profile', 'UserController@profile');
    Route::post('profile', 'UserController@update_avatar');

    Route::get('statistics', 'gChartsController@googleLineChart');

    Route::any('freebusy', 'gCalendarController@getFreeBusy');

    Route::get('/home', 'gCalendarController@index')->name('index');
    Route::resource('todos','ToDoController');
    Route::post('/deleteAjax', 'ToDoController@ajaxDelete');
    Route::post('/done', 'ToDoController@checkToDo');
});

    
    Route::get('/registerquestions', function (){
        return view ('registerquestions');
    });

//Route::put('/registerquestions', 'easyLifeQuestionController@setEasyLifequestions');

Route::post('/registerstep1', 'Auth\RegisterController@step1')->name('registerstep1');
Route::post('/createWithQuestions', 'Auth\RegisterController@create')->name('createWithQuestions');


