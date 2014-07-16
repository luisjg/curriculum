<?php

class ClassInstructor extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'class_instructor'; /* pivot */
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

	protected $hidden = array('created_at', 'updated_at', 'emplid', 'instructor_role');
}