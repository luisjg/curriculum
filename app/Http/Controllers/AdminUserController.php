<?php namespace Curriculum\Http\Controllers;

use Auth,
	Request,
	Validator;

use Curriculum\Exceptions\PermissionDeniedException;
use Curriculum\Models\Membership,
	Curriculum\Models\Person,
	Curriculum\Models\Role,
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

		$users = User::with('individual')->get();
		// sort the users by last name
		$users->sort(function($a, $b) {
			return strcmp($a->individual->last_name, $b->individual->last_name);
		});

		return view('pages.admin.users.index', compact('users'));
	}

	/**
	 * Handles the display of the Add User page.
	 * GET /admin/users/create
	 *
	 * @return View
	 */
	public function create() {
		// perform permission check
		if(!Auth::user()->hasPerm('user.create')) {
			throw new PermissionDeniedException(
				"You do not have permission to access this resource."
			);
		}

		return view('pages.admin.users.create');
	}

	/**
	 * Handles the submission from the Add User page.
	 * POST /admin/users
	 *
	 * @return Response
	 */
	public function store() {
		// perform permission check
		if(!Auth::user()->hasPerm('user.create')) {
			throw new PermissionDeniedException(
				"You do not have permission to access this resource."
			);
		}

		// perform the validation
		$validator = Validator::make(
			$input = [
				'person'	=> Request::get('person')
			],
			$rules = [
				'person'	=> 'required|array'
			],
			$messages = [
				'person.required'	=> 'Please select at least one person to add.'
			]
		);

		// if the validator fails, knock the user back
		if($validator->fails()) {
			return redirect()->back()->withInput()->withErrors($validator);
		}

		// iterate over the array of IDs and create the users that do
		// not already exist
		$numAdded = 0;
		foreach($input['person'] as $person) {
			// ensure the user does not already exist
			if(!User::find($person)) {
				// create the user
				$user = new User();
				$user->individuals_id = $person;
				$user->save();

				// create a default role for the new user
				Membership::create([
					'parent_entities_id' => config('app.entity_id'),
					'individuals_id' => $person,
					'role_position' => 'course_manager'
				]);

				$user->touch();
				$numAdded++;
			}
		}

		// display a success message if any users were added
		if($numAdded > 0) {
			$success = "You have successfully added the selected user(s) to the system.";
			return redirect(route('admin.users.index'))->with('success', $success);
		}
		else
		{
			// no users added so display a failure message
			$errors = ['The selected user(s) already exist in the system.'];
			return redirect()->back()->withInput()->withErrors($errors);
		}
	}

	/**
	 * Handles the display of the Modify User page.
	 * GET /admin/users/{id}/edit
	 *
	 * @param integer $id The ID of the user to modify
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
	 * @param integer $id The ID of the user to update
	 * @return Response
	 */
	public function update($id) {
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

		// perform the validation
		$validator = Validator::make(
			$input = [
				'roles'		=> (Request::has('roles') ? Request::get('roles') : []),
				'active'	=> (Request::has('active') ? Request::get('active') : false)
			],
			$rules = [
				'roles'		=> 'array',
				'active'	=> 'boolean'
			]
		);

		// if the validator failed, knock the user back
		if($validator->fails()) {
			return redirect()->back()->withInput()->withErrors($validator);
		}

		// detach the roles first
		$user->roles()->detach();

		// now attach the new roles if there are any
		if(!empty($input['roles'])) {
			// assign the application ID along with each role
			$user->roles()->attach(
				$input['roles'],
				['parent_entities_id' => config('app.entity_id')]
			);
		}

		// now process the activity flag
		$user->status = ($input['active'] ? "Active" : "Inactive");
		$user->save();
		$user->touch();

		// send the user back with a success message
		$success = "You have successfully updated the record for " .
			$user->individual->common_name . ".";
		return redirect(route('admin.users.index'))->with('success', $success);
	}

	/**
	 * Performs a full-name search for people with a specified query string.
	 * Returns the results as JSON.
	 * POST /admin/users/search
	 *
	 * @return string
	 */
	public function search() {
		$query = Request::get('query');
		if(empty($query)) return "{}";

		// now perform the search
		$tokens = explode(" ", $query);
		$people = Person::orderBy('last_name', 'ASC');

		// perform the search based on the type of input received
		if(strpos($query, "@") !== FALSE) {
			$people = $people->where('email', $query);
		}
		else
		{
			// iterate over the tokens to narrow down the search
			foreach($tokens as $token) {
				$people = $people->where('common_name', 'LIKE', "%{$token}%");
			}
		}

		// TODO: remove people from the collection who are already users in the system
		// after retrieving the collection
		$results = $people->get();

		// return the records as JSON
		return $results->toJSON();
	}
}