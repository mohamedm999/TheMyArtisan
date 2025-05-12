@extends('layouts.client')

@section('title', 'All Available Artisans')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Browse All Artisans</h1>

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-6"
                            role="alert">
                            <span class="block sm:inline">{{ session('info') }}</span>
                        </div>
                    @endif

                    <!-- Filter Form -->
                    <div class="mb-8 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-medium text-gray-800 mb-4">Filter Artisans</h2>
                        <form method="GET" action="{{ route('client.artisans.index') }}" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                                        placeholder="Search artisans..."
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                                </div>

                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <select name="category" id="category"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                                        <option value="">All Categories</option>
                                        @if(isset($categories))
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <select name="location" id="location"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                                        <option value="">All Locations</option>
                                        @if(isset($locations))
                                            @foreach ($locations as $loc)
                                                <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>
                                                    {{ $loc }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div>
                                    <label for="sortBy" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                                    <select name="sortBy" id="sortBy"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                                        <option value="rating" {{ request('sortBy') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                                        <option value="newest" {{ request('sortBy') == 'newest' ? 'selected' : '' }}>Newest</option>
                                        <option value="name" {{ request('sortBy') == 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                @if (request()->anyFilled(['search', 'category', 'location', 'sortBy']))
                                    <a href="{{ route('client.artisans.index') }}"
                                        class="mr-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md text-gray-700 text-sm font-medium">
                                        Clear Filters
                                    </a>
                                @endif
                                <button type="submit"
                                    class="px-4 py-2 bg-amber-600 hover:bg-amber-700 rounded-md text-white text-sm font-medium">
                                    Apply Filters
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Results counter -->
                    <div class="mb-4 text-gray-600">
                        @if (isset($artisans) && method_exists($artisans, 'total'))
                            @if ($artisans->total() > 0)
                                Showing {{ $artisans->firstItem() }} to {{ $artisans->lastItem() }} of
                                {{ $artisans->total() }} artisans
                            @else
                                0 artisans found
                            @endif
                        @else
                            0 artisans found
                        @endif
                    </div>

                    <!-- Artisans Listing -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if (isset($artisans) && $artisans->count() > 0)
                            @foreach ($artisans as $artisan)
                                <div
                                    class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow border border-gray-200">
                                    <div class="relative">
                                        <!-- Cover image or color -->
                                        <div class="h-20 bg-gradient-to-r from-amber-500 to-amber-600"></div>

                                        <!-- Availability indicator -->
                                        @if (isset($artisan->is_available))
                                            <div class="absolute right-2 top-2">
                                                @if ($artisan->is_available)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
                                                        Available
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        <span class="w-2 h-2 mr-1 bg-gray-500 rounded-full"></span>
                                                        Unavailable
                                                    </span>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Profile image -->
                                        <div class="absolute left-4 bottom-0 transform translate-y-1/2">
                                            <div
                                                class="w-16 h-16 rounded-full overflow-hidden border-2 border-white bg-white">
                                                @if (isset($artisan->profile_photo))
                                                    <img src="{{ asset('storage/' . $artisan->profile_photo) }}"
                                                        alt="{{ isset($artisan->user) ? $artisan->user->firstname . ' ' . $artisan->user->lastname : 'Artisan' }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <div
                                                        class="w-full h-full bg-amber-200 flex items-center justify-center text-amber-600 text-xl font-bold">
                                                        {{ isset($artisan->user) ? strtoupper(substr($artisan->user->firstname ?? '', 0, 1) . substr($artisan->user->lastname ?? '', 0, 1)) : 'A' }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-4 pt-10">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h3 class="font-medium text-lg">{{ $artisan->user->firstname ?? '' }}
                                                    {{ $artisan->user->lastname ?? 'Unknown Artisan' }}</h3>
                                                <p class="text-sm text-gray-600">{{ $artisan->profession ?? 'Artisan' }}
                                                </p>
                                            </div>
                                            <div class="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full">
                                                {{ $artisan->category->name ?? 'Uncategorized' }}
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <div class="flex text-amber-500 mb-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($artisan->rating ?? 0))
                                                        <i class="fas fa-star"></i>
                                                    @elseif($i - 0.5 <= ($artisan->rating ?? 0))
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                                <span class="ml-2 text-gray-600 text-sm">
                                                    {{ number_format($artisan->rating ?? 0, 1) }}
                                                    ({{ $artisan->reviews_count ?? 0 }})
                                                </span>
                                            </div>

                                            @if ($artisan->hourly_rate)
                                                <div class="text-sm text-gray-600 mb-2">
                                                    <span class="font-semibold">€{{ $artisan->hourly_rate }}</span> per
                                                    hour
                                                </div>
                                            @endif

                                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                                <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                                {{ $artisan->city ?? 'Location not specified' }}{{ $artisan->country ? ', ' . $artisan->country : '' }}
                                            </div>

                                            @if (isset($artisan->skills) && is_array($artisan->skills) && count($artisan->skills) > 0)
                                                <div class="flex flex-wrap gap-1 mb-3">
                                                    @foreach (array_slice($artisan->skills, 0, 3) as $skill)
                                                        <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">
                                                            {{ $skill }}
                                                        </span>
                                                    @endforeach
                                                    @if (count($artisan->skills) > 3)
                                                        <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">
                                                            +{{ count($artisan->skills) - 3 }} more
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif

                                            <p class="text-sm text-gray-600 line-clamp-2 mb-4">
                                                {{ $artisan->about_me ?? 'No description available.' }}
                                            </p>
                                        </div>

                                        <div class="mt-4 flex justify-end">
                                            <a href="{{ route('client.artisans.show', $artisan->id) }}"
                                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm font-medium">
                                                View Profile
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-3 text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No artisans found</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Try adjusting your search or filter criteria to find available artisans.
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    @if (isset($artisans) && method_exists($artisans, 'links'))
                        <div class="mt-6">
                            {{ $artisans->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
