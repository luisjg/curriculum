<?php namespace Curriculum\Models;

use Illuminate\Database\Eloquent\Model,
	Illuminate\Database\Eloquent\ModelNotFoundException;

class Course extends Model { 

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
	public static function findOrFailByCourseId($course_id) {
		$course = self::where('course_id', $course_id)->first();
		if($course == null) {
			throw new ModelNotFoundException();
		}

		return $course;
	}

	/**
	 * Scopes unique subjects with their courses.
	 *
	 * @return Builder|Model
	 */
	public function scopeSubjects($query) {
		return $query->groupBy('subject');
	}

	/**
	 * Scopes courses with the specified subject and catalog number.
	 *
	 * @param string $subject The course subject
	 * @param integer $catalog_number The course catalog number
	 * @return Builder|Model
	 */
	public function scopeWhereSubjectCatalog($query, $subject, $catalog_number) {
		return $query->where('subject', $subject)
			->where('catalog_number', $catalog_number);
	}
}