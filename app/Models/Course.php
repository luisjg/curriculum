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

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Course extends Model
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'omar.courses';

	/**
	 * Defines the primary key on the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'courses_id';

	/**
	 * The attributes that are fillable in the model.
	 *
	 * @var array
	 */
	protected $fillable = ['course_id', 'subject', 'catalog_number', 'title']; 
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['created_at', 'updated_at'];

	/**
	 * Finds a course with the specified course_id. Throws ModelNotFoundException
	 * if the model could not be returned.
	 *
	 * @param integer $course_id The course_id value to use when querying
	 * @throws ModelNotFoundException
	 * @return Course
	 */
	public static function findOrFailByCourseId($course_id)
    {
		$course = self::where('course_id', $course_id)->first();
		if($course == null) {
			throw new ModelNotFoundException();
		}

		return $course;
	}

	/**
	 * Scopes courses with the specified subject and catalog number.
	 *
	 * @param string $subject The course subject
	 * @param integer $catalog_number The course catalog number
	 * @return Builder|Model
	 */
	public function scopeWhereSubjectCatalog($query, $subject, $catalog_number)
    {
		return $query->where('subject', $subject)
			->where('catalog_number', $catalog_number);
	}
}