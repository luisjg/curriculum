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


// API routes Version 1.1
Route::group(['prefix' => '/api'], function() {

    Route::group(['prefix' => '/1.1'], function(){

        // class info with current term
	Route::get('/classes', ['uses' => 'ClassController@index', 'version' => '1.1']);
	Route::get('/classes/{id}', ['uses' => 'ClassController@show', 'version' => '1.1']);

	// class info with specific term
	Route::get('/terms/{term}/classes', ['uses' => 'TermController@classesIndex', 'version' => '1.1']);
	Route::get('/terms/{term}/classes/{id}', ['uses' => 'TermController@classesShow', 'version' => '1.1']);

	// course info with current term
	Route::get('/courses', ['uses' => 'CourseController@index', 'version' => '1.1']);
	Route::get('/courses/{id}', ['uses' => 'CourseController@show', 'version' => '1.1']);


	// course info with specific term
	Route::get('/terms/{term}/courses', ['uses' => 'TermController@coursesIndex', 'version' => '1.1']);
	Route::get('/terms/{term}/courses/{id}', ['uses' => 'TermController@coursesShow', 'version' => '1.1']);

	// plan information
	Route::get('/plans', ['uses' => 'PlanController@index', 'version' => '1.1']);
	Route::get('/plans/graduate', ['uses' => 'PlanController@graduateIndex', 'version' => '1.1']);
	Route::get('/plans/{plan}', ['uses' => 'PlanController@show', 'version' => '1.1']);
    });


});


// ------------------------------------------------
//
// BEGIN TEMPORARY LEGACY API ROUTES
//
// ------------------------------------------------

// class info with current term
Route::get('/classes', ['uses' => 'ClassController@index', 'version' => '1.0']);
Route::get('/classes/{id}', ['uses' => 'ClassController@show', 'version' => '1.0']);

// class info with specific term
Route::get('/terms/{term}/classes', ['uses' => 'TermController@classesIndex', 'version' => '1.0']);
Route::get('/terms/{term}/classes/{id}', ['uses' => 'TermController@classesShow', 'version' => '1.0']);

// course info with current term
Route::get('/courses', ['uses' => 'CourseController@index', 'version' => '1.0']);
Route::get('/courses/{id}', ['uses' => 'CourseController@show', 'version' => '1.0']);

// course info with specific term
Route::get('/terms/{term}/courses', ['uses' => 'TermController@coursesIndex', 'version' => '1.0']);
Route::get('/terms/{term}/courses/{id}', ['uses' => 'TermController@coursesShow', 'version' => '1.0']);

// plan information
Route::get('/plans', ['uses' => 'PlanController@index', 'version' => '1.0']);
Route::get('/plans/graduate', 'PlanController@graduateIndex');
Route::get('/plans/{plan}', ['uses' => 'PlanController@Show', 'version' => '1.0']);


// ------------------------------------------------
//
// END TEMPORARY LEGACY ROUTES
//
// ------------------------------------------------
Route::get('/about/version-history', function(){
    return view('pages.about.version-history');
});

// landing page and catch-all
Route::controller('/', 'HomeController');


