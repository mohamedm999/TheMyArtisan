@extends('layouts.admin')

@section('title', 'Manage Artisans')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Artisans</h2>
                        <!-- Temporarily commenting out export button until route is defined
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.artisans.export') }}"
                                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                    <i class="fas fa-file-export mr-1"></i> Export
                                </a>
                            </div>
                            -->
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <!-- Search and Filters -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <form method="GET" action="{{ route('admin.artisans.index') }}"
                            class="md:flex md:flex-wrap md:items-end">
                            <div class="flex-1 mb-2 md:mb-0 md:mr-4">
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" name="search" id="search" placeholder="Name, email or specialty"
                                    value="{{ request('search') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="mb-2 md:mb-0 md:mr-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                        Rejected</option>
                                </select>
                            </div>

                            <div class="mb-2 md:mb-0 md:mr-4">
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                <select name="country" id="country"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">All Countries</option>
                                    @foreach ($countries ?? [] as $country)
                                        <option value="{{ $country->id }}"
                                            {{ request('country') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2 md:mb-0 md:mr-4">
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="category" id="category"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">All Categories</option>
                                    @foreach ($categories ?? [] as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:self-end">
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    <i class="fas fa-search mr-1"></i> Filter Results
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
                            <p class="text-sm text-gray-500">Total Artisans</p>
                            <p class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-yellow-500">
                            <p class="text-sm text-gray-500">Pending Approval</p>
                            <p class="text-2xl font-bold">{{ $stats['pending'] ?? 0 }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
                            <p class="text-sm text-gray-500">Approved</p>
                            <p class="text-2xl font-bold">{{ $stats['approved'] ?? 0 }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-red-500">
                            <p class="text-sm text-gray-500">Rejected</p>
                            <p class="text-2xl font-bold">{{ $stats['rejected'] ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Artisans Table -->
                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Artisan
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
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($artisans as $artisan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden">
                                                    @if ($artisan->artisanProfile && $artisan->artisanProfile->profile_photo)
                                                        <img class="h-12 w-12 object-cover"
                                                            src="{{ Storage::url($artisan->artisanProfile->profile_photo) }}"
                                                            alt="{{ $artisan->firstname }}">
                                                    @else
                                                        <div
                                                            class="h-12 w-12 bg-blue-100 text-blue-800 flex items-center justify-center rounded-full">
                                                            {{ substr($artisan->firstname, 0, 1) }}{{ substr($artisan->lastname, 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $artisan->firstname }} {{ $artisan->lastname }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $artisan->email }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        Joined {{ $artisan->created_at->format('M d, Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 font-medium">
                                                {{ $artisan->artisanProfile ? ($artisan->artisanProfile->specialty ?? 'Not specified') : 'Not specified' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                @if ($artisan->artisanProfile && $artisan->artisanProfile->categories && $artisan->artisanProfile->categories->count() > 0)
                                                    @foreach ($artisan->artisanProfile->categories->take(3) as $category)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1 mb-1">
                                                            {{ $category->name }}
                                                        </span>
                                                    @endforeach
                                                    @if ($artisan->artisanProfile->categories->count() > 3)
                                                        <span class="text-xs text-gray-500">+{{ $artisan->artisanProfile->categories->count() - 3 }} more</span>
                                                    @endif
                                                @else
                                                    <span class="text-xs text-gray-500">No categories</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($artisan->artisanProfile)
                                                <div class="text-sm text-gray-900">
                                                    @if ($artisan->artisanProfile->city_id && $artisan->artisanProfile->city)
                                                        {{ $artisan->artisanProfile->city->name ?? 'City name unavailable' }},
                                                        {{ $artisan->artisanProfile->country ? $artisan->artisanProfile->country->name : 'Country unavailable' }}
                                                    @elseif($artisan->artisanProfile->city)
                                                        {{ is_object($artisan->artisanProfile->city) ? $artisan->artisanProfile->city->name : $artisan->artisanProfile->city }}
                                                    @else
                                                        {{ $artisan->artisanProfile->address ?? 'Location not specified' }}
                                                    @endif
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    Service radius: {{ $artisan->artisanProfile->service_radius ?? '0' }} km
                                                </div>
                                            @else
                                                <div class="text-sm text-gray-900">Not specified</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm">
                                                <span class="font-medium">
                                                    @if($artisan->artisanProfile && method_exists($artisan->artisanProfile, 'services'))
                                                        {{ $artisan->artisanProfile->services->count() }}
                                                    @else
                                                        0
                                                    @endif
                                                </span>
                                                Services
                                            </div>
                                            @if ($artisan->artisanProfile && method_exists($artisan->artisanProfile, 'getAverageRatingAttribute'))
                                                <div class="flex items-center">
                                                    <div class="flex text-yellow-400">
                                                        @php
                                                            $avgRating = $artisan->artisanProfile->getAverageRatingAttribute();
                                                        @endphp
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= round($avgRating))
                                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                                                </svg>
                                                            @else
                                                                <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 24 24">
                                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                                                </svg>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <span class="text-xs text-gray-500 ml-1">
                                                        @if(method_exists($artisan->artisanProfile, 'getTotalReviewsAttribute'))
                                                            ({{ $artisan->artisanProfile->getTotalReviewsAttribute() }})
                                                        @else
                                                            (0)
                                                        @endif
                                                    </span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($artisan->artisanProfile)
                                                @if ($artisan->artisanProfile->status === 'approved')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Approved
                                                    </span>
                                                @elseif($artisan->artisanProfile->status === 'rejected')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Rejected
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @endif
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    No Profile
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex flex-col space-y-2">
                                                <a href="{{ route('admin.artisans.show', $artisan->id) }}"
                                                    class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-eye mr-1"></i> View
                                                </a>

                                                @if ($artisan->artisanProfile && $artisan->artisanProfile->status === 'pending')
                                                    <form method="POST"
                                                        action="{{ route('admin.artisans.approve', $artisan->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="text-green-600 hover:text-green-900">
                                                            <i class="fas fa-check mr-1"></i> Approve
                                                        </button>
                                                    </form>

                                                    <form method="POST"
                                                        action="{{ route('admin.artisans.reject', $artisan->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            <i class="fas fa-times mr-1"></i> Reject
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('admin.artisans.services', $artisan->id) }}"
                                                    class="text-purple-600 hover:text-purple-900">
                                                    <i class="fas fa-concierge-bell mr-1"></i> Services
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No artisans found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $artisans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
