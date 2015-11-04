<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("qas",function(Blueprint $table){
            $table->increments("id");
            $table->integer("webinar_id")->unsigned();
            $table->integer("subscriber_id")->unsigned();
            $table->integer("panelist_id")->unsigned();
            $table->mediumText("question");
            $table->mediumText("answer")->nullable();
            $table->boolean("public")->default(0);
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
        Schema::drop("qas");
    }
}
