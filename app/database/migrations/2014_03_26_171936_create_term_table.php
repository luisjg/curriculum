<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('terms', function($table){
			$table->string('acad_career');
			$table->integer('sterm');
			$table->string('description');
			$table->string('description_short');
			$table->dateTime('begin_date');
			$table->dateTime('end_date');
			$table->timestamps();

			$table->primary(array('acad_career', 'sterm'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('terms');
	}

}
