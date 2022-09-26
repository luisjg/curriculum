<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// ------------------------------------------------
//
// END TEMPORARY LEGACY ROUTES
//
// ------------------------------------------------
$router->get('/about/version-history', function(){
    return view('pages.about.version-history');
});

// landing page and catch-all
$router->get('/', 'HomeController@getIndex');
