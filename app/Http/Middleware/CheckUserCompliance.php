<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserCompliance
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // 1. Handle Blacklist, Manual Suspension, & Deactivation Kicks
            $isBlacklisted = ($user->status === 'blacklisted' && $user->blacklist_until && now()->lt($user->blacklist_until));
            $isSuspended = ($user->status === 'inactive' || $user->status === 'suspended');

            if ($isBlacklisted || $isSuspended) {
                Auth::logout();
                
                // Completely flush the session to prevent cookie mismatch loops
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'email' => 'Your account profile has been suspended or deactivated by an administrator.'
                ]);
            }

            // 2. Intercept Restricted Writing Profiles (Block POST, PUT, PATCH, DELETE operations)
            if ($user->status === 'restricted' && !$request->isMethod('get')) {
                // If they are on the rules page, let them accept rules, otherwise block data submission
                if (!str_contains($request->url(), 'rules')) {
                    return redirect()->back()->with('error', 'Your interaction privileges are currently restricted by moderation.');
                }
            }

            // 3. Clear out blacklist if temporary window has expired
            if ($user->status === 'blacklisted' && $user->blacklist_until && now()->gt($user->blacklist_until)) {
                $user->update(['status' => 'active', 'blacklist_until' => null]);
            }

            // 4. Force mandatory rules acknowledgment flow check
            if (is_null($user->rules_accepted_at)) {
                // If the browser URL path contains "rules", let the request pass through!
                if (str_contains($request->url(), 'rules')) {
                    return $next($request);
                }
                
                // Otherwise, redirect immediately to rules dashboard display page
                return redirect()->route('rules.show');
            }
        }

        return $next($request);
    }
}