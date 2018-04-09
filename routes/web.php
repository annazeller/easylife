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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('cal', 'gCalendarController');
	Route::get('oauth', ['as' => 'oauthCallback', 'uses' => 'gCalendarController@oauth']);
	Route::get('calendar', function() {
		return view('calendar.index');
	});
    Route::get('/dashboard', 'gCalendarController@dashboard');

    Route::get('/calendar/create', 'gCalendarController@createCalendar');
    Route::post('/calendar/create', 'gCalendarController@doCreateCalendar');

    Route::get('/event/create', 'gCalendarController@createEvent');
    Route::post('/event/create', 'gCalendarController@doCreateEvent');

    Route::get('/calendar/sync', 'gCalendarController@syncCalendar');
    Route::post('/calendar/sync', 'gCalendarController@doSyncCalendar');

    Route::get('/events', 'gCalendarController@listEvents');

    Route::get('users/{user}',  ['as' => 'users.edit', 'uses' => 'UserController@edit']);
    Route::patch('users/{user}/update',  ['as' => 'users.updateProfile', 'uses' => 'UserController@updateProfile']);

    Route::get('/statistics', function() {
        return view('stats');
    });

    Route::get('profile', 'UserController@profile');
    Route::post('profile', 'UserController@update_avatar');

});

Route::get('/home', 'ToDoController@index');
Route::resource('todos','ToDoController');

Route::post('/deleteAjax', 'ToDoController@ajaxDelete');
