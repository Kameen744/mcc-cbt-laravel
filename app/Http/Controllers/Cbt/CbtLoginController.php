<?php

namespace App\Http\Controllers\Cbt;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class CbtLoginController extends Controller
{
    use AuthenticatesUsers;
    
    protected $redirectTo = 'cbt';
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('cbt.login');
    }

    public function username()
    {
        return 'app_number';
    }

    protected function loggedOut()
    {
        return redirect('cbt/login');
    }

    protected function guard()
    {
        return Auth::guard('cbt');
    }
}
