<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QA extends Model
{
    protected $table = "qas";
    protected $fillable = ['webinar_id', 'subscriber_id', 'question', 'public'];
}
