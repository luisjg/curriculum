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

		$class = array(
			'sterm' => 2023,
			'class_number' => 90,
			'subject' => 'Art',
			'catalog_number' => '100L',
			'description' => 'ART Process Lab',
			'course_id' => 19187,
			'course_description' => 'Art 100L course desc',
			'course_units' => 3
		);
		Classes::create($class);

		$class = array(
			'sterm' => 2023,
			'class_number' => 95,
			'subject' => 'Art',
			'catalog_number' => '100L',
			'description' => 'ART Processesing lab with stuff',
			'course_id' => 12345,
			'course_description' => 'Art 100L course desc',
			'course_units' => 3
		);
		Classes::create($class);

	}

}