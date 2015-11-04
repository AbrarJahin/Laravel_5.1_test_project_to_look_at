<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Panelist extends Model
{
	public function customer() {
		return $this->belongsTo("App\User", "customer_id");
	}

	public function user() {
		return $this->belongsTo("App\User", "user_id");
	}

	public function webinars() {
		return $this->hasMany('App\Webinar');
	}

	public function qas(){
		return $this->hasMany('App\QA');
	}
}
