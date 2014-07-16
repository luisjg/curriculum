<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameStermToTermId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('class_instructor', function($table)
		{
		    $table->renameColumn('sterm', 'term_id');
		});

		Schema::table('classes', function($table)
		{
		    $table->renameColumn('sterm', 'term_id');
		});

		Schema::table('meetings', function($table)
		{
		    $table->renameColumn('sterm', 'term_id');
		});

		Schema::table('terms', function($table)
		{
		    $table->renameColumn('sterm', 'term_id');
		});


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('class_instructor', function($table)
		{
		    $table->renameColumn('term_id', 'sterm');
		});

		Schema::table('classes', function($table)
		{
		    $table->renameColumn('term_id', 'sterm');
		});

		Schema::table('meetings', function($table)
		{
		    $table->renameColumn('term_id', 'sterm');
		});

		Schema::table('terms', function($table)
		{
		    $table->renameColumn('term_id', 'sterm');
		});
	}

}
