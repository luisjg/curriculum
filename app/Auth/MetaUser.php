<?php namespace METALab\Auth;

use Schema;
use METALab\Auth\Interfaces\MetaAuthenticatableContract;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class MetaUser extends Model implements AuthenticatableContract, MetaAuthenticatableContract {

	use Authenticatable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = "users";

	/**
	 * Constructs a new MetaUser object with an optional table name.
	 *
	 * @param string $table The optional table name to use for the model
	 */
	public function __construct($table="users") {
		$this->table = $table;
	}

	/**
	 * Returns whether this model supports having a remember_token attribute.
	 *
	 * @return boolean
	 */
	public function canHaveRememberToken() {
		return Schema::hasColumn($this->table, 'remember_token');
	}

	// implements MetaAuthenticatableContract#findForAuth
	public static function findForAuth($identifier) {
		return MetaUser::where('id', '=', $identifier)
			->first();
	}

	// implements MetaAuthenticatableContract#findForAuthToken
	public static function findForAuthToken($identifier, $token) {
		return MetaUser::where('id', '=', $identifier)
			->where('remember_token', '=', $token)
			->first();
	}
}