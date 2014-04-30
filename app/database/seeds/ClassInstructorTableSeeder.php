<?php

class ClassInstructorTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		
		DB::table('class_instructors')->delete();

		$classinstructors = array(
			'sterm' => 2143,
			'class_number' => 90,
			'emplid' => '103850927',
			'instructor_role' => 'Best role ever',
			'instructor' => 'email@gmail.com'
		);
		ClassInstructor::create($classinstructors);

		$classinstructors = array(
			'sterm' => 2143,
			'class_number' => 95,
			'emplid' => '1',
			'instructor_role' => 'Best role ever',
			'instructor' => 'email2@gmail.com'
		);
		ClassInstructor::create($classinstructors);

	}

}