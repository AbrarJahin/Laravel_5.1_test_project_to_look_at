<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebinarLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webinar_leads', function(Blueprint $table){
            // Create Schema
            $table->increments("id");
            $table->integer('webinar_id');
            $table->string("first_name");
            $table->string("last_name");
            $table->string("email");
            $table->timestamps();
            
            // Add Index
            $table->index('webinar_id');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('webinar_leads');
    }
}
