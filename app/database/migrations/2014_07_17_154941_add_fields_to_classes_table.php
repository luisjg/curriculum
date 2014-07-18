<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFieldsToClassesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('classes', function(Blueprint $table)
		{
			$table->string('association_id')->after('term_id');
			$table->string('term')->after('association_id');			
		});
	
		
		/* Fill in new term field with something like FALL-2014 based on term_id */
		DB::statement("UPDATE classes SET 
			term = CONCAT(CASE RIGHT(term_id,1)
				WHEN 1 THEN 'Winter'
				WHEN 3 THEN 'Spring'
				WHEN 5 THEN 'Summer'
				WHEN 7 THEN 'Fall'
				ELSE 'unkown'
			END, '-', LEFT(RIGHT(term_id,3),2))
		");

		/* Fill in new association_id field of format classes:term_id:class_number (ie: classes:2147:18346)  */
		DB::statement("UPDATE classes SET association_id = CONCAT('classes',':',CASE RIGHT(term_id,1)
				WHEN 1 THEN 'Winter'
				WHEN 3 THEN 'Spring'
				WHEN 5 THEN 'Summer'
				WHEN 7 THEN 'Fall'
				ELSE 'unkown'
			END, '-', LEFT(RIGHT(term_id,3),2),':',class_number)");	

		DB::statement("DELETE FROM terms where acad_career = 'grad' OR acad_career = 'Academic Career'");

		Schema::table('terms', function(Blueprint $table)
		{
			$table->dropColumn('acad_career');		
		});
		
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('classes', function(Blueprint $table)
		{			
			$table->dropColumn('association_id');	
			$table->dropColumn('term');	
		});

		Schema::table('terms', function(Blueprint $table)
		{
			$table->string('acad_career');		
		});
	}

}
