<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. If the user isn't logged in at all, kick them back to login page
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. If their role doesn't match the required route role, block them (403 Unauthorized)
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized action. You do not have the required role to view this page.');
        }

        return $next($request);
    }
}