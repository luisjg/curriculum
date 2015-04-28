<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('UserTableSeeder');
		$this->call('RoleTableSeeder');
		$this->call('PermissionTableSeeder');

		// add all memberships first but ensure the application is on a local
		// environment before doing so
		if(app()->environment() == "local") {
			$this->call('MembershipsTableSeeder');
		}
	}

}
