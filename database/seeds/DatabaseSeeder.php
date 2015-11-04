<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(UserManagement::class);
        $this->call(SubscribersListsTableSeeder::class);
        $this->call(SubscribersTableSeeder::class);
        $this->call(WebinarSeeder::class);
        $this->call(PanelistsSeeder::class);
        $this->call(QASeeder::class);

        Model::reguard();
    }
}
