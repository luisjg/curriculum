<?php namespace Curriculum\Models;

use Illuminate\Database\Eloquent\Model;

class ClassMembershipRoster extends Model {

	protected $table = 'nemo.classMemberships_roster';

    protected $primaryKey = 'classes_id';
}
