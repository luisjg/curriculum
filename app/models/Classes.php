<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Classes extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'course_class';
	protected $hidden = array('created_at', 'updated_at');

	protected $appends = array('term');

	public function class_meeting()
	{
		return $this->hasOne('ClassMeeting', 'class_number', 'class_number');
	}

	public function class_instructors()
	{
		return $this->hasMany('ClassInstructor', 'class_number', 'class_number');
	}

	//Convert semester term code to Semester-Year format
	public function getTermAttribute()
	{
		$term = $this->sterm;
		$term_codes = array(7 => 'Fall', 3 => 'Spring');
		return $term_codes[$term[3]] . '-' . $term[0] . '0' . $term[1] . $term[2];
	}
}