<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// users table
		Schema::create('users', function($table)
		{
			$table->increments('id');
		    $table->string('individuals_id', 100);
		    $table->timestamp('last_login_at')->nullable();
		    $table->string('status', 30)->default("Active");
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
		// remove all of the memberships first but ensure the application is on
		// a local environment before doing so
		if(app()->environment() == "local") {
			(new RemoveMembershipsTableSeeder())->run();
		}

		Schema::drop('users');
	}

}
