@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Last updated:</span>
                    <span class="text-sm font-medium text-gray-700">{{ now()->format('M d, Y H:i') }}</span>
                    <button class="p-1.5 rounded-full text-gray-500 hover:text-primary-600 hover:bg-gray-100">
                        <i class="fas fa-sync-alt text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-md">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-lg bg-blue-100 text-blue-600">
                                <i class="fas fa-users text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Total Users</h3>
                                <div class="flex items-baseline">
                                    <p class="text-2xl font-bold text-gray-900">{{ $totalUsers ?? 0 }}</p>
                                    <span class="ml-2 text-xs font-medium text-green-600 flex items-center">
                                        <i class="fas fa-arrow-up mr-1"></i>12%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-1"></div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-md">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-lg bg-amber-100 text-amber-600">
                                <i class="fas fa-hammer text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Artisans</h3>
                                <div class="flex items-baseline">
                                    <p class="text-2xl font-bold text-gray-900">{{ $artisansCount ?? 0 }}</p>
                                    <span class="ml-2 text-xs font-medium text-green-600 flex items-center">
                                        <i class="fas fa-arrow-up mr-1"></i>8%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-amber-500 to-amber-600 h-1"></div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-md">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-lg bg-green-100 text-green-600">
                                <i class="fas fa-user-tie text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Clients</h3>
                                <div class="flex items-baseline">
                                    <p class="text-2xl font-bold text-gray-900">{{ $clientsCount ?? 0 }}</p>
                                    <span class="ml-2 text-xs font-medium text-green-600 flex items-center">
                                        <i class="fas fa-arrow-up mr-1"></i>15%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-1"></div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-md">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-lg bg-purple-100 text-purple-600">
                                <i class="fas fa-calendar-check text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Bookings</h3>
                                <div class="flex items-baseline">
                                    <p class="text-2xl font-bold text-gray-900">{{ $bookingsCount ?? 0 }}</p>
                                    <span class="ml-2 text-xs font-medium text-green-600 flex items-center">
                                        <i class="fas fa-arrow-up mr-1"></i>24%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-1"></div>
                </div>
            </div>

            <!-- Additional Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-5 mb-8">
                <div class="bg-white rounded-lg p-4 border border-gray-100 shadow-sm flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600 mr-3">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500">Services</p>
                        <p class="text-lg font-bold text-gray-900">{{ $servicesCount ?? 0 }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 border border-gray-100 shadow-sm flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-teal-100 flex items-center justify-center text-teal-600 mr-3">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500">Categories</p>
                        <p class="text-lg font-bold text-gray-900">{{ $categoriesCount ?? 0 }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 border border-gray-100 shadow-sm flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-pink-100 flex items-center justify-center text-pink-600 mr-3">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500">Reviews</p>
                        <p class="text-lg font-bold text-gray-900">{{ $reviewsCount ?? 0 }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 border border-gray-100 shadow-sm flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 mr-3">
                        <i class="fas fa-comment"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500">Messages</p>
                        <p class="text-lg font-bold text-gray-900">{{ $messagesCount ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Admin Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin.users.index') }}" class="group flex flex-col items-center p-4 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-blue-50 hover:border-blue-200 transition-all duration-200">
                                <div class="w-12 h-12 mb-3 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-200 transition-colors duration-200">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">Manage Users</span>
                            </a>

                            <a href="{{ route('admin.artisans.index') }}" class="group flex flex-col items-center p-4 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-amber-50 hover:border-amber-200 transition-all duration-200">
                                <div class="w-12 h-12 mb-3 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-200 transition-colors duration-200">
                                    <i class="fas fa-hammer"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-amber-700">Manage Artisans</span>
                            </a>

                            <a href="{{ route('admin.services.index') }}" class="group flex flex-col items-center p-4 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-orange-50 hover:border-orange-200 transition-all duration-200">
                                <div class="w-12 h-12 mb-3 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center group-hover:bg-orange-200 transition-colors duration-200">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-orange-700">Manage Services</span>
                            </a>

                            <a href="{{ route('admin.categories.index') }}" class="group flex flex-col items-center p-4 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-teal-50 hover:border-teal-200 transition-all duration-200">
                                <div class="w-12 h-12 mb-3 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center group-hover:bg-teal-200 transition-colors duration-200">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-teal-700">Manage Categories</span>
                            </a>

                            <a href="{{ route('admin.bookings.index') }}" class="group flex flex-col items-center p-4 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-purple-50 hover:border-purple-200 transition-all duration-200">
                                <div class="w-12 h-12 mb-3 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center group-hover:bg-purple-200 transition-colors duration-200">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700">Manage Bookings</span>
                            </a>

                            <a href="{{ route('admin.settings.index') }}" class="group flex flex-col items-center p-4 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                                <div class="w-12 h-12 mb-3 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center group-hover:bg-gray-200 transition-colors duration-200">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">System Settings</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                        <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-700 flex items-center">
                            View All
                            <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @if (isset($recentActivities) && count($recentActivities) > 0)
                                @foreach ($recentActivities as $activity)
                                    <div class="flex items-start p-3 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                                        <div class="flex-shrink-0 mr-3">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                                                {{ $activity->type === 'user' ? 'bg-blue-100 text-blue-600' :
                                                   ($activity->type === 'booking' ? 'bg-purple-100 text-purple-600' :
                                                   ($activity->type === 'service' ? 'bg-orange-100 text-orange-600' :
                                                   'bg-gray-100 text-gray-600')) }}">
                                                <i class="fas fa-{{ $activity->icon ?? 'bell' }}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow">
                                            <p class="text-sm font-medium text-gray-900">{{ $activity->title ?? 'Activity' }}</p>
                                            <p class="text-xs text-gray-600">{{ $activity->description ?? '' }}</p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $activity->created_at ? $activity->created_at->diffForHumans() : 'Recently' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-3">
                                        <i class="fas fa-inbox text-gray-400 text-xl"></i>
                                    </div>
                                    <p class="text-sm">No recent activity</p>
                                    <p class="text-xs text-gray-400 mt-1">New activities will appear here</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- System Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">System Status</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-3">
                                        <i class="fas fa-server text-sm"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Server Status</span>
                                </div>
                                <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Operational
                                </span>
                            </div>

                            <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 mr-3">
                                        <i class="fab fa-laravel text-sm"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Laravel Version</span>
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ app()->version() }}</span>
                            </div>

                            <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-3">
                                        <i class="fab fa-php text-sm"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">PHP Version</span>
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ phpversion() }}</span>
                            </div>

                            <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                                        <i class="fas fa-globe text-sm"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Environment</span>
                                </div>
                                <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full
                                    {{ app()->environment('production') ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ app()->environment() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latest Registrations -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Latest Registrations</h3>
                        <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 flex items-center">
                            View All
                            <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                    <div class="p-6">
                        @if (isset($latestUsers) && count($latestUsers) > 0)
                            <div class="overflow-hidden rounded-lg border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                User
                                            </th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Type
                                            </th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Joined
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($latestUsers as $user)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-9 w-9">
                                                            <img class="h-9 w-9 rounded-full object-cover border border-gray-200"
                                                                src="{{ $user->profile_photo_url ?? asset('images/default-profile.jpg') }}"
                                                                alt="{{ $user->name }}">
                                                        </div>
                                                        <div class="ml-3">
                                                            <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full
                                                        {{ $user->role === 'artisan' ? 'bg-amber-100 text-amber-800' :
                                                           ($user->role === 'admin' ? 'bg-red-100 text-red-800' :
                                                           'bg-green-100 text-green-800') }}">
                                                        {{ ucfirst($user->role ?? 'Client') }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $user->created_at ? $user->created_at->diffForHumans() : 'Recently' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-3">
                                    <i class="fas fa-users text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-sm">No recent registrations</p>
                                <p class="text-xs text-gray-400 mt-1">New users will appear here</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
