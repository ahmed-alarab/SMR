<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in (using session)
        if (!session()->has('user_id')) {
            return redirect('/login')->with('error', 'You must log in first.');
        }

        return $next($request);
    }
}
