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
		Schema::create('class_meetings', function($table){
			$table->integer('sterm');
			$table->integer('class_number');
			$table->integer('meeting_number');
			$table->string('location');
			$table->dateTime('start_time');
			$table->dateTime('end_time');
			$table->string('days');
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
		Schema::drop('class_meetings');
	}

}
