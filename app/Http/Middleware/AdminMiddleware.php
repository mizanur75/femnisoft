<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->role->name == 'Admin'){
            return $next($request);
        }else{
            return redirect()->route('login');
        }
    }
}
