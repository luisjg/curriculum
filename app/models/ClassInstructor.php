<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class ClassInstructor extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'class_instructors';
    
	protected $hidden = array('created_at', 'updated_at', 'emplid', 'instructor_role');
}