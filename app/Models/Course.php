<?php namespace Curriculum\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model { 

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'omar.courses';

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