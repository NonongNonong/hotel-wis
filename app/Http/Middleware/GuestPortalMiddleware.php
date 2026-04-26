<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuestPortalMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'guest') {
            return redirect()->route('dashboard')
                             ->with('error', 'Access denied.');
        }

        return $next($request);
    }
}