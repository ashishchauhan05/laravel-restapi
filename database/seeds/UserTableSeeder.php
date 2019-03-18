<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_superadmin = Role::where('name', 'superadmin')->first();
        $role_admin = Role::where('name', 'admin')->first();
	    $role_manager  = Role::where('name', 'manager')->first();

	    $superadmin = new User();
	    $superadmin->name = 'Super Admin';
	    $superadmin->email = 'super@user.com';
	    $superadmin->password = bcrypt('super@123');
	    $superadmin->save();
	    $superadmin->roles()->attach($role_superadmin);

	    $superadmin = new User();
	    $superadmin->name = 'Admin';
	    $superadmin->email = 'admin@user.com';
	    $superadmin->password = bcrypt('admin@123');
	    $superadmin->save();
	    $superadmin->roles()->attach($role_admin);

	    $manager = new User();
	    $manager->name = 'Manger';
	    $manager->email = 'manager@user.com';
	    $manager->password = bcrypt('manager@123');
	    $manager->save();
	    $manager->roles()->attach($role_manager);
    }
}
