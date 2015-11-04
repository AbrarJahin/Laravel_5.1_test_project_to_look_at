<?php

namespace App\Http\Middleware;

use Closure;

class CheckEnabledMiddleware
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
        $response = $next($request);

        $user = \Auth::user();
        
        if($user != null && $user->enabled == 0) {
            \Auth::logout();
            $error = new \Illuminate\Support\MessageBag;
            $error->add('Disalbed', 'User is not enabled.');
            return redirect('auth/login')->with(['errors' => $error]);
        } else if($user != null && isAdmin()){
            return redirect('admin/dashboard');
        } else if($user != null && isCustomer()){
            return redirect('members/dashboard');
        }
        
        return $response;
    }
}
