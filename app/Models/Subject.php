<?php namespace Curriculum\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model { 

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'omar.subjects';

	/**
	 * Defines the primary key on the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'subjects_id';

	/**
	 * The attributes that are fillable in the model.
	 *
	 * @var array
	 */
	protected $fillable = ['subject', 'name']; 
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['created_at', 'updated_at'];
}