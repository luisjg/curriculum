<?php namespace METALab\Auth\Provider;


use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use Illuminate\Support\Facades\Config,
    METALab\Auth\Handler\HandlerLDAP;

/**
 * Service provider handler that provides LDAP authentication operations.
 */
class UserProviderLDAP implements UserProvider
{
	private $ldap;
	private $modelName;

	/**
	 * Constructs a new UserProviderLDAP object.
	 */
	public function __construct() {
		$this->ldap = new HandlerLDAP(
			Config::get('app.ldap.host'),
			Config::get('app.ldap.basedn'),
			Config::get('app.ldap.dn'),
			Config::get('app.ldap.password'));

		// set the model name to use as the user model
		$this->modelName = Config::get('auth.model');

		// set whether blank passwords are allowed to be used for auth
		$this->ldap->setAllowNoPass(Config::get('app.ldap.allow_no_pass'));
	}

	/**
 	 * Retrieves the user with the specified credentials from LDAP. Returns null
     * if the user could not be found.
 	 *
 	 * @param array $credentials The credentials to use
 	 * @return User|null
 	 */
    public function retrieveByCredentials(array $credentials) {
    	$u = $credentials['username'];
    	$p = $credentials['password'];

    	// attempt to auth with the credentials provided first
    	try
    	{
	    	if($this->testCredentials($u, $p)) {
	    		// the credentials are valid so let's do the full search with
	    		// the default DN provided through the constructor
	    		$this->ldap->connect();
	    		$result = $this->ldap->searchByUid($u);

	    		$emplId = $this->ldap->getAttributeFromResults($result, "csunPSEmplID");

	    		// grab the first user with the specified attributes
	    		$m = $this->modelName;
	    		return $m::findForAuth("members:{$emplId}");
	    	}
    	}
    	catch(Exception $e)
    	{
    		// LDAP connection failure
    		return null;
    	}

    	// invalid login attempt
    	return null;
    }

	/**
	 * Retrieves the user with the specified identifier from the model.
	 *
	 * @param string $identifier The desired identifier to use
	 * @return User
	 */
    public function retrieveById($identifier) {
    	$m = $this->modelName;
    	return $m::findForAuth($identifier);
    }

    /**
	 * Returns the user with the specified identifier and Remember Me token.
	 *
	 * @param string $identifier The identifier to use
	 * @param string $token The Remember Me token to use
	 * @return User
	 */
	public function retrieveByToken($identifier, $token) {
		$m = $this->modelName;
		return $m::findForAuthToken($identifier, $token);
	}

	/**
	 * Returns whether the credentials provided can be used to authenticate
	 * against the directory.
	 *
	 * @param string $username The username to check
	 * @param string $password The password to check
	 * @return boolean
	 */
	protected function testCredentials($username, $password) {
		return $this->ldap->connect($username, $password);
	}

	/**
	 * Updates the Remember Me token for the specified identifier.
	 *
	 * @param UserInterface $user The user object whose token is being updated
	 * @param string $token The Remember Me token to update
	 */
    public function updateRememberToken(AuthenticatableContract $user, $token) {
	    if(!empty($user)) {
	    	// make sure there is a remember_token field available for
	    	// updating before trying to update; otherwise we run into
	    	// an uncatchable exception
	    	if($user->canHaveRememberToken()) {
	    		$user->remember_token = $token;
	    		$user->save();
	    	}
	    }
    }

    /**
 	 * Validates that the provided credentials match the provided user.
 	 *
 	 * @param UserInterface $user The provided user object
 	 * @param array $credentials The credentials against which to check
 	 * @return boolean
 	 */
    public function validateCredentials(AuthenticatableContract $user, array $credentials) {
    	// our external service, directory, etc. has already verified whether
    	// or not the credentials are valid so the point is moot here; instead,
    	// let's either "return true" to do a pass-through or do a check for
    	// whether the user is actually active and should be allowed to auth in.
		return $user->isActive();
    }
}