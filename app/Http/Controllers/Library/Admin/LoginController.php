<?php

namespace App\Http\Controllers\Library\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;

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

    // public function authenticate(Request $request)
    // {
    //     $credentials = $request->only('username', 'password');

    //     if (Auth::guard('libadmin')->attempt($credentials)) {
    //         // Authentication passed...
    //         return redirect()->intended('library/admin');
    //     }
    //     return redirect('library/admin/login');
    // }

    public function username()
    {
        return 'username';
    }

    protected function loggedOut()
    {
        return redirect('library/admin/login');
    }

    protected function guard()
    {
        return Auth::guard('libadmin');
    }
}