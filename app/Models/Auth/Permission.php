<?php namespace Curriculum\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'permissions';

	/**
	 * Primary key in the table relationship.
	 *
	 * @var string
	 */
	protected $primaryKey = 'system_name';

	/**
	 * Returns all roles associated with this permission.
	 *
	 * @return Collection:Role
	 */
	public function roles() {
		return $this->belongsToMany('Curriculum\Models\Role', 'permission_role', 'permission_id', 'role_position');
	}
}