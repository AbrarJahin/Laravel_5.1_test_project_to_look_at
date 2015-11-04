<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebinarsSignupSubscribersListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("webinars_signup_subscribers_lists",function(Blueprint $table){
            $table->integer("webinar_id")->unsigned();
            $table->integer("subscribers_list_id")->unsigned();
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
        Schema::drop("webinars_signup_subscribers_lists");
    }
}
