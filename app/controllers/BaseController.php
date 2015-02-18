<?php

class BaseController extends Controller {

	public function __construct()
	{
		/* The following allows the Clockwork Google Chrome extension to work, MUST be in debug mode */
		$this->beforeFilter(function() {
		    Event::fire('clockwork.controller.start');
		});

		$this->afterFilter(function() {
		    Event::fire('clockwork.controller.end');
		});
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}