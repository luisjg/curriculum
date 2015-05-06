<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// requests table
		Schema::create('requests', function($table)
		{
		    $table->increments('id');
		    $table->string('ip', 100);
		    $table->string('path', 255);
		    $table->integer('response_code');
		    $table->boolean('success')->default(true);
		    $table->integer('results');
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
		Schema::drop('requests');
	}

}
