@extends('layouts.app')

@section('title', 'Register - MyArtisan')
@section('description', 'Create your MyArtisan account - Connect with skilled Moroccan artisans')

@section('styles')
    <style>
        .auth-form {
            background-color: white;
        }

        .form-input:focus {
            border-color: #D97706;
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.2);
        }
    </style>
@endsection

@section('content')
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-amber-50">
        <div class="max-w-md w-full space-y-8 auth-form rounded-lg shadow-lg p-8">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-amber-800">
                    {{ __('Join MyArtisan') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Create your account and connect with Moroccan artisans') }}
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
                                {{ __('There were some problems with your registration.') }}
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

            <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="rounded-md shadow-sm space-y-4">
                    <!-- First Name -->
                    <div>
                        <label for="firstname"
                            class="block text-sm font-medium text-gray-700">{{ __('First Name') }}</label>
                        <div class="mt-1">
                            <input id="firstname" name="firstname" type="text" autocomplete="given-name" required
                                class="form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm @error('firstname') border-red-300 @enderror"
                                value="{{ old('firstname') }}">
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="lastname" class="block text-sm font-medium text-gray-700">{{ __('Last Name') }}</label>
                        <div class="mt-1">
                            <input id="lastname" name="lastname" type="text" autocomplete="family-name" required
                                class="form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm @error('lastname') border-red-300 @enderror"
                                value="{{ old('lastname') }}">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email"
                            class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm @error('email') border-red-300 @enderror"
                                value="{{ old('email') }}">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                class="form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm @error('password') border-red-300 @enderror">
                        </div>
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password-confirm"
                            class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                        <div class="mt-1">
                            <input id="password-confirm" name="password_confirmation" type="password"
                                autocomplete="new-password" required
                                class="form-input appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm">
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label for="role"
                            class="block text-sm font-medium text-gray-700">{{ __('Register as') }}</label>
                        <div class="mt-1">
                            <select id="role" name="role" required
                                class="form-select block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm @error('role') border-red-300 @enderror">
                                <option value="">{{ __('Select role') }}</option>
                                <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>{{ __('Client') }}
                                </option>
                                <option value="artisan" {{ old('role') == 'artisan' ? 'selected' : '' }}>
                                    {{ __('Artisan') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-user-plus text-amber-500 group-hover:text-amber-400"></i>
                        </span>
                        {{ __('Register') }}
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="text-sm text-gray-600">
                    {{ __('Already have an account?') }}
                    <a href="{{ route('login') }}" class="font-medium text-amber-600 hover:text-amber-500">
                        {{ __('Sign in') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
