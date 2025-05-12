@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                <div class="p-8 bg-white border-b border-gray-200">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Dashboard</h1>
                    <p class="text-gray-500 mb-6">Welcome back! Here's what's happening with your platform.</p>

                    <!-- Stats Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl shadow-sm border border-blue-200 transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-blue-500 bg-opacity-90 text-white mr-4 shadow-sm">
                                    <i class="fas fa-users text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-blue-600">Total Users</p>
                                    <p class="text-3xl font-bold text-gray-800">{{ $totalUsers ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-6 rounded-xl shadow-sm border border-amber-200 transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-amber-500 bg-opacity-90 text-white mr-4 shadow-sm">
                                    <i class="fas fa-hammer text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-amber-600">Artisans</p>
                                    <p class="text-3xl font-bold text-gray-800">{{ $artisansCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl shadow-sm border border-green-200 transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-green-500 bg-opacity-90 text-white mr-4 shadow-sm">
                                    <i class="fas fa-user-tie text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-green-600">Clients</p>
                                    <p class="text-3xl font-bold text-gray-800">{{ $clientsCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl shadow-sm border border-purple-200 transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-purple-500 bg-opacity-90 text-white mr-4 shadow-sm">
                                    <i class="fas fa-calendar-check text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-purple-600">Bookings</p>
                                    <p class="text-3xl font-bold text-gray-800">{{ $bookingsCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-6 rounded-xl shadow-sm border border-orange-200 transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-orange-500 bg-opacity-90 text-white mr-4 shadow-sm">
                                    <i class="fas fa-briefcase text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-orange-600">Services</p>
                                    <p class="text-3xl font-bold text-gray-800">{{ $servicesCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-teal-50 to-teal-100 p-6 rounded-xl shadow-sm border border-teal-200 transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-teal-500 bg-opacity-90 text-white mr-4 shadow-sm">
                                    <i class="fas fa-tags text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-teal-600">Categories</p>
                                    <p class="text-3xl font-bold text-gray-800">{{ $categoriesCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-pink-50 to-pink-100 p-6 rounded-xl shadow-sm border border-pink-200 transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-pink-500 bg-opacity-90 text-white mr-4 shadow-sm">
                                    <i class="fas fa-star text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-pink-600">Reviews</p>
                                    <p class="text-3xl font-bold text-gray-800">{{ $reviewsCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-xl shadow-sm border border-indigo-200 transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
                            <div class="flex items-center">
                                <div class="p-3 rounded-xl bg-indigo-500 bg-opacity-90 text-white mr-4 shadow-sm">
                                    <i class="fas fa-comment text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-indigo-600">Messages</p>
                                    <p class="text-3xl font-bold text-gray-800">{{ $messagesCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                        <!-- Admin Actions -->
                        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                                Quick Actions
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <a href="{{ route('admin.users.index') }}"
                                    class="flex items-center p-4 bg-blue-50 rounded-xl text-blue-700 hover:bg-blue-100 transition-all duration-300 hover:shadow-md group">
                                    <div class="p-3 rounded-lg bg-blue-100 text-blue-500 mr-3 group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <span class="font-medium">Manage Users</span>
                                </a>
                                <a href="{{ route('admin.artisans.index') }}"
                                    class="flex items-center p-4 bg-amber-50 rounded-xl text-amber-700 hover:bg-amber-100 transition-all duration-300 hover:shadow-md group">
                                    <div class="p-3 rounded-lg bg-amber-100 text-amber-500 mr-3 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                                        <i class="fas fa-hammer"></i>
                                    </div>
                                    <span class="font-medium">Manage Artisans</span>
                                </a>
                                <a href="{{ route('admin.services.index') }}"
                                    class="flex items-center p-4 bg-orange-50 rounded-xl text-orange-700 hover:bg-orange-100 transition-all duration-300 hover:shadow-md group">
                                    <div class="p-3 rounded-lg bg-orange-100 text-orange-500 mr-3 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <span class="font-medium">Manage Services</span>
                                </a>
                                <a href="{{ route('admin.categories.index') }}"
                                    class="flex items-center p-4 bg-teal-50 rounded-xl text-teal-700 hover:bg-teal-100 transition-all duration-300 hover:shadow-md group">
                                    <div class="p-3 rounded-lg bg-teal-100 text-teal-500 mr-3 group-hover:bg-teal-500 group-hover:text-white transition-colors duration-300">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                    <span class="font-medium">Manage Categories</span>
                                </a>
                                <a href="{{ route('admin.bookings.index') }}"
                                    class="flex items-center p-4 bg-purple-50 rounded-xl text-purple-700 hover:bg-purple-100 transition-all duration-300 hover:shadow-md group">
                                    <div class="p-3 rounded-lg bg-purple-100 text-purple-500 mr-3 group-hover:bg-purple-500 group-hover:text-white transition-colors duration-300">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <span class="font-medium">Manage Bookings</span>
                                </a>
                                <a href="{{ route('admin.settings.index') }}"
                                    class="flex items-center p-4 bg-gray-50 rounded-xl text-gray-700 hover:bg-gray-100 transition-all duration-300 hover:shadow-md group">
                                    <div class="p-3 rounded-lg bg-gray-100 text-gray-500 mr-3 group-hover:bg-gray-500 group-hover:text-white transition-colors duration-300">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <span class="font-medium">System Settings</span>
                                </a>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                    <i class="fas fa-history text-blue-500 mr-2"></i>
                                    Recent Activity
                                </h3>
                                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-300 flex items-center">
                                    View All
                                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                </a>
                            </div>
                            <div class="space-y-4">
                                @if (isset($recentActivities) && count($recentActivities) > 0)
                                    @foreach ($recentActivities as $activity)
                                        <div class="flex items-start p-4 rounded-xl border border-gray-100 hover:bg-gray-50 transition-colors duration-300">
                                            <div class="flex-shrink-0 mr-4">
                                                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-500 flex items-center justify-center shadow-sm">
                                                    <i class="fas fa-{{ $activity->icon ?? 'bell' }} text-lg"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow">
                                                <p class="text-sm font-semibold text-gray-800">
                                                    {{ $activity->title ?? 'Activity' }}</p>
                                                <p class="text-sm text-gray-600 mt-1">{{ $activity->description ?? '' }}</p>
                                                <p class="text-xs text-gray-400 mt-2 flex items-center">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ $activity->created_at ? $activity->created_at->diffForHumans() : 'Recently' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-xl">
                                        <i class="fas fa-inbox text-3xl mb-3 opacity-50"></i>
                                        <p class="font-medium">No recent activity</p>
                                        <p class="text-sm mt-1">All your activities will appear here</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- System Status -->
                        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-server text-green-500 mr-2"></i>
                                System Status
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-sm font-medium text-gray-700 flex items-center">
                                        <i class="fas fa-circle text-xs mr-2 text-green-500"></i>
                                        Server Status
                                    </span>
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                        Operational
                                    </span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-sm font-medium text-gray-700 flex items-center">
                                        <i class="fab fa-laravel text-xs mr-2 text-red-500"></i>
                                        Laravel Version
                                    </span>
                                    <span class="text-sm font-medium text-gray-700">{{ app()->version() }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-sm font-medium text-gray-700 flex items-center">
                                        <i class="fab fa-php text-xs mr-2 text-purple-500"></i>
                                        PHP Version
                                    </span>
                                    <span class="text-sm font-medium text-gray-700">{{ phpversion() }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-sm font-medium text-gray-700 flex items-center">
                                        <i class="fas fa-globe text-xs mr-2 text-blue-500"></i>
                                        Environment
                                    </span>
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                                        {{ app()->environment('production') ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-yellow-100 text-yellow-800 border border-yellow-200' }}">
                                        {{ app()->environment() }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Latest Registrations -->
                        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                    <i class="fas fa-user-plus text-amber-500 mr-2"></i>
                                    Latest Registrations
                                </h3>
                                <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-300 flex items-center">
                                    View All
                                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                </a>
                            </div>
                            <div class="overflow-hidden">
                                @if (isset($latestUsers) && count($latestUsers) > 0)
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        User</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Type</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Joined</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($latestUsers as $user)
                                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                        <td class="px-4 py-3">
                                                            <div class="flex items-center">
                                                                <div class="flex-shrink-0 h-10 w-10">
                                                                    <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-200"
                                                                        src="{{ $user->profile_photo_url ?? asset('images/default-profile.jpg') }}"
                                                                        alt="{{ $user->name }}">
                                                                </div>
                                                                <div class="ml-3">
                                                                    <p class="text-sm font-medium text-gray-900">
                                                                        {{ $user->name }}</p>
                                                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                                                            {{ $user->role === 'artisan'
                                                                ? 'bg-amber-100 text-amber-800 border border-amber-200'
                                                                : ($user->role === 'admin'
                                                                    ? 'bg-red-100 text-red-800 border border-red-200'
                                                                    : 'bg-green-100 text-green-800 border border-green-200') }}">
                                                                {{ ucfirst($user->role ?? 'Client') }}
                                                            </span>
                                                        </td>
                                                        <td class="px-4 py-3 text-sm text-gray-500">
                                                            <div class="flex items-center">
                                                                <i class="far fa-clock mr-1 text-gray-400"></i>
                                                                {{ $user->created_at ? $user->created_at->diffForHumans() : 'Recently' }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-xl">
                                        <i class="fas fa-users text-3xl mb-3 opacity-50"></i>
                                        <p class="font-medium">No recent registrations</p>
                                        <p class="text-sm mt-1">New users will appear here</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
