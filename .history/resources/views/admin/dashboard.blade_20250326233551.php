@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800">Admin Dashboard</h1>

                    <!-- Stats Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 mt-6">
                        <div class="bg-blue-50 p-4 rounded-lg shadow">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-500 text-white mr-4">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-600">Total Users</p>
                                    <p class="text-2xl font-semibold">{{ $totalUsers ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-amber-50 p-4 rounded-lg shadow">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-amber-500 text-white mr-4">
                                    <i class="fas fa-hammer"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-amber-600">Artisans</p>
                                    <p class="text-2xl font-semibold">{{ $artisansCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg shadow">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-500 text-white mr-4">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-green-600">Clients</p>
                                    <p class="text-2xl font-semibold">{{ $clientsCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg shadow">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-500 text-white mr-4">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-purple-600">Bookings</p>
                                    <p class="text-2xl font-semibold">{{ $bookingsCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-orange-50 p-4 rounded-lg shadow">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-orange-500 text-white mr-4">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-orange-600">Services</p>
                                    <p class="text-2xl font-semibold">{{ $servicesCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-teal-50 p-4 rounded-lg shadow">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-teal-500 text-white mr-4">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-teal-600">Categories</p>
                                    <p class="text-2xl font-semibold">{{ $categoriesCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-pink-50 p-4 rounded-lg shadow">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-pink-500 text-white mr-4">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-pink-600">Reviews</p>
                                    <p class="text-2xl font-semibold">{{ $reviewsCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-indigo-50 p-4 rounded-lg shadow">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-indigo-500 text-white mr-4">
                                    <i class="fas fa-comment"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-indigo-600">Messages</p>
                                    <p class="text-2xl font-semibold">{{ $messagesCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <!-- Admin Actions -->
                        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Quick Actions</h3>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('admin.users.index') }}"
                                    class="flex items-center p-3 bg-blue-50 rounded-lg text-blue-700 hover:bg-blue-100 transition duration-150">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    <span>Manage Users</span>
                                </a>
                                <a href="{{ route('admin.artisans.index') }}"
                                    class="flex items-center p-3 bg-amber-50 rounded-lg text-amber-700 hover:bg-amber-100 transition duration-150">
                                    <i class="fas fa-hammer mr-2"></i>
                                    <span>Manage Artisans</span>
                                </a>
                                <a href="{{ route('admin.services.index') }}"
                                    class="flex items-center p-3 bg-orange-50 rounded-lg text-orange-700 hover:bg-orange-100 transition duration-150">
                                    <i class="fas fa-briefcase mr-2"></i>
                                    <span>Manage Services</span>
                                </a>
                                <a href="{{ route('admin.categories.index') }}"
                                    class="flex items-center p-3 bg-teal-50 rounded-lg text-teal-700 hover:bg-teal-100 transition duration-150">
                                    <i class="fas fa-tags mr-2"></i>
                                    <span>Manage Categories</span>
                                </a>
                                <a href="{{ route('admin.bookings.index') }}"
                                    class="flex items-center p-3 bg-purple-50 rounded-lg text-purple-700 hover:bg-purple-100 transition duration-150">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    <span>Manage Bookings</span>
                                </a>
                                <a href="{{ route('admin.settings.index') }}"
                                    class="flex items-center p-3 bg-gray-50 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-150">
                                    <i class="fas fa-cog mr-2"></i>
                                    <span>System Settings</span>
                                </a>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-800">Recent Activity</h3>
                                <a href="#" class="text-sm text-blue-600 hover:underline">View All</a>
                            </div>
                            <div class="space-y-4">
                                @if(isset($recentActivities) && count($recentActivities) > 0)
                                    @foreach($recentActivities as $activity)
                                        <div class="flex items-start p-3 rounded-lg border border-gray-100 hover:bg-gray-50">
                                            <div class="flex-shrink-0 mr-3">
                                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center">
                                                    <i class="fas fa-{{ $activity->icon ?? 'bell' }}"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow">
                                                <p class="text-sm font-medium text-gray-800">{{ $activity->title ?? 'Activity' }}</p>
                                                <p class="text-xs text-gray-500">{{ $activity->description ?? '' }}</p>
                                                <p class="text-xs text-gray-400 mt-1">{{ $activity->created_at ? $activity->created_at->diffForHumans() : 'Recently' }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-4 text-gray-500">
                                        <i class="fas fa-inbox text-2xl mb-2"></i>
                                        <p>No recent activity</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- System Status -->
                        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">System Status</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Server Status</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Operational
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Laravel Version</span>
                                    <span class="text-sm text-gray-600">{{ app()->version() }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">PHP Version</span>
                                    <span class="text-sm text-gray-600">{{ phpversion() }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Environment</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ app()->environment('production') ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ app()->environment() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Latest Registrations -->
                        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-800">Latest Registrations</h3>
                                <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:underline">View All</a>
                            </div>
                            <div class="overflow-hidden">
                                @if(isset($latestUsers) && count($latestUsers) > 0)
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($latestUsers as $user)
                                                <tr>
                                                    <td class="px-3 py-2">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-8 w-8">
                                                                <img class="h-8 w-8 rounded-full object-cover" src="{{ $user->profile_photo_url ?? asset('images/default-profile.jpg') }}" alt="{{ $user->name }}">
                                                            </div>
                                                            <div class="ml-3">
                                                                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-3 py-2">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $user->role === 'artisan' ? 'bg-amber-100 text-amber-800' : 
                                                          ($user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800') }}">
                                                            {{ ucfirst($user->role ?? 'Client') }}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-2 text-sm text-gray-500">
                                                        {{ $user->created_at ? $user->created_at->diffForHumans() : 'Recently' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center py-4 text-gray-500">
                                        <p>No recent registrations</p>
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
