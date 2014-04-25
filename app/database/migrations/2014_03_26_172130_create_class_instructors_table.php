<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassInstructorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classinstructors', function($table){
			$table->integer('sterm');
			$table->integer('class_number');
			$table->string('emplid');
			$table->string('instructor_role');
			$table->string('email');
			$table->timestamps();

			$table->primary(array('sterm', 'class_number', 'emplid'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('classinstructors');
	}

}
