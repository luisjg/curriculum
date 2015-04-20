<?php namespace Curriculum\Models;

use Carbon;
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
	 * Accessor to remove dash from term, used for views
	 *
	 * @return String
	 */
	public function getTermDisplayAttribute(){
		return str_replace("-", " ", $this->term);
	}

	/**
	 * Select first semester that ends soonest after today 
	 *
	 * @return Term
	 */
	public function scopeCurrent($query) {
		return $query->nowAndNext()->first();
	}

	/**
	 * Select ${take} number of semesters that ends soonest after today 
	 *
	 * @return Collection<Term>
	 */
	public function scopeNowAndNext($query, $take=2) {
		return $query->where('end_date', '>', Carbon::now())
		->orderBy('end_date')->take($take);
	}
}