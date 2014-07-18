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
		Schema::create('class_instructor', function(Blueprint $table){
			$table->string('association_id');	
			$table->integer('term_id');
			$table->string('term');
			$table->integer('class_number');
			$table->string('emplid');
			$table->string('instructor_role');
			$table->string('instructor');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->nullable();

			$table->primary(array('term_id', 'class_number', 'emplid'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('class_instructor');
	}

}
