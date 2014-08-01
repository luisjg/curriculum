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
		Schema::create('classes', function(Blueprint $table){
			$table->string('association_id');	
			$table->integer('term_id');
			$table->string('term', 15);
			$table->integer('class_number');
			$table->string('subject');
			$table->string('catalog_number', 10);
			$table->string('section_number', 11);
			$table->string('title');
			$table->integer('course_id');
			$table->string('description', 2048);
			$table->integer('units');
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
		Schema::dropIfExists('classes');
	}

}
