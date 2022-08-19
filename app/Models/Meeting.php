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
use \DateTime;

class Meeting extends Model
{

    /**
     * The table associated with this model
     *
     * @var string
     */
    protected $table = 'omar.classMeetings';

    /**
     * The table's primary key
     * 
     * @var string
     */
    protected $primaryKey = 'classes_id';

    
    /**
     * Set the table to not have an auto-incrementing id
     * 
     * @var bool
     */
    public $incrementing = false;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $hidden = array('created_at', 'updated_at');

    /**
     * Overrides the default start_time attribute to military time
     *
     * @param string $value
     * @return string
     */
	public function getStartTimeAttribute($value)
	{
		$date = new DateTime($value);

		return $date->format('Hi') . 'h';
	}


    /**
     * Overrides the default end_time attribute to military time
     *
     * @param string $value
     * @return string
     */
	public function getEndTimeAttribute($value)
	{
		$date = new DateTime($value);

		return $date->format('Hi') . 'h';
	}

}
