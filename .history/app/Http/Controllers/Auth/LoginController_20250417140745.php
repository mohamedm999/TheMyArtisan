<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->middleware('guest')->except('logout');
        $this->userRepository = $userRepository;
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

        // Attempt to log the user in using the repository
        if ($this->userRepository->attemptLogin($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Get authenticated user from repository
            $user = $this->userRepository->getAuthenticatedUser();

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
        $this->userRepository->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
