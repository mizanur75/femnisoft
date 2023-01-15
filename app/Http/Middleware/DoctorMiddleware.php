<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class DoctorMiddleware
{
    
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role->name == 'Doctor') {
            return $next($request);
        }else{
            return redirect()->route('login');
        }
    }
}
