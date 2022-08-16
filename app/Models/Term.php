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

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Term extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'omar.terms';
	
	/**
	 * Primary key in terms table
	 *
	 * @var string
	 */
	protected $primaryKey = 'term_id';

	/**
	 * The specify if the table auto-increments.
	 * 
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * Accessor to remove dash from term, used for views
	 *
	 * @return String
	 */
	public function getTermDisplayAttribute()
    {
		return str_replace("-", " ", $this->term);
	}

	/**
	 * Select first semester that ends soonest after today. If the next term
	 * is within three weeks from starting, use that term instead.
	 *
	 * @return Term
	 */
	public function scopeCurrent($query)
    {
		$terms = $query->nowAndNext(1)->get();
        $current = $terms->first();
        $next = $terms->last();

        // check the next term
        $today = Carbon::today();
        $nextStart = Carbon::parse($next->begin_date);

        // is the next term's start date less than three weeks away?
        $diff = $today->diffInWeeks($nextStart, false);
        if($diff >= 0 && $diff <= 3) {
            // return the next term instead
            return $next;
        }
        return $current;
	}

	/**
	 * Select ${take} number of semesters that ends soonest after today 
	 *
	 * @return Collection<Term>
	 */
	public function scopeNowAndNext($query, $take=2)
    {
		return $query->where('end_date', '>', Carbon::now())
		->orderBy('end_date')->take($take + 1);
	}
}