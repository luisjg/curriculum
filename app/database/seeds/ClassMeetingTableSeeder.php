<?php

class ClassMeetingTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		
		DB::table('classmeetings')->delete();

		$classmeeting = array(
			'sterm' => 2023,
			'class_number' => 90,
			'meeting_number' => 1,
			'facility_id' => 2,
			'meeting_time_start' => date("Y-m-d H:i:s"),
			'meeting_time_end' => date("Y-m-d H:i:s"),
			'meeting_pattern_code' => 'MWF'
		);
		ClassMeeting::create($classmeeting);

		$classmeeting = array(
			'sterm' => 2023,
			'class_number' => 95,
			'meeting_number' => 1,
			'facility_id' => 10,
			'meeting_time_start' => date("Y-m-d H:i:s"),
			'meeting_time_end' => date("Y-m-d H:i:s"),
			'meeting_pattern_code' => 'MWF',
		);
		ClassMeeting::create($classmeeting);

	}

}