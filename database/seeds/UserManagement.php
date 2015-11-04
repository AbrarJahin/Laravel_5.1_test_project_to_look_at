<?php

use Illuminate\Database\Seeder;

use \App\User;
use \App\Role;

class UserManagement extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
        	[
				'name' => 'Admin Admin',
	        	'email' => 'admin@kvsocial.com',
	        	'password' => bcrypt('ufn13d'),
                'enabled' => 1,
        	],
			[
				'name' => 'Admin2 Admin2',
	        	'email' => 'anik@kvsocial.com',
	        	'password' => bcrypt('pass'),
                'enabled' => 1,
        	],
			[
				'name' => 'Anik Hasan',
	        	'email' => 'echoanik@gmail.com',
	        	'password' => bcrypt('pass'),
                'enabled' => 1,
        	],
        ];
        
        $roles = [
        	['name' => 'admin', 'display_name' => 'Administrator', 'description' => ''],
        	['name' => 'customer', 'display_name' => 'Customer', 'description' => ''],
        ];

        foreach ($users as $user) {
        	User::create($user);
        }

        foreach ($roles as $role) {
        	Role::create($role);
        }

        $admin = Role::find(1);
        $customer = Role::find(2);

        $adminUser1 = User::find(1);
        $adminUser1->attachRole($admin);

        $adminUser2 = User::find(2);
        $adminUser2->attachRole($admin);

        $customerUser = User::find(3);
        $customerUser->attachRole($customer);
    }
}
