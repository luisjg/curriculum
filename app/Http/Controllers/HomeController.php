<?php namespace Curriculum\Http\Controllers;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Constructs a new HomeController object.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Show the landing screen to the user.
	 *
	 * @return Response
	 */
	public function getIndex() {
		return view('pages.wiki.index-metaphor');
	}

}
