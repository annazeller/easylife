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
});

Route::get('/home', 'ToDoController@index');

Route::post('/deleteAjax', 'ToDoController@ajaxDelete');
