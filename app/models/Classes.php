<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Classes extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'classes';

	public function classmeeting()
	{
		return $this->hasOne('ClassMeeting', 'class_number', 'class_number');
	}

	public function classinstructors()
	{
		return $this->hasMany('ClassInstructor', 'class_number', 'class_number');
	}
}