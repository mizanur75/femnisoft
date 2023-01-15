<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class PharmaMiddleware
{
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->role->name == 'Pharma'){
            return $next($request);
        }else{
            return redirect()->route('login');
        }
    }
}
