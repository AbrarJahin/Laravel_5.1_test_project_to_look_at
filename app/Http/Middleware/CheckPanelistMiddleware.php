<?php

namespace App\Http\Middleware;
use App\User;
use Closure;

class CheckPanelistMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(isAdmin() || isCustomer()){
            \Auth::logout();
        }
        
        // Panelist HTTP Basic Auth
        if(isset($_SERVER['PHP_AUTH_USER'])){
            $email = $_SERVER['PHP_AUTH_USER'];
            $count = User::whereEmail($email)->has('panelist_profile')->count();
            if($count == 1){
                return \Auth::basic('email') ?: $next($request);
            } else {
               return \Auth::basic('email');
            }
        } else {
            return \Auth::basic('email');
        }
    }
}
