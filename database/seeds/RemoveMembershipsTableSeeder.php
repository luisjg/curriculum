<?php

use Illuminate\Database\Seeder;

class RemoveMembershipsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// delete everything in nemo.memberships relevant to our application
		DB::table('nemo.memberships')
			->where('parent_entities_id', '=', config('app.entity_id'))
			->delete();
	}

}