<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        // Check if user has admin or super-admin role
        if (!Auth::user()->hasRole(['super-admin', 'admin'])) {
            Auth::logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Unauthorized access. Admin privileges required.'
            ]);
        }

        return $next($request);
    }
}