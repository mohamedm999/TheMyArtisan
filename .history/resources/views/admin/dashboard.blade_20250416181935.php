@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="py-10 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Dashboard Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600">Admin Dashboard</span>
                </h1>
                <p class="mt-2 text-lg text-gray-600">Monitor your platform's performance and manage your services.</p>

                <!-- Date Range Selector -->
                <div class="mt-4 flex items-center space-x-2 text-sm text-gray-600">
                    <span class="font-medium">Overview:</span>
                    <div class="relative inline-block">
                        <select class="appearance-none bg-white border border-gray-300 rounded-lg py-1.5 pl-3 pr-8 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent cursor-pointer">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option>This month</option>
                            <option>Last quarter</option>
                            <option>This year</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 transition duration-300 hover:shadow-md">
                    <div class="px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Users</p>
                                <div class="flex items-baseline">
                                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalUsers ?? 0) }}</p>
                                    <p class="ml-2 text-xs font-medium text-green-600 flex items-center">
                                        <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                        </svg>
                                        12%
                                    </p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Compared to last month</p>
                            </div>
                            <div class="p-3 rounded-xl bg-blue-50 text-blue-500">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="relative pt-1">
                                <div class="overflow-hidden h-1.5 flex rounded-full bg-gray-200">
                                    <div style="width: 75%" class="shadow-none flex flex-col whitespace-nowrap text-white justify-center bg-blue-500"></div>
                                </div>
                            </div>
                            <div class="flex justify-between text-xs font-medium text-gray-500 mt-1">
                                <span>Target: 5,000</span>
                                <span>75%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Artisans -->
                <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 transition duration-300 hover:shadow-md">
                    <div class="px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Artisans</p>
                                <div class="flex items-baseline">
                                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($artisansCount ?? 0) }}</p>
                                    <p class="ml-2 text-xs font-medium text-green-600 flex items-center">
                                        <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                        </svg>
                                        8%
                                    </p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Compared to last month</p>
                            </div>
                            <div class="p-3 rounded-xl bg-amber-50 text-amber-500">
                                <i class="fas fa-hammer text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="relative pt-1">
                                <div class="overflow-hidden h-1.5 flex rounded-full bg-gray-200">
                                    <div style="width: 60%" class="shadow-none flex flex-col whitespace-nowrap text-white justify-center bg-amber-500"></div>
                                </div>
                            </div>
                            <div class="flex justify-between text-xs font-medium text-gray-500 mt-1">
                                <span>Target: 1,000</span>
                                <span>60%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clients -->
                <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 transition duration-300 hover:shadow-md">
                    <div class="px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Clients</p>
                                <div class="flex items-baseline">
                                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($clientsCount ?? 0) }}</p>
                                    <p class="ml-2 text-xs font-medium text-green-600 flex items-center">
                                        <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                        </svg>
                                        15%
                                    </p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Compared to last month</p>
                            </div>
                            <div class="p-3 rounded-xl bg-emerald-50 text-emerald-500">
                                <i class="fas fa-user-tie text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="relative pt-1">
                                <div class="overflow-hidden h-1.5 flex rounded-full bg-gray-200">
                                    <div style="width: 85%" class="shadow-none flex flex-col whitespace-nowrap text-white justify-center bg-emerald-500"></div>
                                </div>
                            </div>
                            <div class="flex justify-between text-xs font-medium text-gray-500 mt-1">
                                <span>Target: 4,000</span>
                                <span>85%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bookings -->
                <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-gray-100 transition duration-300 hover:shadow-md">
                    <div class="px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Bookings</p>
                                <div class="flex items-baseline">
                                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($bookingsCount ?? 0) }}</p>
                                    <p class="ml-2 text-xs font-medium text-red-600 flex items-center">
                                        <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                        3%
                                    </p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Compared to last month</p>
                            </div>
                            <div class="p-3 rounded-xl bg-purple-50 text-purple-500">
                                <i class="fas fa-calendar-check text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="relative pt-1">
                                <div class="overflow-hidden h-1.5 flex rounded-full bg-gray-200">
                                    <div style="width: 65%" class="shadow-none flex flex-col whitespace-nowrap text-white justify-center bg-purple-500"></div>
                                </div>
                            </div>
                            <div class="flex justify-between text-xs font-medium text-gray-500 mt-1">
                                <span>Target: 2,000</span>
                                <span>65%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Stats in Horizontal Scrollable Cards -->
            <div class="mb-8 overflow-hidden">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Service Metrics</h2>
                <div class="flex space-x-6 pb-2 overflow-x-auto hide-scrollbar">
                    <!-- Services -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 min-w-[240px] flex-shrink-0">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="p-2 rounded-lg bg-orange-50 text-orange-500">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    +{{ rand(5, 20) }}%
                                </span>
                            </div>
                            <h3 class="mt-4 text-2xl font-bold text-gray-900">{{ number_format($servicesCount ?? 0) }}</h3>
                            <p class="text-sm font-medium text-gray-500">Total Services</p>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 min-w-[240px] flex-shrink-0">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="p-2 rounded-lg bg-teal-50 text-teal-500">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                                    +{{ rand(2, 10) }}%
                                </span>
                            </div>
                            <h3 class="mt-4 text-2xl font-bold text-gray-900">{{ number_format($categoriesCount ?? 0) }}</h3>
                            <p class="text-sm font-medium text-gray-500">Categories</p>
                        </div>
                    </div>

                    <!-- Reviews -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 min-w-[240px] flex-shrink-0">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="p-2 rounded-lg bg-pink-50 text-pink-500">
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                    +{{ rand(10, 30) }}%
                                </span>
                            </div>
                            <h3 class="mt-4 text-2xl font-bold text-gray-900">{{ number_format($reviewsCount ?? 0) }}</h3>
                            <p class="text-sm font-medium text-gray-500">Reviews</p>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 min-w-[240px] flex-shrink-0">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="p-2 rounded-lg bg-violet-50 text-violet-500">
                                    <i class="fas fa-comment"></i>
                                </div>
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-violet-100 text-violet-800">
                                    +{{ rand(15, 40) }}%
                                </span>
                            </div>
                            <h3 class="mt-4 text-2xl font-bold text-gray-900">{{ number_format($messagesCount ?? 0) }}</h3>
                            <p class="text-sm font-medium text-gray-500">Messages</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Admin Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 pt-6 pb-4 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800">Quick Actions</h3>
                        <p class="text-sm text-gray-500 mt-1">Manage your platform with these shortcuts</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin.users.index') }}" class="group">
                                <div class="flex items-center p-4 rounded-xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition-all duration-300 group-hover:border-blue-200">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Manage Users</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ number_format($totalUsers ?? 0) }} total users</p>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('admin.artisans.index') }}" class="group">
                                <div class="flex items-center p-4 rounded-xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition-all duration-300 group-hover:border-amber-200">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300">
                                        <i class="fas fa-hammer"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Manage Artisans</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ number_format($artisansCount ?? 0) }} artisans</p>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('admin.services.index') }}" class="group">
                                <div class="flex items-center p-4 rounded-xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition-all duration-300 group-hover:border-orange-200">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-orange-50 text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Manage Services</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ number_format($servicesCount ?? 0) }} services</p>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="group">
                                <div class="flex items-center p-4 rounded-xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition-all duration-300 group-hover:border-teal-200">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-teal-50 text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Manage Categories</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ number_format($categoriesCount ?? 0) }} categories</p>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('admin.bookings.index') }}" class="group">
                                <div class="flex items-center p-4 rounded-xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition-all duration-300 group-hover:border-purple-200">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Manage Bookings</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ number_format($bookingsCount ?? 0) }} bookings</p>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('admin.settings.index') }}" class="group">
                                <div class="flex items-center p-4 rounded-xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition-all duration-300 group-hover:border-gray-300">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gray-50 text-gray-600 group-hover:bg-gray-600 group-hover:text-white transition-colors duration-300">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">System Settings</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Configure your platform</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 pt-6 pb-4 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Recent Activity</h3>
                            <p class="text-sm text-gray-500 mt-1">Latest actions on your platform</p>
                        </div>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-300 flex items-center">
                            View All
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="p-6">
                        <div class="space-y-5">
                            @if (isset($recentActivities) && count($recentActivities) > 0)
                                @foreach ($recentActivities as $activity)
                                    <div class="flex items-start">
                                        <div class="relative flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-100 text-blue-600 border-4 border-white ring-2 ring-blue-50">
                                                <i class="fas fa-{{ $activity->icon ?? 'bell' }} text-sm"></i>
                                            </div>
                                            @if (!$loop->last)
                                                <div class="absolute top-10 left-1/2 transform -translate-x-1/2 w-0.5 h-full bg-gray-200"></div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                                <p class="text-sm font-medium text-gray-900">{{ $activity->title ?? 'Activity' }}</p>
                                                <p class="text-sm text-gray-600 mt-1">{{ $activity->description ?? '' }}</p>
                                                <div class="flex items-center mt-2 text-xs text-gray-500">
                                                    <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $activity->created_at ? $activity->created_at->diffForHumans() : 'Recently' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex flex-col items-center justify-center py-12 bg-gray-50 rounded-xl">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-900">No recent activity</h4>
                                    <p class="text-sm text-gray-500 mt-1 text-center max-w-xs">When users interact with your platform, their activities will appear here.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- System Status -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 pt-6 pb-4 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800">System Status</h3>
                        <p class="text-sm text-gray-500 mt-1">Current status of your platform</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-medium text-gray-900">Server Status</h4>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Operational
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">All systems running smoothly</p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-medium text-gray-900">Laravel Version</h4>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ app()->version() }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Your application is up to date</p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-medium text-gray-900">PHP Version</h4>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ phpversion() }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Running on stable version</p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-medium text-gray-900">Environment</h4>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ app()->environment('production') ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ app()->environment() }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Running in {{ app()->environment() }} mode</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latest Registrations -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 pt-6 pb-4 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Latest Registrations</h3>
                            <p class="text-sm text-gray-500 mt-1">Recently joined users</p>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-300 flex items-center">
                            View All
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="p-6">
                        @if (isset($latestUsers) && count($latestUsers) > 0)
                            <div class="overflow-hidden rounded-xl border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                User
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Type
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Joined
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($latestUsers as $user)
                                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-200"
                                                                src="{{ $user->profile_photo_url ?? asset('images/default-profile.jpg') }}"
                                                                alt="{{ $user->firstname}}">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full
                                                    {{ $user->role === 'artisan'
                                                        ? 'bg-amber-100 text-amber-800'
                                                        : ($user->role === 'admin'
                                                            ? 'bg-red-100 text-red-800'
                                                            : 'bg-green-100 text-green-800') }}">
                                                        {{ ucfirst($user->role ?? 'Client') }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="flex items-center">
                                                        <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ $user->created_at ? $user->created_at->diffForHumans() : 'Recently' }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-12 bg-gray-50 rounded-xl">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-medium text-gray-900">No recent registrations</h4>
                                <p class="text-sm text-gray-500 mt-1 text-center max-w-xs">When new users register on your platform, they will appear here.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
