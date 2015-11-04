<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColumnSmtpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("smtp_settings", function(Blueprint $table){
            $table->enum("enabled", array(0,1))->default(1)->after("reply_email");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("smtp_settings", function(Blueprint $table){
            $table->dropColumn("enabled");
        });
    }
}
