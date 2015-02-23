<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassInstructorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classInstructor', function(Blueprint $table) {
			$table->string('association_id');
			$table->integer('term_id')->unsigned();
			$table->foreign('term_id')->references('term_id')->on('terms');
			$table->string('term');
			$table->integer('class_number')->unsigned();
			$table->integer('emplid')->unsigned();
			$table->string('instructor_role');
			$table->string('instructor');
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
		Schema::dropIfExists('classInstructor');
	}

}
