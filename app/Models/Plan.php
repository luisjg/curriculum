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
	 * Turn off the auto incrementing feature
	 * 
	 * @var boolean
	 */
	public $incrementing = false;

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
	protected $hidden = ['administrative_department_id', 'created_at', 'updated_at'];
}