<?php

class ClassTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		
		DB::table('course_class')->delete();

		$class = array(
			'sterm' => 2143,
			'class_number' => 90,
			'subject' => 'Art',
			'catalog_number' => '100L',
			'title' => 'ART Process Lab',
			'course_id' => 19187,
			'description' => 'Art 100L course desc',
			'units' => 3
		);
		Classes::create($class);

		$class = array(
			'sterm' => 2143,
			'class_number' => 95,
			'subject' => 'Art',
			'catalog_number' => '100L',
			'title' => 'ART Processesing lab with stuff',
			'course_id' => 12345,
			'description' => 'Art 100L course desc',
			'units' => 3
		);
		Classes::create($class);

	}

}