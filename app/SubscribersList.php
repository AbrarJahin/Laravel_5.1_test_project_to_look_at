<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscribersList extends Model
{
    protected $fillable = ['name', 'description', 'user_id', 'webinar_id'];

	public function subscribers()
    {
    	return $this->belongsToMany('\App\Subscriber', 
    		'subscribers_lists_subscribers',
    		'subscribers_list_id', 'subscriber_id');
    }

    public function user()
    {
    	return $this->belongsTo('\App\User');
    }
    
    public function webinars()
    {
        return $this->belongsToMany('\App\Webinar', 
            'webinars_subscribers_lists',
            'webinar_id', 'subscribers_list_id');
    }
    
    public function activeSubscribers()
    {
        return $this->belongsToMany('\App\Subscriber', 'subscribers_lists_subscribers', 'subscribers_list_id', 'subscriber_id')->where('subscribers.status', '=', 'Active');
    }

}