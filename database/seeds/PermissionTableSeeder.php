<?php

use Illuminate\Database\Seeder;
use Curriculum\Models\Role;
use Curriculum\Models\Permission;
use Illuminate\Database\Eloquent\Model;

class PermissionTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{		
		Model::unguard();
		DB::table('permission_role')->delete();
		DB::table('permissions')->delete();

		// create some permissions
		DB::table('permissions')->insert([
			['system_name' => 'app.debug.view', 			'description' => 'View application debug data'],
			['system_name' => 'course.create', 				'description' => 'Create a new course'],
			['system_name' => 'course.retrieve', 			'description' => 'View an existing course'],
			['system_name' => 'course.retrieve.all', 		'description' => 'View all existing courses'],
			['system_name' => 'course.modify', 				'description' => 'Modify an existing course'],
			['system_name' => 'user.create', 				'description' => 'Add a user to the system'],
			['system_name' => 'user.retrieve', 				'description' => 'View an existing user'],
			['system_name' => 'user.retrieve.all', 			'description' => 'View all existing users'],
			['system_name' => 'user.modify', 				'description' => 'Modify an existing user'],
		]);

		/* ADMIN PERMISSIONS  */
		$all_permissions = Permission::lists('system_name');
		$admin = Role::where('system_name', 'admin')->first();
		$admin->permissions()->attach($all_permissions);

		/* COURSE MANAGER PERMISSIONS */
		$coursemgr = Role::where('system_name', 'course_manager')->first();
		$coursemgr->permissions()->attach([
			'course.create',
			'course.retrieve',
			'course.retrieve.all',
			'course.modify'
		]);

	}
}
