<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAuthor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Adjust this condition to your own author check.
        // If you store a "role" on users:
        // if (!Auth::check() || Auth::user()->role !== 'author') { ... }

        if (!Auth::check()) {
            return redirect()->route('login')->with('error_message', 'Please log in first.');
        }

        // If you have an is_author flag/relationship/permission, check it here:
        // Example fallback: allow all authenticated users
        return $next($request);
    }
}
