<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmtpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smtp_settings', function(Blueprint $table){
            // Create Schema Table
            $table->increments("id");
            $table->integer("customer_id");
            $table->string("name");
            $table->string("host");
            $table->string("username");
            $table->string("password");
            $table->string("port");
            $table->string("protocol");
            $table->string("from_email");
            $table->string("from_name");
            $table->string("reply_email");
            $table->timestamps();
            
            // Add Index
            $table->index("customer_id");
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('smtp_settings');
    }
}
