<?php

use Illuminate\Database\Seeder;
use App\Subscriber;
class AddSubcribersHashSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscribers = Subscriber::all();
        foreach($subscribers as $subscriber){
            $uuid = hashSubscriber($subscriber->id);
            $subscriber->uuid =  $uuid;
            $subscriber->save();
        }
    }
}
