<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\UserRepositoryInterface;

class RegisterController extends Controller
{
    /**
     * The user repository instance.
     *
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param UserRepositoryInterface $userRepository
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->middleware('guest');
        $this->userRepository = $userRepository;
    }

    /**
     * Show the registration form
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validator = $this->validateRegistrationData($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create base user through repository
        $user = $this->userRepository->create($request->all());

        // Assign role to user through repository
        $this->userRepository->assignRole($user, $request->role);

        // Setup user profile based on role through repository
        $profileData = $request->only(['bio']); // Add other profile fields as needed
        $user = $this->userRepository->setupUserProfile($user, $request->role, $profileData);

        // Fire registered event
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        // Redirect based on user role
        return $this->redirectBasedOnRole($user);
    }

    /**
     * Validate registration data
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateRegistrationData(Request $request)
    {
        return Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:artisan,client',
        ]);
    }

    /**
     * Redirect user based on their role
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectBasedOnRole($user)
    {
        if ($user->hasRole('artisan')) {
            return redirect()->route('artisan.dashboard')
                ->with('success', 'Welcome! Please complete your artisan profile.');
        } else {
            return redirect()->route('client.dashboard')
                ->with('success', 'Welcome! You can now browse and book artisan services.');
        }
    }
}
