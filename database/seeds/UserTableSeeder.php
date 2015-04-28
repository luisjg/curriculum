<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->delete();

		DB::table('users')->insert([
			// Admins
			['individuals_id' => 'members:103166750'], // matt - msf61294
			['individuals_id' => 'members:102287170'], // trevor - tmg47373

			// Course Manager
			['individuals_id' => 'members:101739662'], // ryan - rsc93168
		]);
	}
}
