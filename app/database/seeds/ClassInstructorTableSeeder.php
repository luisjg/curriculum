<?php

class ClassInstructorTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('classInstructor')->delete();

		ClassInstructor::create(array(
			'association_id' => 'classes:Fall-2014:12000',
			'term_id' => 2137,
			'term' => 'Fall-2013',
			'class_number' => 12000,
			'emplid' => '1',
			'instructor_role' => 'Best role ever',
			'instructor' => 'ani@csun.edu'
		));

		ClassInstructor::create(array(
			'association_id' => 'classes:Fall-2014:12100',
			'term_id' => 2137,
			'term' => 'Fall-2013',
			'class_number' => 12100,
			'emplid' => '1',
			'instructor_role' => 'Best role ever',
			'instructor' => 'ani@csun.edu'
		));

		ClassInstructor::create(array(
			'association_id' => 'classes:Spring-2014:10147',
			'term_id' => 2143,
			'term' => 'Spring-2014',
			'class_number' => 10147,
			'emplid' => '1',
			'instructor_role' => 'Best role ever',
			'instructor' => 'staff@csun.edu'
		));

		ClassInstructor::create(array(
			'association_id' => 'classes:Spring-2014:10148',
			'term_id' => 2143,
			'term' => 'Spring-2014',
			'class_number' => 10148,
			'emplid' => '1',
			'instructor_role' => 'Best role ever',
			'instructor' => 'pistolesi@csun.edu'
		));
	}

}