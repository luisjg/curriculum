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
		Schema::create('classmeetings', function($table){
			$table->integer('sterm');
			$table->integer('class_number');
			$table->integer('meeting_number');
			$table->integer('facility_id');
			$table->dateTime('meeting_time_start');
			$table->dateTime('meeting_time_end');
			$table->string('meeting_pattern_code');
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
		Schema::drop('classmeetings');
	}

}
