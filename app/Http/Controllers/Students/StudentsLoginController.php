<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;



class StudentsLoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = 'student';


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('students.login');
    }

    public function username()
    {
        return 'app_number';
    }

    protected function loggedOut()
    {
        return redirect('student/login');
    }

    protected function guard()
    {
        return Auth::guard('student');
    }

    // public function login(Request $request)
    // {
    //     $this->validateLogin($request);

      

    //     if ($this->attemptLogin($request)) {
    //         return $this->sendLoginResponse($request);
    //     }

    //     return redirect()->back()->withInput($request->only('appnumber'));
    // }

    // protected function validateLogin(Request $request)
    // {
    //     $request->validate([
    //         $this->username() => 'required|string|min:3',
    //         'password' => 'required|string|min:3',
    //     ]);
    // }

    // protected function attemptLogin(Request $request)
    // {
    //     return Auth::guard('student')->attempt(
    //         $this->credentials($request), $request->filled('remember')
    //     );
    // }

    // protected function credentials(Request $request)
    // {
    //     return $request->only($this->username(), 'password');
    // }

    // protected function sendLoginResponse(Request $request)
    // {
    //     $request->session()->regenerate();

      

    //     return $this->authenticated($request, Auth::guard('student')->Student());
    //             // ?: redirect()->intended(route('student.dashboard'));
                
    //             // redirect()->intended($this->redirectPath());
                
    // }

    // protected function authenticated(Request $request, $user)
    // {
    //     //
    // }

  

    // public function username()
    // {
    //     return 'appnumber';
    // }

    // public function logout(Request $request)
    // {
    //     Auth::guard('student')->logout();

    //     $request->session()->invalidate();

    //     return $this->loggedOut($request) ?: redirect('/');
    // }


    // public function username()
    // {
    //     return 'appnumber';
    // }
}
