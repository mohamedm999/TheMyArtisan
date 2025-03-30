<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Get authenticated user
            $user = Auth::user();

            // Eager load roles to avoid N+1 query problems
            $user->load('roles');

            // Add extra debugging
            Log::info('User login successful', [
                'user_id' => $user->id,
                'email' => $user->email,
                'direct_role' => $user->role,
                'has_admin_role' => $user->hasRole('admin'),
                'roles_collection' => $user->roles->pluck('name')->toArray(),
            ]);

            // First check if user is an admin - using hasRole() for consistency
            if ($user->hasRole('admin')) {
                Log::info('User is admin, redirecting to admin dashboard');
                return redirect()->intended(route('admin.dashboard'));
            }

            // Then check for artisan role
            elseif ($user->hasRole('artisan')) {
                return redirect()->intended(route('artisan.dashboard'));
            }

            // Check for client role
            elseif ($user->hasRole('client')) {
                return redirect()->intended(route('client.dashboard'));
            }

            // No recognized roles, log warning and default to client dashboard
            else {
                Log::warning('User has no recognized roles', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'role_attribute' => $user->role,
                    'roles_relationship' => $user->roles->pluck('name')->toArray()
                ]);
                return redirect()->intended(route('client.dashboard'));
            }
        }

        // Authentication failed
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
