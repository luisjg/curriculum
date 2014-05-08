<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_class', function($table){
			$table->integer('sterm');
			$table->integer('class_number');
			$table->string('subject');
			$table->string('catalog_number');
			$table->string('title');
			$table->integer('course_id');
			$table->string('description');
			$table->integer('units');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->nullable();

			$table->primary(array('sterm', 'class_number'));

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('course_class');
	}

}
