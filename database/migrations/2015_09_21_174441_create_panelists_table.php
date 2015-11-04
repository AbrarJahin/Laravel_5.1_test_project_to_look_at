<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePanelistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("panelists", function(Blueprint $table) {
            $table->increments("id");
            $table->integer("customer_id")->unsigned(); //the webinar owner.
            $table->integer("user_id")->unsigned(); //the panelist user
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
        Schema::drop("panelists");
    }
}
