<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminLoginController extends Controller
{

    use AuthenticatesUsers;

    // redirect after login
    protected $redirectTo = 'admin';
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admins.login');
    }

    public function username()
    {
        return 'username';
    }

    protected function loggedOut()
    {
        return redirect('admin/login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
}
