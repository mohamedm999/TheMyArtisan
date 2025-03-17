@extends('layouts.artisan')

@section('title', 'Artisan Dashboard')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Welcome Banner -->
            <div class="mb-6 bg-gradient-to-r from-amber-500 to-amber-700 rounded-lg shadow-lg overflow-hidden">
                <div class="md:flex items-center justify-between px-6 py-8">
                    <div class="mb-4 md:mb-0">
                        <h1 class="text-2xl md:text-3xl font-bold text-white">Welcome back, {{ Auth::user()->firstname }}!
                        </h1>
                        <p class="mt-2 text-amber-100">Manage your artisan profile, services and bookings from your personal
                            dashboard.</p>
                    </div>
                    <div>
                        <a href="{{ route('artisan.profile') }}"
                            class="inline-block px-5 py-3 bg-white text-amber-700 font-semibold rounded-lg shadow hover:bg-amber-50 transition-colors">
                            Complete Your Profile
                        </a>
                    </div>
                </div>

                <!-- Profile Completion Bar -->
                @php
                    // Calculate profile completion percentage (placeholder logic)
                    $completionPercentage = isset($artisanProfile) ? 80 : 20;
                @endphp

                <div class="px-6 pb-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-white">Profile Completion</span>
                        <span class="text-sm font-medium text-white">{{ $completionPercentage }}%</span>
                    </div>
                    <div class="w-full bg-amber-200 rounded-full h-2.5">
                        <div class="bg-white h-2.5 rounded-full" style="width: {{ $completionPercentage }}%"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Stats Cards -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Active Services</p>
                            <p class="text-xl font-semibold">{{ $activeServicesCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Monthly Earnings</p>
                            <p class="text-xl font-semibold">€{{ $monthlyEarnings ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pending Bookings</p>
                            <p class="text-xl font-semibold">{{ $pendingBookingsCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Summary Card -->
                <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-6 rounded-lg shadow">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            @if (Auth::user()->profile_image)
                                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                                    alt="{{ Auth::user()->firstname }}"
                                    class="w-16 h-16 rounded-full object-cover border-2 border-amber-300">
                            @else
                                <div
                                    class="w-16 h-16 rounded-full bg-gradient-to-r from-amber-400 to-amber-600 flex items-center justify-center text-white text-xl font-bold">
                                    {{ strtoupper(substr(Auth::user()->firstname, 0, 1) . substr(Auth::user()->lastname, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-800">{{ Auth::user()->firstname }}
                                {{ Auth::user()->lastname }}</h3>
                            <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-200 text-amber-800 mt-1">
                                <svg class="mr-1.5 h-2 w-2 text-amber-600" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Artisan
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Profession</h4>
                            <p class="mt-1 text-sm">{{ $artisanProfile->profession ?? 'Not specified' }}</p>
                        </div>

                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Experience</h4>
                            <p class="mt-1 text-sm">{{ $artisanProfile->experience_years ?? 0 }} years</p>
                        </div>

                        <div>
                            <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Skills</h4>
                            <div class="mt-1 flex flex-wrap gap-1">
                                @if (isset($artisanProfile) && is_array($artisanProfile->skills) && count($artisanProfile->skills) > 0)
                                    @foreach ($artisanProfile->skills as $skill)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-500">No skills added yet</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('artisan.profile') }}"
                            class="text-amber-600 hover:text-amber-800 text-sm font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="lg:col-span-2">
                    <div class="bg-white p-6 rounded-lg shadow border border-gray-100 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-medium text-gray-800">My Services</h2>
                            <a href="{{ route('artisan.services') }}"
                                class="text-sm font-medium text-amber-600 hover:text-amber-800 flex items-center">
                                <span>View All</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        @if (isset($services) && count($services) > 0)
                            <div class="space-y-4">
                                @foreach ($services as $service)
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="bg-amber-100 text-amber-600 p-2 rounded mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-medium">{{ $service->title }}</h3>
                                            <p class="text-sm text-gray-500">€{{ $service->price }} ·
                                                {{ $service->duration }} min</p>
                                        </div>
                                        <a href="{{ route('artisan.services.edit', $service->id) }}"
                                            class="text-gray-400 hover:text-amber-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No services</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new service.</p>
                                <div class="mt-4">
                                    <a href="{{ route('artisan.services.create') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Add Service
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-medium text-gray-800">Recent Bookings</h2>
                            <a href="{{ route('artisan.bookings') }}"
                                class="text-sm font-medium text-amber-600 hover:text-amber-800 flex items-center">
                                <span>View All</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        @if (isset($bookings) && count($bookings) > 0)
                            <div class="overflow-hidden rounded-lg border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Client</th>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Service</th>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date</th>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($bookings as $booking)
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $booking->client_name }}</div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $booking->service_title }}</div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $booking->date_formatted }}
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $booking->status === 'confirmed'
                                                        ? 'bg-green-100 text-green-800'
                                                        : ($booking->status === 'pending'
                                                            ? 'bg-yellow-100 text-yellow-800'
                                                            : 'bg-red-100 text-red-800') }}">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings yet</h3>
                                <p class="mt-1 text-sm text-gray-500">When clients book your services, they'll appear here.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8">
                <h2 class="text-xl font-medium text-gray-800 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('artisan.services.create') }}"
                        class="bg-white p-6 rounded-lg shadow border border-gray-100 hover:bg-gray-50 transition flex flex-col items-center text-center group">
                        <div class="p-3 mb-3 rounded-full bg-amber-100 text-amber-600 group-hover:bg-amber-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-900">Add New Service</span>
                        <span class="text-xs text-gray-500 mt-1">Create a new service offering</span>
                    </a>

                    <a href="{{ route('artisan.portfolio') }}"
                        class="bg-white p-6 rounded-lg shadow border border-gray-100 hover:bg-gray-50 transition flex flex-col items-center text-center group">
                        <div class="p-3 mb-3 rounded-full bg-blue-100 text-blue-600 group-hover:bg-blue-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-900">Update Portfolio</span>
                        <span class="text-xs text-gray-500 mt-1">Add photos of your work</span>
                    </a>

                    <a href="{{ route('artisan.availability') }}"
                        class="bg-white p-6 rounded-lg shadow border border-gray-100 hover:bg-gray-50 transition flex flex-col items-center text-center group">
                        <div class="p-3 mb-3 rounded-full bg-green-100 text-green-600 group-hover:bg-green-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-900">Set Availability</span>
                        <span class="text-xs text-gray-500 mt-1">Manage your working hours</span>
                    </a>

                    <a href="{{ route('artisan.settings') }}"
                        class="bg-white p-6 rounded-lg shadow border border-gray-100 hover:bg-gray-50 transition flex flex-col items-center text-center group">
                        <div
                            class="p-3 mb-3 rounded-full bg-purple-100 text-purple-600 group-hover:bg-purple-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-900">Account Settings</span>
                        <span class="text-xs text-gray-500 mt-1">Update your preferences</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
