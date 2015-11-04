<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebinarLiveAttendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webinar_live_attenders', function(Blueprint $table)
        {
            $table->increments("id");
            $table->integer("webinar_id");
            $table->string("ip");       //No need to add any defaults, because we don't need them
            //$table->timestamps();   //->default('CURRENT_TIMESTAMP')
            $table->dateTime('time_on');        //No need to add any defaults because it is handled in PHP end with MySQL
            $table->dateTime('last_update');
            $table->unique(array('webinar_id', 'ip'));
            //$table->foreign('webinar_id')->references('id')->on('webinars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('webinar_live_attenders');
    }
}
