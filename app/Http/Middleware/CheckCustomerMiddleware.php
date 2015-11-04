<?php

namespace App\Http\Middleware;

use Closure;

class CheckCustomerMiddleware
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
        $user = \Auth::user();
        if(is_null($user)){
            return redirect('auth/login');
        }
        
        if(!isCustomer()){
            return redirect()->back()->withErrors(['error' => 'You are not authorized for the request.']);
        }
        return $next($request);
    }
}
