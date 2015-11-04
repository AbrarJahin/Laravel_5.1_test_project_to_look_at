<?php

use Illuminate\Database\Seeder;
use \App\Subscriber;

class SubscribersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$subscribers = [
    		[
	    		"first_name" => "Anik",
	    		"last_name" => "Hasan",
	    		"email" => "stackoverflow789@gmail.com",
	    		"status" => "Active"
    		],
			[
	    		"first_name" => "M",
	    		"last_name" => "R",
	    		"email" => "mr@kvsocial.com",
	    		"status" => "Active"
    		],
			[
	    		"first_name" => "Platon",
	    		"last_name" => "Mysnyk",
	    		"email" => "platon@kvsocial.com",
	    		"status" => "Active"
    		],
    		[
	    		"first_name" => "Anik",
	    		"last_name" => "Hasan",
	    		"email" => "stackoverflow789@gmail.com",
	    		"status" => "Active"
    		],
			[
	    		"first_name" => "M",
	    		"last_name" => "R",
	    		"email" => "mr@kvsocial.com",
	    		"status" => "Active"
    		],
			[
	    		"first_name" => "Platon",
	    		"last_name" => "Mysnyk",
	    		"email" => "platon@kvsocial.com",
	    		"status" => "Active"
    		],
    		[
	    		"first_name" => "Anik",
	    		"last_name" => "Hasan",
	    		"email" => "stackoverflow789@gmail.com",
	    		"status" => "Active"
    		],
			[
	    		"first_name" => "M",
	    		"last_name" => "R",
	    		"email" => "mr@kvsocial.com",
	    		"status" => "Active"
    		],
			[
	    		"first_name" => "Platon",
	    		"last_name" => "Mysnyk",
	    		"email" => "platon@kvsocial.com",
	    		"status" => "Active"
    		],    		
    	];

    	foreach ($subscribers as $subscriber) {
    		$subscriber = Subscriber::create($subscriber);
    		$subscriber->subscribers_lists()->attach(rand(1,3));
    	}
    }
}
