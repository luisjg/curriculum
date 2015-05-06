<?php namespace Curriculum\Models;

use Illuminate\Database\Eloquent\Model;

class LoggedRequest extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'requests';

	/**
	 * Primary key in the table relationship.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';

	/**
	 * Defines the attributes that are fillable.
	 *
	 * @var array
	 */
	protected $fillable = ['ip', 'path', 'response_code', 'success', 'results'];
}