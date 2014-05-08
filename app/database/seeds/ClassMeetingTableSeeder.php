<?php

class ClassMeetingTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		
		DB::table('class_meeting')->delete();

		$classmeeting = array(
			'sterm' => 2137,
			'class_number' => 12000,
			'meeting_number' => 1,
			'location' => 'JD1156',
			'start_time' => date("Y-m-d H:i:s", mktime(9, 30, 0, 5, 23, 2014)),
			'end_time' => date("Y-m-d H:i:s", mktime(10, 45, 0, 5, 23, 2014)),
			'days' => 'TR'
		);
		ClassMeeting::create($classmeeting);

		$classmeeting = array(
			'sterm' => 2137,
			'class_number' => 12100,
			'meeting_number' => 2,
			'location' => 'JD1156',
			'start_time' => date("Y-m-d H:i:s", mktime(11, 25, 0, 5, 23, 2014)),
			'end_time' => date("Y-m-d H:i:s", mktime(12, 15, 0, 5, 23, 2014)),
			'days' => 'TR',
		);
		ClassMeeting::create($classmeeting);


		$classmeeting = array(
			'sterm' => 2143,
			'class_number' => 10147,
			'meeting_number' => 1,
			'location' => 'AC210',
			'start_time' => date("Y-m-d H:i:s", mktime(8, 25, 0, 5, 23, 2014)),
			'end_time' => date("Y-m-d H:i:s", mktime(10, 5, 0, 5, 23, 2014)),
			'days' => 'MW'
		);
		ClassMeeting::create($classmeeting);

		$classmeeting = array(
			'sterm' => 2143,
			'class_number' => 10148,
			'meeting_number' => 2,
			'location' => 'AC210',
			'start_time' => date("Y-m-d H:i:s", mktime(11, 25, 0, 5, 23, 2014)),
			'end_time' => date("Y-m-d H:i:s", mktime(13, 0, 0, 5, 23, 2014)),
			'days' => 'MW',
		);
		ClassMeeting::create($classmeeting);

	}

}