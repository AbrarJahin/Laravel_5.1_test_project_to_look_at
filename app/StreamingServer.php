<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StreamingServer extends Model
{

    protected $table = 'streaming_servers';
    protected $fillable = ['name', 'enabled', 'access_level', 'streaming_url'];
    
    public function webinar(){
        return $this->hasOne('App\Webinar');
    }

}
