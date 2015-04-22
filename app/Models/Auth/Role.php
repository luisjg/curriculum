<?php namespace Curriculum\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

	/**
	 * Primary key in the table relationship.
	 *
	 * @var string
	 */
	protected $primaryKey = 'system_name';

	/**
	 * Returns all permissions associated with this role.
	 *
	 * @return Collection:Permission
	 */
	public function permissions() {
		return $this->belongsToMany('Curriculum\Models\Permission', 'permission_role', 'role_id');
	}
}