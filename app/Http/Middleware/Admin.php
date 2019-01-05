<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    
    // Created this middleware using: php artisan make:middleware Admin
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        // Check if user is logged in
        if(Auth::check()){

            // Check if user is an Admin by using function created in User Model
            if(Auth::user()->isAdmin()){
                return $next($request);
            }

            return redirect('/');
        }
        
        return redirect(404);
    }
}
