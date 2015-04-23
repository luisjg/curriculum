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
}