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

		$this->call('ClassTableSeeder');
		$this->command->info('Classes table seeded!');

		$this->call('ClassMeetingTableSeeder');
		$this->command->info('ClassMeetings table seeded!');

		$this->call('ClassInstructorTableSeeder');
		$this->command->info('ClassInstructor table seeded!');

		$this->call('TermTableSeeder');
		$this->command->info('TermsTable table seeded!');
	}

}