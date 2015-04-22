<?php namespace Curriculum\Http\Controllers;

use Auth,
	Config,
	Request,
	Validator;
use Illuminate\Support\MessageBag;

class AuthController extends Controller {

	/**
	 * Re-directs to the login page.
	 * GET /auth
	 *
	 * @return Redirect
	 */
	public function getIndex() {
		return redirect('auth/login');
	}

	/**
	 * Renders and returns the login screen.
	 * GET /auth/login
	 *
	 * @return View
	 */
	public function getLogin() {
		return view('pages.auth.login');
	}

	/**
	 * Handles the submission of credentials and authentication operations.
	 * POST /auth/login
	 *
	 * @return Redirect
	 */
	public function postLogin() {
		// grab the provided input
		$username = Request::get('username');
		$password = Request::get('password');

		// place the elements into an array
		$creds = array(
			'username' => $username,
			'password' => $password
		);

		// check to see if the validation passed on the credentials; most of
		// the validate() function can be done in a custom Validator class
		// but for MVP this should be okay.
		$vResult = $this->validateAuth($creds);
		if($vResult === TRUE) {
			// attempt to perform the authentication
			if(Auth::attempt($creds)) {
				// update the last_login_at timestamp
				Auth::user()->last_login_at = date("Y-m-d h:i:s");
				Auth::user()->save();

				// auth successful, so re-direct back to the landing page unless
				// we have a return URL specified
				if(Request::has('return')) {
					return redirect(urldecode(Request::get('return')));
				}

				// if no explicit return URL, use the intended route before we
				// were re-directed to the login page (used when you have the
				// "before auth" filter on a route); if intended route cannot
				// be retrieved for some reason, just redirect to the landing
				// page instead.
				return redirect()->intended('/admin/courses');
			}
			else
			{
				// auth unsuccessful so return to the login page with an
				// instance of MessageBag containing the message
				$errorBag = new MessageBag(array(
					"invalid" => 'Invalid username / password combination or invalid user account.',
				));
				return redirect('auth/login')->with('errors', $errorBag);
			}
		}
		else
		{
			// spit back the error messages to the page
			return redirect('auth/login')->with('errors', $vResult);
		}
	}

	/**
	 * Handles the logout operation.
	 * GET /auth/logout
	 *
	 * @return Redirect
	 */
	public function getLogout() {
		// perform the logout operation
		Auth::logout();

		// re-direct back to the landing page
		return redirect('/');
	}

	/**
	 * Validates the passed data to ensure the login credentials were provided.
	 * Returns true if the validation passes or a set of messages if the
	 * validation fails.
	 *
	 * @param array $data The data to validate
	 * @return boolean|Message-iterator
	 */
	private function validateAuth($data) {
		// ensure that the input passes some basic validation rules
		$validationRules = array(
			"username" => "required",
		);

		// if we don't allow blank passwords, add another validation rule
		if(!config('app.ldap.allow_no_pass')) {
			$validationRules['password'] = 'required';
		}

		// if the validator passed, return true; otherwise, return messages
		$validator = Validator::make($data, $validationRules);
		if($validator->passes()) {
			return true;
		}

		// validator failed so return messages
		return $validator->messages();
	}
}