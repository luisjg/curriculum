<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassMeetingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('class_meeting', function($table){
			$table->integer('sterm');
			$table->integer('class_number');
			$table->integer('meeting_number');
			$table->integer('location');
			$table->dateTime('start_time');
			$table->dateTime('end_time');
			$table->string('days');
			$table->timestamps();

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
		Schema::drop('class_meeting');
	}

}
