<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class WebinarLiveAttenders extends Model
{
	protected $table = 'webinar_live_attenders';
	protected $primaryKey='id';
	protected $fillable = array('webinar_id','ip','last_update');
    public $timestamps=false;

    public function webinars()
    {
        return $this->belongsTo('App\Webinar');
    }
}
