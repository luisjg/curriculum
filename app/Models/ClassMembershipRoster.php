<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassMembershipRoster extends Model
{

    /**
     * The database table associated with this model
     *
     * @var string
     */
    protected $table = 'nemo.classMemberships';

    /**
     * Specify the primary key on the table
     *
     * @var string
     */
    protected $primaryKey = 'classes_id';

    /**
     * Disable the incrementing feature on the primary key
     *
     * @var bool
     */
    public $incrementing = false;
}
