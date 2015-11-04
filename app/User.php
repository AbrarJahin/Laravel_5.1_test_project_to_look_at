<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, EntrustUserTrait

    //Both Authorizable and EntrustUserTrait provides can
    //we will use for Authorizable's can in this case.
    {
        Authorizable::can insteadof EntrustUserTrait;
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'enabled', 'contact_email', 'phone', 'skype', 'facebook_link', 'linkedin_link',
                           'twitter_link', 'site'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function subscribers_lists() {
        return $this->hasMany('App\SubscribersList');
    }

    public function subscribers() {
        return $this->hasManyThrough('App\Subscriber', 'App\SubscribersList');
    }

    public function webinars() {
        return $this->hasMany('App\Webinar');
    }

    public function panelists() {
        return $this->hasMany('App\Panelist', 'customer_id');
    }

    public function panelist_profile() {
        return $this->hasOne('App\Panelist','user_id');    
    }

    public function settings() {
        return $this->hasMany('App\Setting', 'customer_id');
    }

    public function notificationTemplates() {
        return $this->hasMany('App\NotificationTemplate', 'user_id');
    }
}
