<?php namespace Curriculum\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Event;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	/**
	 * Constructs a new Controller object.
	 */
	public function __construct() {
		/* The following allows the Clockwork Google Chrome extension to work, MUST be in debug mode */
		$this->beforeFilter(function() {
		    Event::fire('clockwork.controller.start');
		});
		$this->afterFilter(function() {
		    Event::fire('clockwork.controller.end');
		});
	}

}
