<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['subscribers_list_id', 'first_name', 'last_name', 'email', 'status'];

    public function subscribers_lists() {
    	
    	return $this->belongsToMany('\App\SubscribersList', 
    		'subscribers_lists_subscribers',
    		'subscriber_id', 'subscribers_list_id');
    }

    public function qas($webinarId) {
    	return $this->hasMany('App\QA','subscriber_id')->where('webinar_id', $webinarId);
    }
}