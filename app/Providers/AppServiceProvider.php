<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

use \App\SubscribersList;
use App\Validation\CustomValidator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new CustomValidator($translator, $data, $rules, $messages);
        });

        Validator::extend('unique_subscribers_list_email', function($attribute, $value, $parameters) {
            
            $subscribers_list_id = $parameters[0];
            $email = $parameters[1];
            $subscriberId = intval($parameters[2]);
            
            $subscriber = SubscribersList::find($subscribers_list_id)
                                    ->subscribers()->where('email', $email)->first();

            return !$subscriber || $subscriber->id == $subscriberId;

        },"There is already another subscriber with the email address in current list.");
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
