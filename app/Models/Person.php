<?php namespace Curriculum\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'people';

	/**
	 * Primary key in the table relationship.
	 *
	 * @var string
	 */
	protected $primaryKey = 'individuals_id';

	/**
	 * Returns the user associated with this individual.
	 *
	 * @return User
	 */
	public function user() {
		return $this->belongsTo("Curriculum\Models\User", "individuals_id");
	}
}