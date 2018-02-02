<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Meeting extends Model
{

    /**
     * The table associated with this model
     *
     * @var string
     */
    protected $table = 'omar.classMeetings';

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