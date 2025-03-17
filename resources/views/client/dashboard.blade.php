@extends('layouts.client')

@section('title', 'Client Dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-amber-800 mb-6">Client Dashboard</h1>

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
                                        class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded mt-1">Client</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="#" class="text-amber-600 hover:text-amber-800 text-sm font-medium">Edit
                                    Profile</a>
                            </div>
                        </div>

                        <!-- Bookings Card -->
                        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                            <h2 class="text-lg font-medium text-gray-800 mb-4">My Bookings</h2>
                            <p class="text-sm text-gray-500 mb-4">No current bookings</p>
                            <a href="#" class="text-sm font-medium text-amber-600 hover:text-amber-800">View Booking
                                History →</a>
                        </div>

                        <!-- Saved Artisans Card -->
                        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                            <h2 class="text-lg font-medium text-gray-800 mb-4">Saved Artisans</h2>
                            <p class="text-sm text-gray-500 mb-4">You haven't saved any artisans yet</p>
                            <a href="#" class="text-sm font-medium text-amber-600 hover:text-amber-800">Discover
                                Artisans →</a>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-8">
                        <h2 class="text-xl font-medium text-gray-800 mb-4">Quick Actions</h2>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <a href="#"
                                class="bg-white p-4 rounded-lg shadow border border-gray-100 hover:bg-gray-50 transition flex flex-col items-center">
                                <i class="fas fa-search text-amber-500 text-xl mb-2"></i>
                                <span class="text-sm font-medium">Find Artisans</span>
                            </a>
                            <a href="#"
                                class="bg-white p-4 rounded-lg shadow border border-gray-100 hover:bg-gray-50 transition flex flex-col items-center">
                                <i class="fas fa-calendar-plus text-amber-500 text-xl mb-2"></i>
                                <span class="text-sm font-medium">Book a Service</span>
                            </a>
                            <a href="#"
                                class="bg-white p-4 rounded-lg shadow border border-gray-100 hover:bg-gray-50 transition flex flex-col items-center">
                                <i class="fas fa-comment-alt text-amber-500 text-xl mb-2"></i>
                                <span class="text-sm font-medium">Messages</span>
                            </a>
                            <a href="#"
                                class="bg-white p-4 rounded-lg shadow border border-gray-100 hover:bg-gray-50 transition flex flex-col items-center">
                                <i class="fas fa-cog text-amber-500 text-xl mb-2"></i>
                                <span class="text-sm font-medium">Settings</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
