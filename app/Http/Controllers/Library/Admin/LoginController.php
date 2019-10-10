<?php

namespace App\Http\Controllers\Library\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'library/admin';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('library.admin.login');
    }

    protected function loggedOut()
    {
        return redirect('library.admin.login');
    }

    protected function guard()
    {
        return Auth::guard('libadmin');
    }
}