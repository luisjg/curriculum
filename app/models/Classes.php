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
	protected $appends = array('TermName');

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
	public function scopeWithMeetings($query, $term) {
		$query->with(['meetings' => function($query) use ($term) {
			$query->where('term_id', $term);
		}]);
	}

	/* Only return classes that have specified instructor set */
	public function scopeWithInstructors($query, $term) {
		$query->with(['instructors' => function($query) use ($term) {
			$query->where('term_id', $term);
		}]);
	}

	/* Only return classes that have specified instructor set */
	public function scopeHasInstructor($query, $instructor, $term) {
		$query->whereHas("instructors", function($q) use ($instructor, $term) {
			$q->where('instructor', $instructor)->where('term_id', $term);
		});
	}
}