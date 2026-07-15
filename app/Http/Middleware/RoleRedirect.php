<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRedirect
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $role = Auth::user()->role ?? 'member';

            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'lecturer' => redirect()->route('lecturer.dashboard'),
                default => redirect()->route('student.dashboard'),
            };
        }

        return $next($request);
    }
}
