<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('TermTableSeeder');
		$this->call('ClassTableSeeder');
		$this->call('ClassMeetingTableSeeder');
		$this->call('ClassInstructorTableSeeder');
		
	}

}