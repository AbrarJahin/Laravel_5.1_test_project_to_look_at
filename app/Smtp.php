<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Smtp extends Model {
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "smtp_settings";
    protected $fillable = ['customer_id','name', 'host', 'username', 'password', 'port', 'protocol', 'from_email', 'from_name', 'reply_email', 'enabled'];
    
}