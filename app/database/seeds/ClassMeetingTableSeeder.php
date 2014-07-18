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
			'start_time' => date("Y-m-d H:i:s", mktime(9, 30, 0, 5, 23, 2014)),
			'end_time' => date("Y-m-d H:i:s", mktime(10, 45, 0, 5, 23, 2014)),
			'days' => 'TR'
		));

		Meeting::create(array(
			'association_id' => 'classes:Fall-2014:12100',
			'term_id' => 2137,
			'term' => 'Fall-2014',
			'class_number' => 12100,
			'meeting_number' => 2,
			'location' => 'JD1156',
			'start_time' => date("Y-m-d H:i:s", mktime(11, 25, 0, 5, 23, 2014)),
			'end_time' => date("Y-m-d H:i:s", mktime(12, 15, 0, 5, 23, 2014)),
			'days' => 'TR',
		));

		Meeting::create(array(
			'association_id' => 'classes:Spring-2014:10147',
			'term_id' => 2143,
			'term' => 'Spring-2014',
			'class_number' => 10147,
			'meeting_number' => 1,
			'location' => 'AC210',
			'start_time' => date("Y-m-d H:i:s", mktime(8, 25, 0, 5, 23, 2014)),
			'end_time' => date("Y-m-d H:i:s", mktime(10, 5, 0, 5, 23, 2014)),
			'days' => 'MW'
		));

		Meeting::create(array(
			'association_id' => 'classes:Spring-2014:10148',
			'term_id' => 2143,
			'term' => 'Spring-2014',
			'class_number' => 10148,
			'meeting_number' => 2,
			'location' => 'AC210',
			'start_time' => date("Y-m-d H:i:s", mktime(11, 25, 0, 5, 23, 2014)),
			'end_time' => date("Y-m-d H:i:s", mktime(13, 0, 0, 5, 23, 2014)),
			'days' => 'MW',
		));
	}

}