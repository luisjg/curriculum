<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFieldsToMeetingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('meetings', function(Blueprint $table)
		{
			$table->string('association_id')->after('term_id');
			$table->string('term')->after('association_id');
		});
		
		/* Fill in new term field with something like FALL-2014 based on term_id */
		DB::statement("UPDATE meetings SET 
			term = CONCAT(CASE RIGHT(term_id,1)
				WHEN 1 THEN 'Winter'
				WHEN 3 THEN 'Spring'
				WHEN 5 THEN 'Summer'
				WHEN 7 THEN 'Fall'
				ELSE 'unkown'
			END, '-', LEFT(RIGHT(term_id,3),2))
		");

		/* Fill in new association_id field with something like FALL-2014:COMP-160:2 based on term_id */
		DB::statement("UPDATE meetings SET association_id = CONCAT('classes',':',term_id,':',class_number)");
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('meetings', function(Blueprint $table)
		{
			$table->dropColumn('association_id');	
			$table->dropColumn('term');	
		});
	}

}
