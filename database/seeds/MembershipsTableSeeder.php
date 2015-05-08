<?php

use Illuminate\Database\Seeder;
use Curriculum\Models\Membership;

class MembershipsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$memberships = [
			['id' => 'members:103166750', 'role_position' => 'admin'], // matt
			['id' => 'members:102287170', 'role_position' => 'admin'], // trevor
			['id' => 'members:000420312', 'role_position' => 'course_manager'], // nerces
		];

		// add some memberships
		foreach($memberships as $membership) {
			Membership::create([
				'parent_entities_id' => config('app.entity_id'),
				'individuals_id' => $membership['id'],
				'role_position' => $membership['role_position'],
			]);
		}
	}

}