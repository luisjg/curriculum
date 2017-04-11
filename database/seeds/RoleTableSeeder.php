<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('roles')->delete();

		DB::table('roles')->insert([
			['system_name' => 'admin', 			'display_name' => 'Administrator'],
			['system_name' => 'course_manager', 'display_name' => 'Course Manager'],
		]);
	}

}
