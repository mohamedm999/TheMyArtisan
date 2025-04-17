@extends('layouts.admin')

@section('title', 'Manage Artisans')

@section('content')
    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Artisan Management</h1>
                    <p class="mt-1 text-sm text-gray-600">Manage and approve artisan profiles on your platform</p>
                </div>
                <!-- Temporarily commenting out export button until route is defined -->
                <!--
                <a href="{{ route('admin.artisans.export') }}"
                    class="inline-flex items-center px-4 py-2.5 bg-emerald-600 border border-transparent rounded-lg font-medium text-sm text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Artisans
                </a>
                -->
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-xl bg-green-50 p-4 border border-green-200 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button onclick="this.parentElement.parentElement.parentElement.parentElement.remove()"
                                    class="inline-flex p-1.5 text-green-500 rounded-md hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-50 rounded-lg p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Total Artisans</h3>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 w-full bg-blue-500"></div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-amber-50 rounded-lg p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Pending Approval</h3>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['pending'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 w-full bg-amber-500"></div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-emerald-50 rounded-lg p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Approved</h3>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['approved'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 w-full bg-emerald-500"></div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-50 rounded-lg p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Rejected</h3>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['rejected'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-1 w-full bg-red-500"></div>
                </div>
            </div>

            <!-- Filters Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Search & Filters
                    </h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.artisans.index') }}"
                        class="space-y-4 md:space-y-0 md:grid md:grid-cols-12 md:gap-4 items-end">
                        <div class="md:col-span-5">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-lg"
                                    placeholder="Name, email or specialty">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <select name="country" id="country"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                                <option value="">All Countries</option>
                                @foreach ($countries ?? [] as $country)
                                    <option value="{{ $country->id }}"
                                        {{ request('country') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category" id="category"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                                <option value="">All Categories</option>
                                @foreach ($categories ?? [] as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-1 flex space-x-3">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Artisans Table Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        All Artisans
                    </h3>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                        {{ $artisans->total() }} Artisans
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        Artisan
                                        <button class="ml-1 text-gray-400 hover:text-gray-600 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                        </button>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Specialty & Categories
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Location
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Services & Reviews
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        Status
                                        <button class="ml-1 text-gray-400 hover:text-gray-600 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                        </button>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($artisans as $artisan)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden border border-gray-200 shadow-sm">
                                                @if ($artisan->artisanProfile && $artisan->artisanProfile->profile_photo)
                                                    <img class="h-12 w-12 object-cover"
                                                        src="{{ Storage::url($artisan->artisanProfile->profile_photo) }}"
                                                        alt="{{ $artisan->firstname }}">
                                                @else
                                                    <div
                                                        class="h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center rounded-full">
                                                        {{ substr($artisan->firstname, 0, 1) }}{{ substr($artisan->lastname, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $artisan->firstname }} {{ $artisan->lastname }}
                                                </div>
                                                <div class="text-sm text-gray-500 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $artisan->email }}
                                                </div>
                                                <div class="text-xs text-gray-500 flex items-center mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    Joined {{ $artisan->created_at->format('M d, Y') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 font-medium">
                                            @if (
                                                $artisan->artisanProfile &&
                                                    $artisan->artisanProfile->categories &&
                                                    $artisan->artisanProfile->categories->count() > 0)
                                                {{ $artisan->artisanProfile->categories->first()->name ?? 'Not specified' }}
                                            @else
                                                <span class="text-gray-500">Not specified</span>
                                            @endif
                                        </div>
                                        <div class="flex flex-wrap gap-1 mt-1.5">
                                            @if (
                                                $artisan->artisanProfile &&
                                                    $artisan->artisanProfile->categories &&
                                                    $artisan->artisanProfile->categories->count() > 0)
                                                @foreach ($artisan->artisanProfile->categories->take(3) as $category)
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                        {{ $category->name }}
                                                    </span>
                                                @endforeach
                                                @if ($artisan->artisanProfile->categories->count() > 3)
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                        +{{ $artisan->artisanProfile->categories->count() - 3 }} more
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-xs text-gray-500">No categories</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($artisan->artisanProfile)
                                            <div class="text-sm text-gray-900 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                @if ($artisan->artisanProfile->city)
                                                    {{ is_object($artisan->artisanProfile->city) ? $artisan->artisanProfile->city->name : $artisan->artisanProfile->city }},
                                                    @if ($artisan->artisanProfile->country)
                                                        {{ is_object($artisan->artisanProfile->country) ? $artisan->artisanProfile->country->name : $artisan->artisanProfile->country }}
                                                    @else
                                                        Unknown Country
                                                    @endif
                                                @else
                                                    {{ $artisan->artisanProfile->address ?? 'Location not specified' }}
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500 flex items-center mt-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                                </svg>
                                                Service radius: {{ $artisan->artisanProfile->service_radius ?? '0' }} km
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-500">Not specified</div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-sm flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2   stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01" />
                                            </svg>
                                            <span class="font-medium">
                                                {{ $artisan->artisanProfile && isset($artisan->artisanProfile->services) ? $artisan->artisanProfile->services->count() : 0 }}
                                            </span>
                                            <span class="ml-1">Services</span>
                                        </div>
                                        @if (
                                            $artisan->artisanProfile &&
                                                isset($artisan->artisanProfile->reviews) &&
                                                $artisan->artisanProfile->reviews->count() > 0)
                                            <div class="flex items-center mt-1.5">
                                                <div class="flex text-amber-400">
                                                    @php
                                                        $reviews = $artisan->artisanProfile->reviews;
                                                        $avgRating = $reviews->avg('rating') ?? 0;
                                                        $avgRating = round($avgRating);
                                                    @endphp
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $avgRating)
                                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                                                <path
                                                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                                </path>
                                                            </svg>
                                                        @else
                                                            <svg class="w-4 h-4 fill-current text-gray-300"
                                                                viewBox="0 0 24 24">
                                                                <path
                                                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                                </path>
                                                            </svg>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="text-xs text-gray-500 ml-1.5">
                                                    ({{ $artisan->artisanProfile->reviews->count() }} reviews)
                                                </span>
                                            </div>
                                        @else
                                            <div class="text-xs text-gray-500 mt-1.5">No reviews yet</div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($artisan->artisanProfile)
                                            @php
                                                // Get status from the database field or default to 'pending'
                                                $statusField = $artisan->artisanProfile->getAttributes();
                                                $status = isset($statusField['status'])
                                                    ? $statusField['status']
                                                    : 'pending';
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
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex flex-col space-y-2">
                                            <a href="{{ route('admin.artisans.show', $artisan->id) }}"
                                                class="inline-flex items-center justify-center p-1.5 text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 rounded-lg transition-colors duration-200"
                                                title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            @if ($artisan->artisanProfile && $artisan->artisanProfile->status === 'pending')
                                                <form method="POST"
                                                    action="{{ route('admin.artisans.approve', $artisan->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="inline-flex items-center justify-center p-1.5 text-emerald-600 hover:text-white bg-emerald-50 hover:bg-emerald-600 rounded-lg transition-colors duration-200"
                                                        title="Approve Artisan">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                <form method="POST"
                                                    action="{{ route('admin.artisans.reject', $artisan->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="inline-flex items-center justify-center p-1.5 text-red-600 hover:text-white bg-red-50 hover:bg-red-600 rounded-lg transition-colors duration-200"
                                                        title="Reject Artisan">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('admin.artisans.services', $artisan->id) }}"
                                                class="inline-flex items-center justify-center p-1.5 text-purple-600 hover:text-white bg-purple-50 hover:bg-purple-600 rounded-lg transition-colors duration-200"
                                                title="Manage Services">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                            </div>
                                            <p class="text-lg font-medium text-gray-900">No artisans found</p>
                                            <p class="text-sm text-gray-500 mt-2">Try adjusting your search or filter to find what you're looking for.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $artisans->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
