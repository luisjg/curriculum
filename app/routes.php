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

//class info with current term
Route::get('classes', 'ClassController@index');
Route::get('classes/{id}', 'ClassController@show');

//class info with specific term
Route::get('terms/{term}/classes', 'TermController@classesIndex');
Route::get('terms/{term}/classes/{id}', 'TermController@classesShow');

//course info with current term
Route::get('courses', 'CourseController@index');
Route::get('courses/{id}', 'CourseController@show');

//course info with specific term
Route::get('terms/{term}/courses', 'TermController@coursesIndex');
Route::get('terms/{term}/courses/{id}', 'TermController@coursesShow');