<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class WebinarVote extends Model
{
	protected $fillable = array('webinar_id');
    protected $table = 'webinar_vote';
    protected $primaryKey='webinar_id';
    public $timestamps=false;

    public function webinars()
    {
        return $this->belongsTo('App\Webinar');
    }
}
