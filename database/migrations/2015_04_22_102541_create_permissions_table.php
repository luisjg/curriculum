<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// permissions table
		Schema::create('permissions', function($table)
		{
		    $table->string('system_name', 100)->primary();
		    $table->string('description', 255);
		    $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
		});

		// pivot table to associate roles with permissions
		Schema::create('permission_role', function($table)
		{
			$table->increments('id');
			$table->string('role_id', 100);
			$table->foreign('role_id')->references('system_name')->on('roles');
			$table->string('permission_id', 100);
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));	   
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('permission_role');
		Schema::drop('permissions');
	}

}
