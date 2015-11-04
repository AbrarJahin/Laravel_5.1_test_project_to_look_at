<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    protected $fillable = ['title', 'description', 'hosts', 'starts_on', 'duration', 'timezone', 'uuid', 'share',
        'streaming_server_id', 'streaming_server_code'];
    
    public function subscribers_lists() {
    	return $this->belongsToMany('\App\SubscribersList',
    		'webinars_subscribers_lists',
    		'webinar_id', 'subscribers_list_id');
    }

    public function excluded_subscribers_lists() {
        return $this->belongsToMany('\App\SubscribersList',
            'webinars_excluded_subscribers_lists',
            'webinar_id', 'subscribers_list_id');
    }

    public function panelists(){
        return $this->belongsToMany('App\Panelist');
    }

    public function public_qas() {
    	return $this->hasMany('App\QA')->where('public',1);
    }

    public function qas(){
        return $this->hasMany('App\QA');
    }

    public function timeLeft(){
        $seconds = strtotime($this->starts_on) - strtotime(date("Y-m-d H:i:s"));
        if($seconds < 0) {
            return false;
        }
        return $seconds;
    }
    
    public function webinar_leads(){
        return $this->hasMany('App\WebinarLead');
    }
    
    public function streaming_server(){
        return $this->belongsTo('App\StreamingServer');
    }
    
    public function signup_subscribers_lists() {
    	return $this->belongsToMany('\App\SubscribersList',
    		'webinars_signup_subscribers_lists',
    		'webinar_id', 'subscribers_list_id');
    }
    
    public function webinar_subscriber_list(){
        return $this->hasOne('\App\SubscribersList');
    }
}
