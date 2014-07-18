<?php

class ClassTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{	
		DB::table('classes')->delete();

		Classes::create(array(
			'association_id' => 'classes:Fall-2014:12000',
			'term_id' => 2137,
			'term' => 'Fall-2014',
			'class_number' => 12000,
			'subject' => 'Comp',
			'catalog_number' => '110',
			'title' => 'INTRO TO PROGRAMMING',
			'course_id' => 19187,
			'description' => 'Comp 100 course description',
			'units' => 3
		));

		Classes::create(array(
			'association_id' => 'classes:Fall-2014:12100',
			'term_id' => 2137,
			'term' => 'Fall-2014',
			'class_number' => 12100,
			'subject' => 'Comp',
			'catalog_number' => '110L',
			'title' => 'INTRO TO PROGRAMMING LAB',
			'course_id' => 12345,
			'description' => 'Comp 100L course description',
			'units' => 1
		));

		Classes::create(array(
			'association_id' => 'classes:Fall-2014:10147',
			'term_id' => 2143,
			'term' => 'Spring-2014',
			'class_number' => 10147,
			'subject' => 'Art',
			'catalog_number' => '100L',
			'title' => 'ART PROCESS LAB',
			'course_id' => 19187,
			'description' => 'Art 100L course description',
			'units' => 2
		));

		Classes::create(array(
			'association_id' => 'classes:Spring-2014:10148',
			'term_id' => 2143,
			'term' => 'Spring-2014',
			'class_number' => 10148,
			'subject' => 'Art',
			'catalog_number' => '100L',
			'title' => 'ART PROCESS LAB',
			'course_id' => 12345,
			'description' => 'Art 100L course description',
			'units' => 2
		));
	}

}