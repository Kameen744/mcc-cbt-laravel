<?php

namespace App\Http\Controllers\Cbt;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminLoginController extends Controller
{

    use AuthenticatesUsers;

    // redirect after login
    protected $redirectTo = 'cbt/admin';
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('cbt.admins.login');
    }

    public function username()
    {
        return 'username';
    }

    protected function loggedOut()
    {
        return redirect('cbt/admin/login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
}
