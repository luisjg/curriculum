<?php namespace Curriculum\Exceptions;

use Exception;

class GeneralException extends Exception
{
	/**
	 * Constructs a new GeneralException.
	 *
	 * @param string $message message for the exception
	 */
	public function __construct($message="Invalid action has occured") {
		parent::__construct($message);
	}
}