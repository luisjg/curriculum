<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/classes', 'ClassController@index');
Route::get('/classes/{id}', 'ClassController@show');


//USE TERM CONTROLLER
Route::get('/term/{term}/classes', 'TermController@classesIndex');
Route::get('/term/{term}/classes/{id}', 'TermController@classesShow');

Route::get('/courses', 'CourseController@index');
Route::get('/courses/{id}', 'CourseController@show');

Route::get('/term/{term}/courses', 'TermController@coursesIndex');
Route::get('/term/{term}/courses/{id}', 'TermController@coursesShow');