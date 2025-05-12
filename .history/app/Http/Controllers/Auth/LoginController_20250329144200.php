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

            // First, check if user has any roles
            if ($user->roles->isEmpty()) {
                Log::warning('User has no roles: ' . $user->email);
                // Default to client dashboard if no roles assigned
                return redirect()->intended(route('client.dashboard'));
            }

            // Check if admin
            if ($user->roles->contains('name', 'admin')) {
                return redirect()->intended(route('admin.dashboard'));
            }
            // Check if artisan
            elseif ($user->roles->contains('name', 'artisan')) {
                return redirect()->intended(route('artisan.dashboard'));
            }
            // Default to client
            else {
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
