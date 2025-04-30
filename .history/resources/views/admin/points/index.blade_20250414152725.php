@extends('layouts.admin')

@section('title', 'Client Points')
@section('description', 'Manage client reward points')

@section('content')
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Client Points Management</h1>
                    <p class="mt-1 text-sm text-gray-500">View and manage client reward points</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.points.analytics') }}"
                        class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg shadow-sm text-sm font-medium transition-all focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <i class="fas fa-chart-line mr-2"></i>Point Analytics
                    </a>
                </div>
            </div>
        </div>

        <div class="p-4">
            @if(session('success'))
                <div class="bg-green-50 text-green-800 rounded-lg p-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 text-red-800 rounded-lg p-4 mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search Form -->
            <div class="mb-6">
                <form method="GET" action="{{ route('admin.points.index') }}">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Search by name or email"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" />
                        </div>
                        <button type="submit"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg shadow-sm text-sm font-medium transition-all focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Current Points
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Lifetime Points
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($clients as $client)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700">
                                            <span class="font-medium">{{ substr($client->firstname, 0, 1) }}{{ substr($client->lastname, 0, 1) }}</span>
                                        </div>
                                        <span class="ml-3">{{ $client->firstname }} {{ $client->lastname }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $client->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-primary-100 text-primary-800">
                                        {{ $client->points ? $client->points->points_balance : 0 }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    {{ $client->points ? $client->points->lifetime_points : 0 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.points.show', $client->id) }}" 
                                        class="text-primary-600 hover:text-primary-900 bg-primary-50 hover:bg-primary-100 px-3 py-1 rounded-md transition-all">
                                        <i class="fas fa-coins mr-1"></i>Manage Points
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No clients found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
@endsection