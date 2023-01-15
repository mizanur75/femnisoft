<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class PharmacyMiddleware
{
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->role->name == 'Pharmacy'){
            return $next($request);
        }else{
            return redirect()->route('login');
        }
    }
}
