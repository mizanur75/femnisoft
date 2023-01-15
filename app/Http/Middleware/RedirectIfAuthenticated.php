<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{

    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && Auth::user()->role->name == 'Admin' ) {
            return redirect()->route('admin.dashboard');
        }elseif (Auth::guard($guard)->check() && Auth::user()->role->name == 'Agent') {
            return redirect()->route('agent.dashboard');
        }elseif (Auth::guard($guard)->check() && Auth::user()->role->name == 'Doctor') {
            return redirect()->route('doctor.dashboard');
        }elseif (Auth::guard($guard)->check() && Auth::user()->role->name == 'Pharmacy') {
            return redirect()->route('pharmacy.dashboard');
        }elseif (Auth::guard($guard)->check() && Auth::user()->role->name == 'Pharma') {
            return redirect()->route('pharma.dashboard');
        }elseif (Auth::guard($guard)->check() && Auth::user()->role->name == 'User') {
            return redirect()->route('user.dashboard');
        }
        // elseif (Auth::guard($guard)->check() && Auth::user()->role->name == 'Central') {
        //     return redirect()->route('agent.dashboard');
        // }
        else {
            return $next($request);
        }
    }
}
