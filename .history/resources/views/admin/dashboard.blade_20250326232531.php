@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800">Admin Dashboard</h1>

                    <!-- Stats Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
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

                    <!-- Admin Actions -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <a href="{{ route('admin.settings.index') }}"
                                    class="flex items-center text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-cog mr-2"></i>
                                    <span>System Settings</span>
                                </a>
                                <a href="{{ route('admin.users.index') }}"
                                    class="flex items-center text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    <span>Manage Users</span>
                                </a>
                                <a href="{{ route('admin.backup') }}"
                                    class="flex items-center text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-database mr-2"></i>
                                    <span>Database Backup</span>
                                </a>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">System Status</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Server Status</span>
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Operational
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Laravel Version</span>
                                    <span class="text-sm text-gray-600">{{ app()->version() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
