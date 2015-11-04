<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function(Blueprint $table){
            $table->increments("id");
            $table->string("first_name");
            $table->string("last_name");
            $table->string("email");
            $table->string("status");
            $table->timestamps();
        });
        
        //pivot table.
        Schema::create('subscribers_lists_subscribers', function(Blueprint $table){
            $table->integer("subscribers_list_id")->unsigned();
            $table->integer("subscriber_id")->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("subscribers");
        Schema::drop("subscribers_lists_subscribers");
    }
}
