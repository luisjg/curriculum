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
			'sterm' => 2143,
			'class_number' => 90,
			'meeting_number' => 1,
			'location' => 2,
			'start_time' => date("Y-m-d H:i:s"),
			'end_time' => date("Y-m-d H:i:s"),
			'days' => 'MWF'
		);
		ClassMeeting::create($classmeeting);

		$classmeeting = array(
			'sterm' => 2143,
			'class_number' => 95,
			'meeting_number' => 1,
			'location' => 10,
			'start_time' => date("Y-m-d H:i:s"),
			'end_time' => date("Y-m-d H:i:s"),
			'days' => 'MWF',
		);
		ClassMeeting::create($classmeeting);

	}

}