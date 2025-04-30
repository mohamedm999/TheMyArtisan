@extends('layouts.app')

@section('title', 'Login - MyArtisan')
@section('description', 'Login to MyArtisan - Connect with skilled Moroccan artisans')

@section('styles')
    <style>
        .auth-form {
            background-color: white;
        }

        .form-input:focus {
            border-color: #D97706;
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.2);
        }

        /* Fixed image path - using asset helper to ensure correct URL */
        .login-image {
            background-image: url('{{ asset('images/login/Morocco-Andalusian.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 300px; /* Ensure minimum height */
        }

        .pattern-overlay {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c2410c' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        /* Additional styling to enhance visibility */
        .login-container {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .image-container {
            position: relative;
            overflow: hidden;
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
        }
        
        @media (max-width: 768px) {
            .mobile-image-container {
                height: 200px !important; 
                margin-bottom: 1.5rem;
                border-radius: 0.5rem;
                overflow: hidden;
            }
        }
    </style>
@endsection

@section('content')
    <div class="min-h-screen flex flex-col md:flex-row login-container">
        <!-- Image Column (desktop) -->
        <div class="login-image hidden md:block md:w-1/2 relative image-container">
            <!-- Debug info - will be hidden in production -->
            @if(config('app.debug'))
                <div class="absolute top-0 left-0 bg-white/75 p-2 text-xs z-50">
                    Image path: {{ asset('images/login/Morocco-Andalusian.jpg') }}
                </div>
            @endif
            
            <div class="absolute inset-0 bg-gradient-to-r from-amber-700/60 to-transparent pattern-overlay"></div>
            <div class="absolute bottom-10 left-10 text-white">
                <h1 class="text-3xl font-bold drop-shadow-lg">MyArtisan</h1>
                <p class="text-lg drop-shadow-md">Discover authentic Moroccan craftsmanship</p>
            </div>
        </div>

        <!-- Form Column -->
        <div class="md:w-1/2 flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-amber-50">
            <!-- Mobile Image -->
            <div class="md:hidden w-full h-40 login-image mobile-image-container relative">
                <div class="absolute inset-0 bg-gradient-to-b from-amber-700/60 to-transparent pattern-overlay"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <h1 class="text-xl font-bold drop-shadow-lg">MyArtisan</h1>
                    <p class="text-sm drop-shadow-md">Discover authentic Moroccan craftsmanship</p>
                </div>
            </div>

            <div class="max-w-md w-full space-y-8 auth-form rounded-lg shadow-lg p-8 bg-white">
                <div class="text-center">
                    <h2 class="mt-6 text-3xl font-extrabold text-amber-800">
                        {{ __('Welcome Back') }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ __('Login to access your MyArtisan account') }}
                    </p>
                </div>

                @if ($errors->any())
                    <div class="rounded-md bg-red-50 p-4 my-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    {{ __('There were some problems with your input.') }}
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="rounded-md shadow-sm space-y-4">
                        <div>
                            <label for="email"
                                class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" autocomplete="email" required
                                    class="form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm"
                                    value="{{ old('email') }}">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password"
                                    class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                        class="text-sm text-amber-600 hover:text-amber-500">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" autocomplete="current-password"
                                    required
                                    class="form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox"
                                class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="ml-2 block text-sm text-gray-900">
                                {{ __('Remember me') }}
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-300 shadow-md">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="fas fa-sign-in-alt text-amber-500 group-hover:text-amber-400"></i>
                            </span>
                            {{ __('Sign in') }}
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        {{ __('Don\'t have an account?') }}
                        <a href="{{ route('register') }}" class="font-medium text-amber-600 hover:text-amber-500">
                            {{ __('Register now') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
