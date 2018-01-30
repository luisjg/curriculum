<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'nemo.individuals';

	/**
	 * Primary key in the table relationship.
	 *
	 * @var string
	 */
	protected $primaryKey = 'individuals_id';

	/**
	 * Returns whether this individual is active.
	 *
	 * @return boolean
	 */
	public function isActive() {
		return $this->affiliation_status == "Active";
	}

	/**
	 * Returns the user associated with this individual.
	 *
	 * @return User
	 */
	public function user() {
		return $this->belongsTo("App\Models\User", "individuals_id");
	}
}