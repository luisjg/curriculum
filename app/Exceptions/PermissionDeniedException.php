<?php namespace Curriculum\Exceptions;

use Exception;

class PermissionDeniedException extends Exception
{
	/**
	 * Constructs a new PermissionDeniedException.
	 *
	 * @param string $message Optional message for the exception
	 */
	public function __construct($message="You do not have permission to view this page.") {
		parent::__construct($message);
	}
}