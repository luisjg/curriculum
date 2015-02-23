<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('meetings', function(Blueprint $table) {
			$table->string('association_id');
			$table->integer('term_id')->unsigned();
			$table->foreign('term_id')->references('term_id')->on('terms');
			$table->string('term');
			$table->integer('class_number')->unsigned();
			$table->integer('meeting_number')->unsigned();
			$table->string('location');
			$table->timestamp('start_time');
			$table->timestamp('end_time');
			$table->string('days');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('meetings');
	}

}
