<?php namespace Curriculum\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model { 

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'omar.plans';

	/**
	 * Defines the primary key on the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'plan_id';

	/**
	 * The attributes that are fillable in the model.
	 *
	 * @var array
	 */
	protected $fillable = ['plan_id', 'plan_type', 'name', 'academic_departments_id', 'administrative_department_id']; 
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['created_at', 'updated_at'];
}