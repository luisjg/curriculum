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
		Schema::create('meetings', function(Blueprint $table){
			$table->string('association_id');	
			$table->integer('term_id');
			$table->string('term');
			$table->integer('class_number');
			$table->integer('meeting_number');
			$table->string('location');
			$table->string('start_time', 5);
			$table->string('end_time', 5);
			$table->string('days');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->nullable();

			$table->primary(array('term_id', 'class_number'));
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
