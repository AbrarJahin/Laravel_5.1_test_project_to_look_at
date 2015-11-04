<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWebinarIdColumnSubscribersListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("subscribers_lists", function(Blueprint $table){
            $table->integer("webinar_id")->unsigned()->nullable()->after("user_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("subscribers_lists", function(Blueprint $table){
            $table->dropColumn("webinar_id");
        });
    }
}
