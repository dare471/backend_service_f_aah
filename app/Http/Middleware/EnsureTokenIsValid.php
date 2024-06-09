<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureTokenIsValid
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('token')) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
