<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

use \App\Webinar;
use App\SubscribersList;

class WebinarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$webinars = [];
    	$users = [1,2,3];
    	foreach ($users as $uid) {
    		for ($i=0; $i < 5; $i++) {
    			$faker = Faker\Factory::create();
    			$webinar = [
    				'user_id' => $uid,
					'title' => $faker->realText($faker->numberBetween(60,80)),
					'hosts' => $faker->realText($faker->numberBetween(60,80)),
					'share' => $faker->realText($faker->numberBetween(30,50)),
    				'description' => $faker->realText($faker->numberBetween(120,180)),
    				'starts_on' => $faker->dateTime($min = 'now'),
                    'duration' => rand(1,4) . 'h',
                    'timezone' => 'EDT'
    			];
    			
    			$webinar = Webinar::create($webinar);
                $hashedId = hashWebinar($webinar->id);
                $webinar->uuid = $hashedId;
                $webinar->save();
                $webinar->subscribers_lists()->attach(rand(1,3));
                $webinar_subscriber_list = SubscribersList::whereWebinarId($webinar->id)->first();
                $webinar->signup_subscribers_lists()->attach($webinar_subscriber_list->id);
    		}
    	}

    }
}
