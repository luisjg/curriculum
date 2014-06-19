<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class ClassMeeting extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'class_meetings';
	
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