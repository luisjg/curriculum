<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::rename('term_data', 'terms');
		Schema::rename('course_classes', 'classes');
		Schema::rename('class_meetings', 'meetings');
		Schema::rename('class_instructors', 'class_instructor');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::rename('terms', 'term_data');
		Schema::rename('classes', 'course_classes');
		Schema::rename('meetings', 'class_meetings');
		Schema::rename('class_instructor', 'class_instructors');
	}

}
