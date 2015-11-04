<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePanelistWebinarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //pivot table.
        Schema::create('panelist_webinar', function(Blueprint $table){
            $table->integer("webinar_id")->unsigned();
            $table->integer("panelist_id")->unsigned();
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
        //pivot table.
        Schema::drop('panelist_webinar');
    }
}
