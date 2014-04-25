<?php

class ClassInstructorTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		
		DB::table('classinstructors')->delete();

		$classinstructors = array(
			'sterm' => 2023,
			'class_number' => 90,
			'emplid' => '103850927',
			'instructor_role' => 'Best role ever',
			'email' => 'email@gmail.com'
		);
		ClassInstructor::create($classinstructors);

		$classinstructors = array(
			'sterm' => 2023,
			'class_number' => 95,
			'emplid' => '1',
			'instructor_role' => 'Best role ever',
			'email' => 'email2@gmail.com'
		);
		ClassInstructor::create($classinstructors);

	}

}