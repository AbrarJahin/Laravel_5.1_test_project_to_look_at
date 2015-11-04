<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebinarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("webinars",function(Blueprint $table){
            $table->increments("id");
            $table->integer("user_id")->unsigned();
            $table->string("title");
            $table->text("description")->nullable();
            $table->string("hosts");
            $table->text("share")->nullable();
            $table->timestamp('starts_on')->nullable();
            $table->string('timezone')->nullable();
            $table->string('duration')->nullable();
            $table->string('uuid',30);
            $table->timestamps();
        });

        //pivot table.
        Schema::create("webinars_subscribers_lists",function(Blueprint $table){
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
        Schema::drop("webinars");
        Schema::drop("webinars_subscribers_lists");
    }
}
