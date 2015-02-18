<?php

class ClassMeetingTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('meetings')->delete();

		Meeting::create(array(
			'association_id' => 'classes:Fall-2014:12000',
			'term_id' => 2137,
			'term' => 'Fall-2014',
			'class_number' => 12000,
			'meeting_number' => 1,
			'location' => 'JD1156',
			'start_time' => '0930h',
			'end_time' => '1045h',
			'days' => 'TR'
		));

		Meeting::create(array(
			'association_id' => 'classes:Fall-2014:12100',
			'term_id' => 2137,
			'term' => 'Fall-2014',
			'class_number' => 12100,
			'meeting_number' => 2,
			'location' => 'JD1156',
			'start_time' => '1125h',
			'end_time' => '1215h',
			'days' => 'TR',
		));

		Meeting::create(array(
			'association_id' => 'classes:Spring-2014:10147',
			'term_id' => 2143,
			'term' => 'Spring-2014',
			'class_number' => 10147,
			'meeting_number' => 1,
			'location' => 'AC210',
			'start_time' => '0825h',
			'end_time' => '1005h',
			'days' => 'MW'
		));

		Meeting::create(array(
			'association_id' => 'classes:Spring-2014:10148',
			'term_id' => 2143,
			'term' => 'Spring-2014',
			'class_number' => 10148,
			'meeting_number' => 2,
			'location' => 'AC210',
			'start_time' => '1125h',
			'end_time' => '1300h',
			'days' => 'MW',
		));
	}

}