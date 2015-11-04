<?php

use Illuminate\Database\Seeder;

use \App\SubscribersList;

class SubscribersListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscribers_lists = [
        	[
        		'name' => "Internal",
        		'description' => "Internal stuffs only",
        		'user_id' => 3,
        	],
        	[
        		'name' => "bonus",
        		'description' => "Bonus people",
        		'user_id' => 1,
        	],
        	[
        		'name' => "Affiliates",
        		'description' => "For affiliates only.",
        		'user_id' => 3,
        	],
        ];
        
        for($i = 1; $i <= 15; $i++){
            $webinar_subscribers_lists[] = [
                'name' => 'webinar_lists_'.$i,
                'description' => 'This is a webinar subscriber list',
                'user_id' => 1,
                'webinar_id' => $i
            ];
        }
        $subscribers_lists = array_merge($subscribers_lists, $webinar_subscribers_lists);
        foreach ($subscribers_lists as $list) {
        	SubscribersList::create($list);
        }
    }
}
