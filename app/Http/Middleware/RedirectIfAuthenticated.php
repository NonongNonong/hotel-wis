<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {

    

        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Only redirect if actually authenticated
                if (Auth::user()->role === 'guest') {
                    return redirect(route('guest.dashboard'));
                }
                return redirect(route('dashboard'));
            }
        }

        // Not logged in — continue to login page normally
        return $next($request);
    }
}