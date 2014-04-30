<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class ClassMeeting extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'class_meeting';
	protected $hidden = array('created_at', 'updated_at');

	protected $appends = array('start_time', 'end_time');

	//Change start_time from timestamp to military time
	public function getStartTimeAttribute($value)
	{
		$date = new DateTime($value);
		return $date->format('Hi') . 'h';
	}

	//Change end_time from timestamp to military time
	public function getEndTimeAttribute($value)
	{
		$date = new DateTime($value);
		return $date->format('Hi') . 'h';
	}
}