<?php

use Illuminate\Database\Seeder;

use \App\QA;
use \App\Webinar;

class QASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$webinars = Webinar::all();
    	$faker = Faker\Factory::create();
    	foreach ($webinars as $webinar) {
    		for ($i=0; $i < 5; $i++) { 
	    		QA::create([
	    			'webinar_id' => $webinar->id,
	    			'subscriber_id' => rand(1,9),
	    			'panelist_id' => rand(1,3),
	    			'question' => $faker->realText($faker->numberBetween(60,80)),
	    			'answer' => $faker->realText($faker->numberBetween(90,120)),
	    			'public' => 1,
	    		]);
    		}
    	}
    }
}
