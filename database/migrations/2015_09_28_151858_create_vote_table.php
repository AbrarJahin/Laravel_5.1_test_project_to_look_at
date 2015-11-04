<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webinar_vote', function(Blueprint $table)
        {
            $table->integer('webinar_id');
            $table->integer("vote_yes")->default(0);
            $table->integer("vote_no")->default(0);
            $table->primary('webinar_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('webinar_vote');
    }
}
