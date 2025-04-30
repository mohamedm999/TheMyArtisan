<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = $request->user();
        $hasAdminRole = $user->hasRole('admin');

        // Check if the user has the admin role or is_admin flag is true
        if (!$hasAdminRole && (!isset($user->is_admin) || !$user->is_admin)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized - You need admin privileges for this action'], 403);
            }

            return redirect()->route('home')->with('error', 'You do not have permission to access the admin area.');
        }

        return $next($request);
    }
}
