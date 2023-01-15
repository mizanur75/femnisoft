<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class CentralMiddleware
{
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->role->name == 'Central'){
            return $next($request);
        }else{
            return redirect()->route('login');
        }
    }
}
