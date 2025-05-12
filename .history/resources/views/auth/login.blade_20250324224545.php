@extends('layouts.app')

@section('title', 'Login - MyArtisan')
@section('description', 'Login to MyArtisan - Connect with skilled Moroccan artisans')

@section('styles')
    <style>
        /* Core styling */
        .auth-form {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .form-input:focus {
            border-color: #D97706;
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.2);
        }

        /* Fallback image approach - direct image tag instead of background */
        .image-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 1rem;
        }

        .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(180, 83, 9, 0.7) 0%, rgba(180, 83, 9, 0.1) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.5rem;
        }

        .brand-text {
            color: white;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        /* New distinctive UI elements */
        .login-container {
            background-color: #FFFBEB;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .decorated-header {
            border-left: 4px solid #D97706;
            padding-left: 1rem;
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="min-h-screen flex items-center justify-center py-12 px-4 bg-amber-50">
        <div class="max-w-4xl w-full login-container shadow-xl">
            <div class="flex flex-col md:flex-row">
                <!-- Image Section - Using direct img tag for better compatibility -->
                <div class="md:w-1/2 p-4">
                    <div class="image-wrapper h-full">
                        <!-- Fallback image with multiple options to ensure display -->
                        <img src="{{ asset('images/login/Morocco-Andalusian.jpg') }}" alt="Moroccan Andalusian Architecture"
                            onerror="this.onerror=null; this.src='/images/login/Morocco-Andalusian.jpg';">

                        <div class="image-overlay">
                            <h1 class="text-2xl md:text-3xl font-bold brand-text">MyArtisan</h1>
                            <p class="text-sm md:text-base brand-text mt-1">Discover authentic Moroccan craftsmanship</p>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="md:w-1/2 p-6">
                    <div class="decorated-header">
                        <h2 class="text-2xl md:text-3xl font-bold text-amber-800">{{ __('Welcome Back') }}</h2>
                        <p class="text-sm text-gray-600">{{ __('Login to access your MyArtisan account') }}</p>
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

                    <form class="mt-6 space-y-5" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    {{ __('Email Address') }}
                                </label>
                                <div class="mt-1">
                                    <input id="email" name="email" type="email" autocomplete="email" required
                                        class="form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm"
                                        value="{{ old('email') }}">
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="password" class="block text-sm font-medium text-gray-700">
                                        {{ __('Password') }}
                                    </label>
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

                        <div class="text-center pt-2">
                            <p class="text-sm text-gray-600">
                                {{ __('Don\'t have an account?') }}
                                <a href="{{ route('register') }}" class="font-medium text-amber-600 hover:text-amber-500">
                                    {{ __('Register now') }}
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Debug info - will help diagnose image issues -->
            @if (config('app.debug'))
                <div class="bg-gray-100 p-3 text-xs text-gray-700 border-t border-gray-200">
                    <p>Debug - Image path: {{ asset('images/login/Morocco-Andalusian.jpg') }}</p>
                    <p>Check that the image exists at: /public/images/login/Morocco-Andalusian.jpg</p>
                </div>
            @endif
        </div>
    </div>
@endsection
