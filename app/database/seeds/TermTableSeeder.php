<?php

class TermTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('term_data')->delete();

		Term::create(array(
			'acad_career' => 'Academic Career',
			'sterm' => 2143,
			'description' => 'Spring 2014',
			'description_short' => 'Spring \'14',
			'begin_date' => date("Y-m-d H:i:s", mktime(0, 0, 0, 1, 21, 2014)),
			'end_date' => date("Y-m-d H:i:s", mktime(0, 0, 0, 5, 23, 2016))
		));

		Term::create(array(
			'acad_career' => 'Academic Career',
			'sterm' => 2137,
			'description' => 'Fall 2013',
			'description_short' => 'Fall \'14',
			'begin_date' => date("Y-m-d H:i:s", mktime(0, 0, 0, 8, 24, 2013)),
			'end_date' => date("Y-m-d H:i:s", mktime(0, 0, 0, 12, 23, 2016))
		));
	}

}