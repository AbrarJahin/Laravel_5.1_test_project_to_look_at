<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreaminServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streaming_servers', function(Blueprint $table){
            $table->increments("id");
            $table->boolean("enabled");
            $table->string("name");
            $table->string("access_level");
            $table->string("streaming_url");
            $table->boolean('health');
            $table->dateTime('last_check');
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
        Schema::drop("streaming_servers");
    }
}
