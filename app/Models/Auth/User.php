<?php namespace Curriculum\Models;

use Config;
use Carbon;
use Illuminate\Database\Eloquent\Collection;
use METALab\Auth\MetaUser;
use METALab\Auth\Interfaces\MetaAuthenticatableContract;

class User extends MetaUser implements MetaAuthenticatableContract {

	/**
	 * Primary key in the table relationship. We need to define this here or
	 * the authenticated user's model won't persist for some reason.
	 *
	 * @var string
	 */
	protected $primaryKey = 'individuals_id';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/**
	 * The attributes that can be auto-filled in the model.
	 *
	 * @var array
	 */
	protected $fillable = array('individuals_id', 'status');

	/**
	 * Constructs a new User object.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Returns the user with the given identifier. This is used primarily by
	 * custom authentication service providers.
	 *
	 * @param string $identifier The identifier to use for retrieval
	 * @return User
	 */
	public static function findForAuth($identifier) {
		$u = User::with('roles.permissions')
			->where('individuals_id', '=', $identifier)
			->first();

		// if there was an actual record, update the last login time
		if(!empty($u)) {
			$u->last_login_at = Carbon::now()->toDateTimeString();
			$u->save();
		}

		return $u;
	}

	/**
	 * Returns the user with the given identifier and Remember Me token. This
	 * is used primarily by custom authentication service providers.
	 *
	 * @param string $identifier The identifier to use for retrieval
	 * @param string $token The token to use for retrieval
	 *
	 * @return User
	 */
	public static function findForAuthToken($identifier, $token) {
		$u = User::with('roles.permissions')
			->where('individuals_id', '=', $identifier)
			->where('remember_token', '=', $token)
			->first();

		// if there was an actual record, update the last login time
		if(!empty($u)) {
			$u->last_login_at = Carbon::now()->toDateTimeString();
			$u->save();
		}

		return $u;
	}

	/*
	|--------------------------------------------------------------------------
	| Permission Functions
	|--------------------------------------------------------------------------
	|
	| Any function that is used to determine roles and permissions
	|
	*/

	/**
	 * Returns whether the user has the specified permission.
	 *
	 * @param string $permission The permission to check
	 * @return boolean
	 *
	 * @example
	 * 
	 * if(!Auth::user()->hasPerm('admin.view')) {
	 *    throw new PermissionDeniedException();
	 * }
	 */
	public function hasPerm($permission) {
		return $this->hasAllPerms([$permission]);
	}

	/**
	 * Returns whether the user has any of the specified permissions.
	 *
	 * @param array $permissions The array of permissions to check
	 * @return boolean
	 *
	 * @example
	 * 
	 * if(!Auth::user()->hasAnyPerm(['admin.view', 'admin.create'])) {
	 *    throw new PermissionDeniedException();
	 * }
	 */
	public function hasAnyPerm($permissions) {
		// iterate over each role
		foreach($this->roles as $role) {
			// iterate over the permissions for the role
			foreach($role->permissions as $perm) {
				if(in_array($perm->system_name, $permissions)) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Returns whether the user has all of the specified permissions.
	 *
	 * @param array $permissions The array of permissions to check
	 * @return boolean
	 *
	 * @example
	 * 
	 * if(!Auth::user()->hasAllPerms(['admin.view', 'admin.create', 'admin.edit'])) {
	 *    throw new PermissionDeniedException();
	 * }
	 */
	public function hasAllPerms($permissions) {
		$found = [];

		// iterate over each role
		foreach($this->roles as $role) {
			// iterate over the permissions for the role
			foreach($role->permissions as $perm) {
				if(in_array($perm->system_name, $permissions)) {
					$found[] = $perm->system_name;
				}
			}
		}

		// ensure all of the permissions were found
		return count(array_unique($found)) == count($permissions);
	}

	/**
	 * Returns whether the user has the specified role.
	 *
	 *
	 * @param string $role The Role to check
	 * @return boolean
	 *
	 * @example
	 * 
	 * if(!Auth::user()->hasRole('admin')) {
	 *    throw new PermissionDeniedException("Message");
	 * }
	 */
	public function hasRole($role) {
		return ($this->roles->where('system_name', $role)->count() > 0);	
	}

	/**
	 * Returns whether the user is active.
	 *
	 * @return boolean
	 */
	public function isActive() {
		return $this->status == "Active";
	}

	/*
	|--------------------------------------------------------------------------
	| ORM Functions
	|--------------------------------------------------------------------------
	|
	| Any function that is used in the ORM due to model relationships
	|
	*/

	/**
	 * Returns the individual associated with this user account.
	 *
	 * @return Individual
	 */
	public function individual() {
		return $this->hasOne('Curriculum\Models\Individual', 'individuals_id');
	}

	/**
	 * Returns the memberships associated with this user.
	 *
	 * @return Collection:Membership
	 */
	public function memberships() {
		return $this->hasMany('Curriculum\Models\Membership', 'individuals_id');
	}

	/**
	 * Returns the roles associated with this user.
	 *
	 * @internal Multiple models use the memberships table
	 * @return Collection:Role
	 */
	public function roles() {

		return $this->belongsToMany('Curriculum\Models\Role', 'nemo.memberships', 'individuals_id', 'role_position')
			->withPivot('parent_entities_id')
			->where('parent_entities_id', '=', config('app.entity_id'));
	}
}
