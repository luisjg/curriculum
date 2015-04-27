<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


// class info with current term
Route::get('api/classes', 'ClassController@index');
Route::get('api/classes/{id}', 'ClassController@show');

// class info with specific term
Route::get('api/terms/{term}/classes', 'TermController@classesIndex');
Route::get('api/terms/{term}/classes/{id}', 'TermController@classesShow');

// course info with current term
Route::get('api/courses', 'CourseController@index');
Route::get('api/courses/{id}', 'CourseController@show');

// course info with specific term
Route::get('api/terms/{term}/courses', 'TermController@coursesIndex');
Route::get('api/terms/{term}/courses/{id}', 'TermController@coursesShow');

// landing page and catch-all
Route::controller('/', 'HomeController');