<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{


    use AuthenticatesUsers;

    protected $redirectTo;

    public function __construct()
    {
        if(Auth::check() && Auth::user()->role->name == 'Admin' ){
            $this->redirectTo = route('admin.dashboard');
        } elseif(Auth::check() && Auth::user()->role->name == 'Agent' ) {
            $this->redirectTo = route('agent.dashboard');
        } elseif(Auth::check() && Auth::user()->role->name == 'Doctor' ) {
            $this->redirectTo = route('doctor.dashboard');
        } elseif(Auth::check() && Auth::user()->role->name == 'Pharmacy' ){
            $this->redirectTo = route('pharmacy.dashboard');
        } elseif(Auth::check() && Auth::user()->role->name == 'Pharma' ){
            $this->redirectTo = route('pharma.dashboard');
        } elseif(Auth::check() && Auth::user()->role->name == 'Central' ){
            $this->redirectTo = route('central.dashboard');
        }else{
            $this->redirectTo = route('user.dashboard');
        }
        $this->middleware('guest')->except('logout');
    }
    protected function credentials(Request $request)
    {
        // return $request->only($this->username(), 'password');
        return ['email' => $request->{$this->username()},'password'=> $request->password, 'status' => 1];
    }
}
