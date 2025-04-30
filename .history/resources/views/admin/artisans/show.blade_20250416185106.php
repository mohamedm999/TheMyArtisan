@extends('layouts.admin')

@section('title', 'Artisan Details')

@section('content')
    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600">
                            Artisan Profile
                        </span>
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">View and manage artisan details and services</p>
                </div>
                <a href="{{ route('admin.artisans.index') }}"
                    class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg font-medium text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Artisans
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Artisan Profile -->
                <div class="lg:col-span-1">
                    <!-- Profile Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                        <div class="p-6">
                            <div class="flex flex-col items-center text-center">
                                <div class="h-24 w-24 rounded-full overflow-hidden bg-gray-100 mb-4 border-4 border-white shadow">
                                    @if ($artisan->artisanProfile && $artisan->artisanProfile->profile_photo)
                                        <img src="{{ Storage::url($artisan->artisanProfile->profile_photo) }}"
                                            alt="{{ $artisan->firstname }}" class="h-full w-full object-cover">
                                    @else
                                        <div
                                            class="h-full w-full bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center">
                                            <span
                                                class="text-2xl font-bold">{{ substr($artisan->firstname, 0, 1) }}{{ substr($artisan->lastname, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <h2 class="text-xl font-bold text-gray-900">{{ $artisan->firstname }} {{ $artisan->lastname }}</h2>
                                <p class="text-sm text-gray-500 mt-1">{{ $artisan->email }}</p>

                                <div class="mt-3">
                                    @if ($artisan->artisanProfile)
                                        @php
                                            $statusField = $artisan->artisanProfile->getAttributes();
                                            $status = isset($statusField['status']) ? $statusField['status'] : 'pending';
                                        @endphp
                                        @if ($status === 'approved')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                                Approved
                                            </span>
                                        @elseif($status === 'rejected')
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                                Rejected
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>
                                                Pending
                                            </span>
                                        @endif
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                            <span class="h-1.5 w-1.5 rounded-full bg-gray-500 mr-1.5"></span>
                                            No Profile
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-4 text-sm text-gray-500 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Joined {{ $artisan->created_at->format('M d, Y') }}
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Contact Information</h3>
                                <ul class="space-y-3">
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-md bg-blue-50 text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-xs text-gray-500">Email</p>
                                            <p class="text-sm font-medium text-gray-900">{{ $artisan->email }}</p>
                                        </div>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-md bg-blue-50 text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-xs text-gray-500">Phone</p>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $artisan->artisanProfile->phone ?? 'Not provided' }}
                                            </p>
                                        </div>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-md bg-blue-50 text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-xs text-gray-500">Address</p>
                                            <p class="text-sm font-medium text-gray-900">
                                                @if ($artisan->artisanProfile && $artisan->artisanProfile->address)
                                                    {{ $artisan->artisanProfile->address }}<br>
                                                    @if ($artisan->artisanProfile->city)
                                                        {{ is_object($artisan->artisanProfile->city) ? $artisan->artisanProfile->city->name : $artisan->artisanProfile->city }}
                                                    @endif
                                                    @if ($artisan->artisanProfile->state)
                                                        {{ $artisan->artisanProfile->state }}
                                                    @endif
                                                    @if ($artisan->artisanProfile->postal_code)
                                                        {{ $artisan->artisanProfile->postal_code }}
                                                    @endif
                                                    @if ($artisan->artisanProfile->country)
                                                        <br>{{ is_object($artisan->artisanProfile->country) ? $artisan->artisanProfile->country->name : $artisan->artisanProfile->country }}
                                                    @endif
                                                @else
                                                    Not provided
                                                @endif
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <!-- Quick Stats -->
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Quick Stats</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                        <p class="text-xs text-gray-500 mb-1">Services</p>
                                        <p class="text-xl font-bold text-gray-900">
                                            {{ $artisan->artisanProfile && isset($artisan->artisanProfile->services) ? $artisan->artisanProfile->services->count() : 0 }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                        <p class="text-xs text-gray-500 mb-1">Bookings</p>
                                        <p class="text-xl font-bold text-gray-900">
                                            {{ $artisan->artisanProfile && isset($artisan->artisanProfile->bookings) ? $artisan->artisanProfile->bookings->count() : 0 }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                        <p class="text-xs text-gray-500 mb-1">Reviews</p>
                                        <p class="text-xl font-bold text-gray-900">
                                            {{ $artisan->artisanProfile && isset($artisan->artisanProfile->reviews) ? $artisan->artisanProfile->reviews->count() : 0 }}
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                        <p class="text-xs text-gray-500 mb-1">Rating</p>
                                        <div class="flex items-center">
                                            @if ($artisan->artisanProfile && isset($artisan->artisanProfile->reviews) && $artisan->artisanProfile->reviews->count() > 0)
                                                @php
                                                    $avgRating = $artisan->artisanProfile->reviews->avg('rating') ?? 0;
                                                    $avgRating = round($avgRating, 1);
                                                @endphp
                                                <p class="text-xl font-bold text-gray-900 mr-1">{{ $avgRating }}</p>
                                                <div class="flex text-amber-400">
                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <p class="text-xl font-bold text-gray-900">N/A</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if ($artisan->artisanProfile)
                        @php
                            $statusField = $artisan->artisanProfile->getAttributes();
                            $status = isset($statusField['status']) ? $statusField['status'] : 'pending';
                        @endphp

                        @if ($status === 'pending')
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                                <div class="p-6">
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Actions</h3>
                                    <div class="flex flex-col space-y-3">
                                        <form method="POST" action="{{ route('admin.artisans.approve', $artisan->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-emerald-600 border border-transparent rounded-lg font-medium text-sm text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Approve Artisan
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.artisans.reject', $artisan->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-red-600 border border-transparent rounded-lg font-medium text-sm text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Reject Artisan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Right Column - Artisan Details -->
                <div class="lg:col-span-2">
                    <!-- Professional Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Professional Information
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Specialty</h4>
                                    <p class="text-gray-900 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        {{ $artisan->artisanProfile && $artisan->artisanProfile->specialty ? $artisan->artisanProfile->specialty : 'Not specified' }}
                                    </p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Years of Experience</h4>
                                    <p class="text-gray-900 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        {{ $artisan->artisanProfile && $artisan->artisanProfile->years_experience ? $artisan->artisanProfile->years_experience . ' years' : 'Not specified' }}
                                    </p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Service Radius</h4>
                                    <p class="text-gray-900 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        {{ $artisan->artisanProfile && $artisan->artisanProfile->service_radius ? $artisan->artisanProfile->service_radius . ' km' : 'Not specified' }}
                                    </p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Categories</h4>
                                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        @if (
                                            $artisan->artisanProfile &&
                                                isset($artisan->artisanProfile->categories) &&
                                                $artisan->artisanProfile->categories->count() > 0)
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($artisan->artisanProfile->categories as $category)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                        {{ $category->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-gray-500">No categories assigned</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if ($artisan->artisanProfile)
                                <div class="mb-6">
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Bio</h4>
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                        <p class="text-gray-900">{{ $artisan->artisanProfile->bio ?? 'No bio provided.' }}</p>
                                    </div>
                                </div>

                                @if (isset($artisan->artisanProfile->skills) &&
                                        is_array($artisan->artisanProfile->skills) &&
                                        count($artisan->artisanProfile->skills) > 0)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Skills</h4>
                                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($artisan->artisanProfile->skills as $skill)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                        {{ $skill }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Services
                            </h3>
                            <div class="flex items-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200 mr-3">
                                    {{ $artisan->artisanProfile && isset($artisan->artisanProfile->services) ? $artisan->artisanProfile->services->count() : 0 }} Services
                                </span>
                                <a href="{{ route('admin.artisans.services', $artisan->id) }}"
                                    class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                    View All
                                </a>
                            </div>
                        </div>

                        @if (
                            $artisan->artisanProfile &&
                                isset($artisan->artisanProfile->services) &&
                                $artisan->artisanProfile->services->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Service Name
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Price
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Duration
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($artisan->artisanProfile->services->take(5) as $service)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div
                                                            class="flex-shrink-0 h-8 w-8 rounded-md overflow-hidden bg-gray-100 border border-gray-200">
                                                            @if ($service->image)
                                                                <img src="{{ Storage::url($service->image) }}"
                                                                    alt="{{ $service->name }}"
                                                                    class="h-8 w-8 object-cover">
                                                            @else
                                                                <div
                                                                    class="h-8 w-8 bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 flex items-center justify-center">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ml-3">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $service->name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ number_format($service->price, 2) }} MAD
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500 flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linej
