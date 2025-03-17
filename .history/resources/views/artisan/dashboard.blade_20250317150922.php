@extends('layouts.artisan')

@section('title', 'Artisan Dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-amber-800 mb-6">Artisan Dashboard</h1>

                    <!-- Check if artisanProfile exists -->
                    @if(auth()->user()->artisanProfile)
                        <!-- Availability Status Card -->
                        <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-4">Availability Status</h3>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p>You are currently:
                                        @if(auth()->user()->artisanProfile->is_available)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span> Available for Work
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                <span class="w-2 h-2 mr-1 bg-gray-500 rounded-full"></span> Not Available
                                            </span>
                                        @endif
                                    </p>
                                    <p class="mt-2 text-gray-600 text-sm">
                                        @if(auth()->user()->artisanProfile->is_available)
                                            Clients can now find you in searches and send you booking requests.
                                        @else
                                            You are currently hidden from new client searches and cannot receive new booking
                                            requests.
                                        @endif
                                    </p>
                                </div>
                                <form action="{{ route('artisan.profile.toggle-availability') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 rounded-md text-sm font-medium
                                        @if(auth()->user()->artisanProfile->is_available) bg-gray-600 hover:bg-gray-700 text-white
                                        @else
                                            bg-green-600 hover:bg-green-700 text-white @endif">
                                        @if(auth()->user()->artisanProfile->is_available)
                                            Set as Unavailable
                                        @else
                                            Set as Available
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Profile Setup Prompt -->
                        <div class="mb-6 p-4 bg-amber-50 rounded-lg shadow-md border border-amber-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    <svg class="h-10 w-10 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="text-sm font-medium text-amber-800">Complete Your Profile Setup</h3>
                                    <div class="mt-2 text-sm text-amber-700">
                                        <p>Your artisan profile needs to be set up before you can use all features, including availability settings.</p>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('artisan.profile') }}"
                                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                            Set Up Profile Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Profile Summary Card -->
                        <div class="bg-amber-50 p-6 rounded-lg shadow">
                            <h2 class="text-lg font-medium text-amber-700 mb-4">Profile Summary</h2>
                            <div class="flex items-center mb-4">
                                <div
                                    class="w-16 h-16 rounded-full bg-amber-200 flex items-center justify-center text-amber-600 text-xl font-bold mr-4">
                                    {{ strtoupper(substr(Auth::user()->firstname, 0, 1) . substr(Auth::user()->lastname, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-medium">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h3>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                    <span
                                        class="inline-block bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded mt-1">Artisan</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('artisan.profile') }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium">Edit
                                    Profile</a>
                            </div>
                        </div>

                        <!-- Services Card -->
                        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                            <h2 class="text-lg font-medium text-gray-800 mb-4">My Services</h2>
                            <p class="text-sm text-gray-500 mb-4">Manage your craft services and offerings</p>
                            <a href="#" class="text-sm font-medium text-amber-600 hover:text-amber-800">Manage
                                Services →</a>
                        </div>

                        <!-- Bookings Card -->
                        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                            <h2 class="text-lg font-medium text-gray-800 mb-4">Recent Bookings</h2>
                            <p class="text-sm text-gray-500 mb-4">You have no pending bookings</p>
                            <a href="#" class="text-sm font-medium text-amber-600 hover:text-amber-800">View All
                                Bookings →</a>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-8">
                        <h2 class="text-xl font-medium text-gray-800 mb-4">Quick Actions</h2>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <a href="#"
                                class="bg-white p-4 rounded-lg shadow border border-gray-100 hover:bg-gray-50 transition flex flex-col items-center">
                                <i class="fas fa-plus-circle text-amber-500 text-xl mb-2"></i>
                                <span class="text-sm font-medium">Add New Service</span>
                            </a>
                            <a href="#"
                                class="bg-white p-4 rounded-lg shadow border border-gray-100 hover:bg-gray-50 transition flex flex-col items-center">
                                <i class="fas fa-camera text-amber-500 text-xl mb-2"></i>
                                <span class="text-sm font-medium">Update Portfolio</span>
                            </a>
                            <a href="#"
                                class="bg-white p-4 rounded-lg shadow border border-gray-100 hover:bg-gray-50 transition flex flex-col items-center">
                                <i class="fas fa-calendar-alt text-amber-500 text-xl mb-2"></i>
                                <span class="text-sm font-medium">Set Availability</span>
                            </a>
                            <a href="#"
                                class="bg-white p-4 rounded-lg shadow border border-gray-100 hover:bg-gray-50 transition flex flex-col items-center">
                                <i class="fas fa-cog text-amber-500 text-xl mb-2"></i>
                                <span class="text-sm font-medium">Account Settings</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
