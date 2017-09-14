<?php namespace Curriculum\Models;

use Illuminate\Database\Eloquent\Model;

class ClassMembershipRoster extends Model {

	protected $table = 'nemo.classMemberships';

    protected $primaryKey = 'classes_id';
    public $incrementing = false;
}
