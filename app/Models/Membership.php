<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'nemo.memberships';

	/**
	 * The primary key for the relationship. In reality this is a composite.
	 *
	 * @var string
	 */
	protected $primaryKey = 'individuals_id';

	/**
	 * The attributes that can be auto-filled in the model.
	 *
	 * @var array
	 */
	protected $fillable = [
		'parent_entities_id',
		'individuals_id',
		'role_position',
		'ad_hoc_member',
		'confidential'
	];
}