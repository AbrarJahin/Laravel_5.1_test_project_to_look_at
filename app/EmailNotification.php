<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailNotification extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "email_notifications";
    protected $fillable = [
        'customer_id',
        'uuid',
        'subject',
        'content',
        'send_type',
        'send_date',
        'minutes_before_webinar',
        'smtp_setting_id',
        'webinar_id',
        'status'
    ];

}
