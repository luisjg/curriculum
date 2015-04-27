<?php namespace Curriculum\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Meeting extends Model {

	protected $table = 'omar.meetings'; 

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $hidden = array('created_at', 'updated_at');

	/* Accessor - This function runs before getting the start_time attribute from db 
	 * 
	 * Change start_time from timestamp to military time
	 */
	public function getStartTimeAttribute($value)
	{
		$date = new DateTime($value);

		return $date->format('Hi') . 'h';
	}

	/* Accessor - This function runs before getting the end_time attribute from db 
	 * 
	 * Change end_time from timestamp to military time
	 */
	public function getEndTimeAttribute($value)
	{
		$date = new DateTime($value);
		
		return $date->format('Hi') . 'h';
	}
	
}