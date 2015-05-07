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


// authentication functionality
Route::controller('/auth', 'AuthController');

// admin course functionality
Route::get('/admin', 'AdminCourseController@index');
Route::get('/admin/courses/search', 'AdminCourseController@getSearch');
Route::post('/admin/courses/search', 'AdminCourseController@postSearch');
Route::resource('/admin/courses', 'AdminCourseController');

// admin user functionality
Route::post('/admin/users/search', 'AdminUserController@search');
Route::resource('/admin/users', 'AdminUserController'); 

// API routes
Route::group(['prefix' => '/api'], function() {
	// class info with current term
	Route::get('/classes', 'ClassController@index');
	Route::get('/classes/{id}', 'ClassController@show');

	// class info with specific term
	Route::get('/terms/{term}/classes', 'TermController@classesIndex');
	Route::get('/terms/{term}/classes/{id}', 'TermController@classesShow');

	// course info with current term
	Route::get('/courses', 'CourseController@index');
	Route::get('/courses/{id}', 'CourseController@show');

	// course info with specific term
	Route::get('/terms/{term}/courses', 'TermController@coursesIndex');
	Route::get('/terms/{term}/courses/{id}', 'TermController@coursesShow');
});

// ------------------------------------------------
//
// BEGIN TEMPORARY LEGACY API ROUTES
//
// ------------------------------------------------

// class info with current term
Route::get('/classes', 'ClassController@index');
Route::get('/classes/{id}', 'ClassController@show');

// class info with specific term
Route::get('/terms/{term}/classes', 'TermController@classesIndex');
Route::get('/terms/{term}/classes/{id}', 'TermController@classesShow');

// course info with current term
Route::get('/courses', 'CourseController@index');
Route::get('/courses/{id}', 'CourseController@show');

// course info with specific term
Route::get('/terms/{term}/courses', 'TermController@coursesIndex');
Route::get('/terms/{term}/courses/{id}', 'TermController@coursesShow');

// ------------------------------------------------
//
// END TEMPORARY LEGACY ROUTES
//
// ------------------------------------------------

// landing page and catch-all
Route::controller('/', 'HomeController');