<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactColumnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->string('contact_email');
            $table->string('phone');
            $table->string('skype');
            $table->string('linkedin_link');
            $table->string('facebook_link');
            $table->string('twitter_link');
            $table->string('site');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table)
        {
            $table->dropColumn('contact_email');
            $table->dropColumn('phone');
            $table->dropColumn('skype');
            $table->dropColumn('linkedin_link');
            $table->dropColumn('facebook_link');
            $table->dropColumn('twitter_link');
            $table->dropColumn('site');
        });
    }
}
