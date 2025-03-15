<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware to restrict access to routes for admin users only.
 *
 * This middleware checks if the user is authenticated and if the user's role is 'admin'.
 * If the user is authenticated and has the 'admin' role, the request is allowed to continue.
 * Otherwise, the user will be redirected to the homepage.
 */
class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        return redirect('/');
    }
}
