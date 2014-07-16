<?php

/* 'class' is a reserved name */
class Classes extends Eloquent { 

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'classes'; 
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('created_at', 'updated_at');

	/**
	 * Attribute added to model that doesn't have a corresponding column.
	 * 
	 * @internal This uses the getTermAttribute() accessor in this class.
	 *			 This allows you to add array attributes that do not have
	 *			 a corresponding column in the database.
	 *
	 * @var array
	 */
	protected $appends = array('term');

	/**
	 * Classes have many meetings (one-to-many relationship)
	 *
	 * @return mixed
	 */  
	public function meetings()
	{
		return $this->hasMany('Meeting', 'class_number', 'class_number');
	}

	/**
	 * Classes have many instructors (one-to-many relationship)
	 *
	 * @return mixed
	 */  
	public function instructors()
	{
		return $this->hasMany('ClassInstructor', 'class_number', 'class_number');
	}

	/* Only return classes that have specified instructor set */
	public function scopeHasInstructor($query, $instructor, $term) {
		$query->whereHas("instructors", function($q) use ($instructor, $term) {
			$q->where('instructor', $instructor)->where('term_id', $term);
		});
	}

	/* Accessor - This function runs before getting the Term attribute from db 
	 * 
	 * Converts semester term code to Semester-Year format
	 */
	public function getTermAttribute()
	{
		$term = $this->term_id;
		$term_codes = array(
			1 => 'Winter',
			3 => 'Spring',
			5 => 'Summer',
			7 => 'Fall'			
		);

		return $term_codes[$term[3]] . '-' . $term[0] . '0' . $term[1] . $term[2];
	}

}