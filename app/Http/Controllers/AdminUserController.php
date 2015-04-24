<?php namespace Curriculum\Http\Controllers;

use Auth,
	Request,
	Validator;

use Curriculum\Exceptions\PermissionDeniedException;
use Curriculum\Models\Role,
	Curriculum\Models\User;

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
		// perform permission check
		if(!Auth::user()->hasPerm('user.retrieve.all')) {
			throw new PermissionDeniedException(
				"You do not have permission to access this resource."
			);
		}

		$users = User::with('individual')->paginate(25);
		return view('pages.admin.users.index', compact('users'));
	}

	/**
	 * Handles the display of the Modify User page.
	 * GET /admin/users/{id}/edit
	 *
	 * @return View
	 */
	public function edit($id) {
		$user = User::findOrFailById($id);

		// perform permission check
		if(!Auth::user()->hasPerm('user.modify')) {
			throw new PermissionDeniedException(
				"You do not have permission to access this resource."
			);
		}
		else if(Auth::user()->individuals_id == $user->individuals_id) {
			throw new PermissionDeniedException(
				"You may not modify your own account."
			);
		}

		// display the Modify User screen
		$roles = Role::orderBy('display_name', 'ASC')->get();
		return view('pages.admin.users.edit', compact('user', 'roles'));
	}

	/**
	 * Handles the submission from the Modify User page.
	 * PUT /admin/users/{id}
	 *
	 * @return Response
	 */
	public function update($id) {

	}
}