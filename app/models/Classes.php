<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Classes extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'classes'; /* 'class' is a reservedname */
	
	protected $hidden = array('created_at', 'updated_at');

	protected $appends = array('term');

	public function meetings()
	{
		return $this->hasMany('Meeting', 'class_number', 'class_number');
	}

	public function instructors()
	{
		return $this->hasMany('ClassInstructor', 'class_number', 'class_number');
	}

	/* Accessor - This function runs before getting the Term attribute from db 
	 * 
	 * Converts semester term code to Semester-Year format
	 */
	public function getTermAttribute()
	{
		$term = $this->sterm;
		$term_codes = array(
			1 => 'Winter',
			3 => 'Spring',
			5 => 'Summer',
			7 => 'Fall'			
		);

		return $term_codes[$term[3]] . '-' . $term[0] . '0' . $term[1] . $term[2];
	}

}