@extends('layouts.app')

@section('title', 'Register - MyArtisan')
@section('description', 'Create your MyArtisan account - Connect with skilled Moroccan artisans')

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
        .register-container {
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
        <div class="max-w-5xl w-full register-container shadow-xl">
            <div class="flex flex-col md:flex-row">
                <!-- Image Section - Using direct img tag for better compatibility -->
                <div class="md:w-5/12 p-4">
                    <div class="image-wrapper h-full">
                        <!-- Using same image as login for consistency -->
                        <img src="{{ asset('images/login/loginImage.jpg') }}" alt="Moroccan Andalusian Architecture"
                            onerror="this.onerror=null; this.src='/images/login/Morocco-Andalusian.jpg';">

                        <div class="image-overlay">
                            <h1 class="text-2xl md:text-3xl font-bold brand-text">MyArtisan</h1>
                            <p class="text-sm md:text-base brand-text mt-1">Join our community of Moroccan craftsmanship</p>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="md:w-7/12 p-6">
                    <div class="decorated-header">
                        <h2 class="text-2xl md:text-3xl font-bold text-amber-800">{{ __('Create Account') }}</h2>
                        <p class="text-sm text-gray-600">{{ __('Join MyArtisan and discover authentic Moroccan artisans') }}
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

                    <form class="mt-6 space-y-4" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Name Field -->
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                                <div class="mt-1">
                                    <input id="name" name="name" type="text" autocomplete="name" required
                                        class="form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm"
                                        value="{{ old('name') }}">
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                                <div class="mt-1">
                                    <input id="email" name="email" type="email" autocomplete="email" required
                                        class="form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm"
                                        value="{{ old('email') }}">
                                </div>
                            </div>

                            <!-- Phone Number Field -->
                            <div>
                                <label for="phone"
                                    class="block text-sm font-medium text-gray-700">{{ __('Phone Number') }}</label>
                                <div class="mt-1">
                                    <input id="phone" name="phone" type="tel" autocomplete="tel"
                                        class="form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm"
                                        value="{{ old('phone') }}">
                                </div>
                            </div>

                            <!-- City Field -->
                            <div>
                                <label for="city"
                                    class="block text-sm font-medium text-gray-700">{{ __('City') }}</label>
                                <div class="mt-1">
                                    <input id="city" name="city" type="text"
                                        class="form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm"
                                        value="{{ old('city') }}">
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label for="password"
                                    class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                                <div class="mt-1">
                                    <input id="password" name="password" type="password" autocomplete="new-password"
                                        required
                                        class="form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm">
                                </div>
                            </div>

                            <!-- Confirm Password Field -->
                            <div>
                                <label for="password-confirm"
                                    class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                                <div class="mt-1">
                                    <input id="password-confirm" name="password_confirmation" type="password"
                                        autocomplete="new-password" required
                                        class="form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- User Type Selection -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Register as') }}</label>
                            <div class="flex flex-col md:flex-row gap-3">
                                <div class="flex-1">
                                    <input type="radio" id="type_client" name="user_type" value="client"
                                        class="hidden peer" checked>
                                    <label for="type_client"
                                        class="flex items-center justify-center p-4 bg-white border border-amber-200 rounded-lg cursor-pointer peer-checked:border-amber-600 peer-checked:bg-amber-50 hover:bg-amber-50">
                                        <div class="text-center">
                                            <i class="fas fa-user text-amber-600 text-xl mb-2"></i>
                                            <p class="text-sm font-medium">{{ __('Client') }}</p>
                                        </div>
                                    </label>
                                </div>
                                <div class="flex-1">
                                    <input type="radio" id="type_artisan" name="user_type" value="artisan"
                                        class="hidden peer">
                                    <label for="type_artisan"
                                        class="flex items-center justify-center p-4 bg-white border border-amber-200 rounded-lg cursor-pointer peer-checked:border-amber-600 peer-checked:bg-amber-50 hover:bg-amber-50">
                                        <div class="text-center">
                                            <i class="fas fa-tools text-amber-600 text-xl mb-2"></i>
                                            <p class="text-sm font-medium">{{ __('Artisan') }}</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Privacy -->
                        <div class="mt-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox"
                                        class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded"
                                        required>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-medium text-gray-700">
                                        {{ __('I agree to the') }}
                                        <a href="#"
                                            class="text-amber-600 hover:text-amber-500">{{ __('Terms of Service') }}</a>
                                        {{ __('and') }}
                                        <a href="#"
                                            class="text-amber-600 hover:text-amber-500">{{ __('Privacy Policy') }}</a>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-300 shadow-md">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-user-plus text-amber-500 group-hover:text-amber-400"></i>
                                </span>
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-5">
                        <p class="text-sm text-gray-600">
                            {{ __('Already have an account?') }}
                            <a href="{{ route('login') }}" class="font-medium text-amber-600 hover:text-amber-500">
                                {{ __('Sign in') }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
