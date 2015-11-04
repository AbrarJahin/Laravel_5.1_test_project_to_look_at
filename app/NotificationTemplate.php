<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model {

   protected $table = 'notification_templates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['default_id', 'subject', 'content', 'user_id'];

    public function defaultTemplate() {

        $defaultNotification = NotificationTemplate::find($this->default_id);

        return $defaultNotification;
    }

}
