<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = $this->validateRegistrationData($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create user using factory method pattern
        $user = $this->createUser($request);
        
        // Fire registered event
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        // Redirect based on role using factory method
        return $this->redirectUserBasedOnRole($user);
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
     * Create a new user instance using factory method pattern
     *
     * @param Request $request
     * @return User
     */
    protected function createUser(Request $request)
    {
        // Create base user
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role (artisan or client)
        $user->assignRole($request->role);
        
        return $user;
    }
    
    /**
     * Redirect user based on their role
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectUserBasedOnRole(User $user)
    {
        if ($user->roles->contains('name', 'artisan')) {
            return redirect()->route('artisan.dashboard');
        } else {
            return redirect()->route('client.dashboard');
        }
    }
}
