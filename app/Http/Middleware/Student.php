<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Student extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */

    protected function redirectTo($request)
    {
        dd($request);
        if (! $request->expectsJson()) {
            return route('student.loginform');
        }
    }
}
