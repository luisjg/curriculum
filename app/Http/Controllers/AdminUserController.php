<?php namespace Curriculum\Http\Controllers;

use Auth,
	Request,
	Validator;

use Curriculum\Exceptions\PermissionDeniedException;
use Curriculum\Models\User;

class AdminUserController extends Controller {

	/**
	 * Constructs a new AdminUserController object.
	 */
	public function __construct() {
		parent::__construct();

		// ensure the controller makes use of authentication functionality
		$this->middleware('auth');
	}

	/**
	 * Handles the display of the Manage Users page.
	 * GET /admin/users
	 *
	 * @return View
	 */
	public function index() {

	}
}