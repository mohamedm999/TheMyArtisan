@extends('layouts.admin')

@section('title', 'Artisan Services')

@section('content')
    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600">
                            {{ $artisan->firstname }} {{ $artisan->lastname }}'s Services
                        </span>
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">Manage and review services offered by this artisan</p>
                </div>
                <a href="{{ route('admin.artisans.show', $artisan->id) }}"
                    class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg font-medium text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Artisan Details
                </a>
            </div>

            <!-- Artisan Profile Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start">
                        <div class="flex-shrink-0 h-24 w-24 rounded-full overflow-hidden bg-gray-100 mb-4 sm:mb-0 sm:mr-6 border-4 border-white shadow">
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
                        <div class="text-center sm:text-left">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $artisan->firstname }} {{ $artisan->lastname }}</h2>
                            <div class="flex flex-col sm:flex-row sm:items-center mt-2 space-y-2 sm:space-y-0 sm:space-x-4">
                                <div class="flex items-center justify-center sm:justify-start text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm">{{ $artisan->email }}</span>
                                </div>
                                <div>
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
                            </div>

                            <!-- Artisan Stats -->
                            <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-4">
                                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                    <p class="text-xs text-gray-500 mb-1">Total Services</p>
                                    <p class="text-xl font-bold text-gray-900">
                                        {{ $artisan->artisanProfile && isset($artisan->artisanProfile->services) ? $artisan->artisanProfile->services->count() : 0 }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                    <p class="text-xs text-gray-500 mb-1">Active Services</p>
                                    <p class="text-xl font-bold text-gray-900">
                                        {{ $artisan->artisanProfile && isset($artisan->artisanProfile->services) ? $artisan->artisanProfile->services->where('is_active', true)->count() : 0 }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 col-span-2 sm:col-span-1">
                                    <p class="text-xs text-gray-500 mb-1">Categories</p>
                                    <p class="text-xl font-bold text-gray-900">
                                        {{ $artisan->artisanProfile && isset($artisan->artisanProfile->categories) ? $artisan->artisanProfile->categories->count() : 0 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services List Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Services Offered
                    </h3>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                        {{ $artisan->artisanProfile && isset($artisan->artisanProfile->services) ? $artisan->artisanProfile->services->count() : 0 }} Services
                    </span>
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
                                        Category
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
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($artisan->artisanProfile->services as $service)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-10 w-10 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                                                    @if ($service->image)
                                                        <img src="{{ Storage::url($service->image) }}"
                                                            alt="{{ $service->name }}"
                                                            class="h-10 w-10 object-cover">
                                                    @else
                                                        <div
                                                            class="h-10 w-10 bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $service->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 max-w-xs truncate">
                                                        {{ Str::limit($service->description, 50) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($service->category)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                    {{ $service->category->name }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-500">No category</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ number_format($service->price, 2) }} MAD
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $service->duration }} minutes
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($service->is_active)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                                    Active
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button type="button"
                                                onclick="showServiceDetails('{{ $service->id }}', '{{ $service->name }}', '{{ addslashes($service->description) }}', '{{ $service->price }}', '{{ $service->duration }}', '{{ $service->is_active ? 'Active' : 'Inactive' }}', '{{ $service->category ? $service->category->name : 'No Category' }}')"
                                                class="inline-flex items-center justify-center p-1.5 text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-600 rounded-lg transition-colors duration-200"
                                                title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900">No services found</h4>
                        <p class="text-sm text-gray-500 mt-2 max-w-md">This artisan has not listed any services yet. Services will appear here once they are created.</p>
                    </div>
                @endif
            </div>

            <!-- Service Booking Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Service Booking Summary
                    </h3>
                </div>

                <div class="p-6">
                    @if (
                        $artisan->artisanProfile &&
                            isset($artisan->artisanProfile->services) &&
                            $artisan->artisanProfile->services->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($artisan->artisanProfile->services as $service)
                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300">
                                    <div class="px-5 py-4 bg-gray-50 border-b border-gray-200">
                                        <div class="flex justify-between items-center">
                                            <h3 class="text-lg font-semibold text-gray-900 truncate" title="{{ $service->name }}">
                                                {{ Str::limit($service->name, 20) }}
                                            </h3>
                                            @if ($service->is_active)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center mt-1 text-sm text-gray-500">
                                            <span class="font-medium text-gray-900">{{ number_format($service->price, 2) }} MAD</span>
                                            <span class="mx-2">•</span>
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $service->duration }} min
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-5">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 flex flex-col items-center justify-center">
                                                <span class="text-xs text-gray-500 mb-1">Bookings</span>
                                                <span class="text-xl font-bold text-gray-900">{{ $service->bookings ? $service->bookings->count() : 0 }}</span>
                                            </div>
                                            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 flex flex-col items-center justify-center">
                                                <span class="text-xs text-gray-500 mb-1">Reviews</span>
                                                <div class="flex items-center">
                                                    <span class="text-xl font-bold text-gray-900 mr-1">{{ $service->reviews ? $service->reviews->count() : 0 }}</span>
                                                    @if ($service->reviews && $service->reviews->count() > 0)
                                                        <div class="flex text-amber-400">
                                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Category</span>
                                            <div class="mt-1">
                                                @if ($service->category)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                        {{ $service->category->name }}
                                                    </span>
                                                @else
                                                    <span class="text-sm text-gray-500">No category assigned</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 flex flex-col items-center justify-center text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900">No booking data available</h4>
                            <p class="text-sm text-gray-500 mt-2 max-w-md">No services available to generate booking summary. Booking statistics will appear here once services are created and booked.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Navigation buttons -->
            <div class="flex flex-col sm:flex-row justify-between gap-4 mb-8">
                <a href="{{ route('admin.artisans.show', $artisan->id) }}"
                    class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg font-medium text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Artisan Details
                </a>
                <a href="{{ route('admin.artisans.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 border border-transparent rounded-lg font-medium text-sm text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    All Artisans
                </a>
            </div>
        </div>
    </div>

    <!-- Service Details Modal -->
    <div id="service-details-modal"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden flex items-center justify-center z-50 backdrop-blur-sm transition-opacity duration-300">
        <div class="bg-white rounded-xl max-w-2xl w-full p-0 shadow-xl transform transition-all duration-300 scale-100">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900" id="modal-service-name">Service Details</h3>
                <button type="button" onclick="hideServiceDetails()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6" id="modal-service-details">
                <!-- Details will be loaded here -->
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                <button type="button" onclick="hideServiceDetails()"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Enhanced modal functionality for service details
        function showServiceDetails(serviceId, name, description, price, duration, status, category) {
            document.getElementById('modal-service-name').innerText = name;

            // Create a more detailed and visually appealing content
            let statusClass = status === 'Active' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 'bg-red-100 text-red-800 border-red-200';
            let statusDot = status === 'Active' ? 'bg-emerald-500' : 'bg-red-500';

            document.getElementById('modal-service-details').innerHTML = `
                <div class="space-y-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Description</h4>
                        <p class="text-gray-900">${description || 'No description provided.'}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Details</h4>
                            <div class="bg-gray-50 rounded-lg border border-gray-100 p-4 space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Price:</span>
                                    <span class="text-sm font-medium text-gray-900">${price} MAD</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Duration:</span>
                                    <span class="text-sm font-medium text-gray-900">${duration} minutes</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Category:</span>
                                    <span class="text-sm font-medium text-gray-900">${category}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Status:</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClass} border">
                                        <span class="h-1.5 w-1.5 rounded-full ${statusDot} mr-1.5"></span>
                                        ${status}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Service ID</h4>
                            <div class="bg-gray-50 rounded-lg border border-gray-100 p-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-mono text-gray-600">${serviceId}</span>
                                    <button onclick="navigator.clipboard.writeText('${serviceId}')" class="text-blue-600 hover:text-blue-800 text-sm">
                                        Copy
                                    </button>
                                </div>
                            </div>

                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mt-4 mb-2">Actions</h4>
                            <div class="flex space-x-2">
                                <button class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View Bookings
                                </button>
                                <button class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Service
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Show the modal with animation
            const modal = document.getElementById('service-details-modal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100');
            }, 10);
        }

        function hideServiceDetails() {
            // Hide the modal with animation
            const modal = document.getElementById('service-details-modal');
            modal.classList.remove('opacity-100');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
@endsection
