<?php
/*  Curriculum Web Service - Backend that delivers CSUN class and course information.
 *  Copyright (C) 2014-2019 - CSUN META+LAB
 *
 *  Waldo Web Service is free software: you can redistribute it and/or modify it under the terms
 *  of the GNU General Public License as published by the Free Software Found-
 *  ation, either version 3 of the License, or (at your option) any later version.
 *
 *  RetroArch is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 *  without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *  PURPOSE.  See the GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along with RetroArch.
 *  If not, see <http://www.gnu.org/licenses/>.
 */

namespace App\Models;

use App\Handlers\HandlerUtilities;
use Illuminate\Database\Eloquent\Model;

/* 'class' is a reserved name */
class Classes extends Model
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'omar.classes';

	/**
	 * The table primary key.
	 * 
	 * @var string
	 */
	protected $primaryKey = 'classes_id';

	
	/**
	 * The specify if the table auto-increments.
	 * 
	 * @var bool
	 */
	public $incrementing = false;

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
		return $this->hasMany(Meeting::class, 'classes_id', 'classes_id');
	}

	/**
	 * Classes have many instructors (one-to-many relationship)
	 *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function instructors()
	{
		return $this->hasMany(ClassInstructor::class, 'classes_id', 'classes_id');
	}

    /**
     * Classes have many enrollment records (one-to-many relationship)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function enrolled()
    {
        return $this->hasMany(ClassMembershipRoster::class,'classes_id', 'classes_id')
                    ->where('role_position','not like','%Instructor');
    }

	/** 
	 * Treat class list as course list
	 * @internal without a courses table this is the best we can do to get a course list
	*/
	public function scopeGroupAsCourse($query, $term, $showAll)
    {
		/* Get All Courses */
		$query->orderBy('course_id')
			->orderBy('subject')->orderBy('catalog_number');

		/* Filter By Semester Term */
		$showAll = ($showAll === 'true') ? true : false;
		if ($showAll === false) {
			$query->where('term_id', $term)
			->orderBy('term_id');
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
	public function scopeWhereIdentifier($query, $id)
    {
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
			$subject = strtoupper($id_array[0]);
			$catalog_number = $id_array[1];
		}

		/* ie: comp */	
		if (HandlerUtilities::isSubjectID($id)) {
			$subject = strtoupper($id);
		}

		/* Filter By IDs */
		if (!empty($classes_id)) 		$query->where('classes_id', $classes_id);
		if (!empty($subject)) 			$query->where('subject', $subject);
		if (!empty($catalog_number)) 	$query->where('catalog_number', $catalog_number);
		if (!empty($class_number)) 		$query->where('class_number', $class_number);

	}

    /**
     * Scope query which only returns classes that have a specified instructor
     *
     * @param Builder $query
     * @param String $instructor
     */
    public function scopeHasInstructor($query, $instructor)
    {
        $query->whereHas("instructors", function($q) use ($instructor) {
            $q->where('email', $instructor);
        });
    }

    /**
     * Scope query which checks if the instructor exists in the given class
     *
     * @param Builder $query
     * @param string $id
     */
    public function scopeHasClassId($query, $id)
    {
        $query->whereHas("instructors", function($q) use ($id) {
            $q->where('email', $id);
        });
    }

    /**
     * Retrieves the enrollment count and adds it as a custom data attribute
     *
     * @return mixed
     */
    public function getEnrollmentCountAttribute()
    {
        return $this->enrolled->count();
    }





}