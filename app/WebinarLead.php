<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class WebinarLead extends Model {
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['webinar_id','first_name', 'last_name', 'email'];
    
    public function webinar(){
        return $this->belongsTo('App\Webinar');
    }
}