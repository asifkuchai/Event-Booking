<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Redirect unauthenticated users to login page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo(Request $request)
    {
        if (!$request->expectsJson()) {
            return route('login'); // make sure you have a login route
        }
    }
}
