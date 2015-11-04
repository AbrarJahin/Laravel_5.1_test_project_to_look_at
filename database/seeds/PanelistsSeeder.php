<?php

use Illuminate\Database\Seeder;
use \App\User;
use \App\Panelist;

class PanelistsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$panelistUsers = [
    		[
    			'name' => 'Rizvan Tariq',
	    		'email' => 'rizvan@kvsocial.com',
	    		'password' => bcrypt('pass'),
	    		'enabled' => 1,
    		],
    		[
    			'name' => 'Hannah Deloy',
	    		'email' => 'hannah@kvsocial.com',
	    		'password' => bcrypt('pass'),
	    		'enabled' => 1,
    		],
    		[
    			'name' => 'Ronaldo Oroz',
	    		'email' => 'ronaldo@kvsocial.com',
	    		'password' => bcrypt('pass'),
	    		'enabled' => 1,
    		],    		    		
    	];

    	foreach ($panelistUsers as $panelist) {
    		$panelistUser = User::create($panelist);
    		$panelist = new Panelist;
    		$panelist->customer_id = 3;
    		$panelist->user_id = $panelistUser->id;
    		$panelist->save();
    	}
    }
}
