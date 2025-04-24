<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Factories\UserFactoryCreator;

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

        // Get appropriate factory based on selected role
        try {
            $factory = UserFactoryCreator::getFactory($request->role);
            
            // Create user using factory method pattern
            $user = $factory->createUser($request);
            
            // Fire registered event
            event(new Registered($user));
    
            // Log the user in
            Auth::login($user);
    
            // Redirect based on user type using the factory
            return $factory->redirectAfterRegistration($user);
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['role' => $e->getMessage()])
                ->withInput();
        }
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
}
