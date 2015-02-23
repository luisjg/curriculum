<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classes', function(Blueprint $table) {
			$table->string('association_id');
			$table->integer('term_id')->unsigned();
			$table->foreign('term_id')->references('term_id')->on('terms');
			$table->string('term');
			$table->integer('class_number')->unsigned();
			$table->string('subject');
			$table->integer('catalog_number')->unsigned();
			$table->string('title');
			$table->integer('course_id')->unsigned();
			$table->string('description');
			$table->integer('units')->unsigned();
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
		Schema::dropIfExists('classes');
	}

}
