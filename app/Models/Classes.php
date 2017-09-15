<?php namespace Curriculum\Models;

use Illuminate\Database\Eloquent\Model;
use Curriculum\Models\ClassMembershipRoster;
use Curriculum\Models\ClassInstructor;
use Curriculum\Models\Meeting;
use Curriculum\Handlers\HandlerUtilities;

/* 'class' is a reserved name */
class Classes extends Model { 

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'omar.classes'; 
	
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
	protected $appends = array('enrollment_count');

	/**
	 * Classes have many meetings (one-to-many relationship)
	 *
	 * @return mixed
	 */  
	public function meetings()
	{
		return $this->hasMany(Meeting::Class, 'classes_id', 'classes_id');
	}

	/**
	 * Classes have many instructors (one-to-many relationship)
	 *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function instructors()
	{
		return $this->hasMany(ClassInstructor::Class, 'classes_id', 'classes_id');
	}

    /**
     * Classes have many enrollment records (one-to-many relationship)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function enrolled()
    {
        return $this->hasMany(ClassMembershipRoster::Class,'classes_id', 'classes_id')
                    ->where('role_position','not like','%Instructor');
    }

	/** 
	 * Treat class list as course list
	 * @internal without a courses table this is the best we can do to get a course list
	*/
	public function scopeGroupAsCourse($query, $term, $showAll) {
		/* Get All Courses */
		$query->groupBy('course_id')
			->orderBy('subject')->orderBy('catalog_number');

		/* Filter By Semester Term */
		$showAll = ($showAll === 'true')?true:false;
		if ($showAll === false) {
			$query->groupBy('term_id')
			->having('term_id', '=', $term);
		}
	}
	/** 
	 * Search class(es) by several different types of candidate keys and identifiers 
	 *
	 * @internal Examples of possible $id
	 *		NAME 					EXAMPLE			 
	 *		classes_id				classes:Summer-14:10472 		
	 * 		class_number			10402
	 *		subject 				comp
 	 *		subject-catalog_number 	comp-160
 	**/
	public function scopeWhereIdentifier($query, $id) {
		/* Init Acceptable ID's */ 
		$classes_id = '';
		$subject = '';
		$catalog_number = '';
		$class_number = '';

		/* ie: classes:Summer-14:10472 */	
		if (HandlerUtilities::isAssociationID($id)) {
			$classes_id = $id;
		}
		
		/* ie: 10402 */	
		if (is_numeric($id)) {
			$class_number = $id;		
		}

		/* ie: comp-160 */	
		if (HandlerUtilities::isSubjectCatelogID($id)) {
			$id_array = explode('-', $id);
			$subject = $id_array[0];
			$catalog_number = $id_array[1];
		}

		/* ie: comp */	
		if (HandlerUtilities::isSubjectID($id)) {
			$subject = $id;
		}

		/* Filter By IDs */
		if ($classes_id) 		$query->where('classes_id', $classes_id);
		if ($subject) 			$query->where('subject', $subject);
		if ($catalog_number) 	$query->where('catalog_number', $catalog_number);
		if ($class_number) 		$query->where('class_number', $class_number);

	}

	/* Only return classes that have specified instructor set */
    public function scopeHasInstructor($query, $instructor) {
        $query->whereHas("instructors", function($q) use ($instructor) {
            $q->where('email', $instructor);
        });
    }
    public function scopeHasClassId($query, $id) {
        $query->whereHas("instructors", function($q) use ($instructor) {
            $q->where('email', $instructor);
        });
    }

    public function getEnrollmentCountAttribute(){
        return $this->enrolled->count();
    }





}