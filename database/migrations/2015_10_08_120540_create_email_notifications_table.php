<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailNotificationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        // Create Schema
        Schema::create("email_notifications", function(Blueprint $table) {
            $table->increments("id");
            $table->integer("customer_id");
            $table->string("uuid", 30);
            $table->string("subject");
            $table->text("content");
            $table->enum("send_type", array("now", "date", "minutes_before"));
            $table->timestamp("send_date");
            $table->integer("minutes_before_webinar")->nullable();
            $table->integer("smtp_setting_id");
            $table->integer("webinar_id");
            $table->integer("count_subscribers");
            $table->enum("status", array(-1, 0, 1))->comment("Comment -1 => Error in Sending Email, 0 => Email Not Sent, 1 => Email Sent")->default(0);
            $table->timestamps();

            // Add Index
            $table->index("customer_id");
            $table->index("uuid");
            $table->index("send_date");
            $table->index("minutes_before_webinar");
            $table->index("smtp_setting_id");
            $table->index("webinar_id");
            $table->index("count_subscribers");
            $table->index("status");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop("email_notifications");
    }

}
