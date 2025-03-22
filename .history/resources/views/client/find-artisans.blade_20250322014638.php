@extends('layouts.client')

@section('title', 'Find Artisans')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Find Available Artisans</h1>

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

                    <!-- Search and Filter Section -->
                    <div class="mb-8 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <form action="{{ route('client.find-artisans') }}" method="GET" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <!-- Search input -->
                                <div>
                                    <label for="search"
                                        class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                                        placeholder="Search by name, profession, skills..."
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                </div>

                                <!-- Category filter -->
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                        class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <select name="category" id="category"ray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $cat) }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                            <option value="{{ $cat->id }}"
                                                {{ request('category') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>ocation filter -->
                                <div>
                                <!-- Location filter -->"
                                <div>   class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <label for="location"me="location" id="location" value="{{ request('location') }}"
                                        class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <input type="text" name="location" id="location" value="{{ request('location') }}"s:ring focus:ring-amber-200 focus:ring-opacity-50">
                                        placeholder="City, country..."
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                </div>vailability filter (New) -->
                                <div>
                                <!-- Sort options -->
                                <div>   class="block text-sm font-medium text-gray-700 mb-1">Availability</label>
                                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sorty" id="availability"
                                        By</label> focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                    <select name="sort" id="sort"ity') == 'all' ? 'selected' : '' }}>All
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest
                                            First</option>ability') == 'available' ? 'selected' : '' }}>Available Now
                                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest
                                            First</option>
                                        <option value="rating_high"quest('availability') == 'unavailable' ? 'selected' : '' }}>Not Available
                                            {{ request('sort') == 'rating_high' ? 'selected' : '' }}>Highest Rated</option>
                                        <option value="rating_low" {{ request('sort') == 'rating_low' ? 'selected' : '' }}>
                                            Lowest Rated</option>
                                    </select>
                                </div>ort options -->
                            </div>                                <div>
 class="block text-sm font-medium text-gray-700 mb-1">Sort
                            <div class="flex justify-end">   By</label>
                                @if (request()->anyFilled(['search', 'category', 'location', 'sort']))
                                    <a href="{{ route('client.find-artisans') }}"ull rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                        class="mr-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md text-gray-700 text-sm font-medium"> request('sort') == 'newest' ? 'selected' : '' }}>Newest
                                        Clear Filters
                                    </a>
                                @endif
                                <button type="submit"
                                    class="px-4 py-2 bg-amber-600 hover:bg-amber-700 rounded-md text-white text-sm font-medium">rt') == 'rating_high' ? 'selected' : '' }}>Highest Rated</option>
                                    Apply Filters{{ request('sort') == 'rating_low' ? 'selected' : '' }}>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Results counter -->lass="flex justify-end">
                    <div class="mb-4 text-gray-600">                                @if (request()->anyFilled(['search', 'category', 'location', 'sort', 'availability']))
                        @if (isset($artisans) && method_exists($artisans, 'total'))ent.find-artisans') }}"
                            @if ($artisans->total() > 0)ext-sm font-medium">
                                Showing {{ $artisans->firstItem() }} to {{ $artisans->lastItem() }} of
                                {{ $artisans->total() }} artisans
                            @else
                                0 artisans foundtype="submit"
                            @endifass="px-4 py-2 bg-amber-600 hover:bg-amber-700 rounded-md text-white text-sm font-medium">
                        @else
                            0 artisans found
                        @endif
                    </div>

                    <!-- Artisans Listing -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">esults counter -->
                        @if (isset($artisans) && $artisans->count() > 0)                    <div class="mb-4 text-gray-600">
                            @foreach ($artisans as $artisan)) && method_exists($artisans, 'total'))
                                <div> 0)
                                    class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow border border-gray-200">s->lastItem() }} of
                                    <div class="relative"> artisans
                                        <!-- Cover image or color -->
                                        <div class="h-20 bg-gradient-to-r from-amber-500 to-amber-600"></div>
f
                                        <!-- Profile image -->
                                        <div class="absolute left-4 bottom-0 transform translate-y-1/2">sans found
                                            <divf
                                                class="w-16 h-16 rounded-full overflow-hidden border-2 border-white bg-white">
                                                @if (isset($artisan->profile_photo))
                                                    <img src="{{ asset('storage/' . $artisan->profile_photo) }}"rtisans Listing -->
                                                        alt="{{ isset($artisan->user) ? $artisan->user->firstname . ' ' . $artisan->user->lastname : 'Artisan' }}"                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                                        class="w-full h-full object-cover"> && $artisans->count() > 0)
                                                @else
                                                    <div
                                                        class="w-full h-full bg-amber-200 flex items-center justify-center text-amber-600 text-xl font-bold">lg overflow-hidden shadow-md hover:shadow-lg transition-shadow border border-gray-200">
                                                        {{ isset($artisan->user) ? strtoupper(substr($artisan->user->firstname ?? '', 0, 1) . substr($artisan->user->lastname ?? '', 0, 1)) : 'A' }}<div class="relative">
                                                    </div>
                                                @endifg-gradient-to-r from-amber-500 to-amber-600"></div>
                                            </div>
                                        </div>
                                                                                @if (isset($artisan->is_available))
                                        <!-- Categories display -->2">
                                        <div class="absolute right-2 top-2">)
                                            @if ($artisan->categories && $artisan->categories->count() > 0)
                                                @foreach ($artisan->categories->take(1) as $category)tems-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <span class="inline-block bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full">span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
                                                        {{ $category->name }}
                                                    </span>
                                                @endforeach
                                                @if ($artisan->categories->count() > 1)
                                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">   class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        +{{ $artisan->categories->count() - 1 }}span class="w-2 h-2 mr-1 bg-gray-500 rounded-full"></span>
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                    <div class="p-4 pt-10">rofile image -->
                                        <div class="flex items-center justify-between">                                        <div class="absolute left-4 bottom-0 transform translate-y-1/2">
                                            <div>
                                                <h3 class="font-medium text-lg">{{ $artisan->user->firstname ?? '' }}order-white bg-white">
                                                    {{ $artisan->user->lastname ?? 'Unknown Artisan' }}</h3>@if (isset($artisan->profile_photo))
                                                <p class="text-sm text-gray-600">{{ $artisan->profession ?? 'Artisan' }}
                                                </p>) ? $artisan->user->firstname . ' ' . $artisan->user->lastname : 'Artisan' }}"
                                            </div>
                                            <div class="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full">
                                                {{ $artisan->category->name ?? 'Uncategorized' }}
                                            </div>   class="w-full h-full bg-amber-200 flex items-center justify-center text-amber-600 text-xl font-bold">
                                        </div>{{ isset($artisan->user) ? strtoupper(substr($artisan->user->firstname ?? '', 0, 1) . substr($artisan->user->lastname ?? '', 0, 1)) : 'A' }}

                                        <div class="mt-3">
                                            <div class="flex text-amber-500 mb-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($artisan->rating ?? 0))
                                                        <i class="fas fa-star"></i>
                                                    @elseif($i - 0.5 <= ($artisan->rating ?? 0))lass="p-4 pt-10">
                                                        <i class="fas fa-star-half-alt"></i>                                        <div class="flex items-center justify-between">
                                                    @else
                                                        <i class="far fa-star"></i>isan->user->firstname ?? '' }}
                                                    @endif   {{ $artisan->user->lastname ?? 'Unknown Artisan' }}</h3>
                                                @endfor }}
                                                <span class="ml-2 text-gray-600 text-sm">
                                                    {{ number_format($artisan->rating ?? 0, 1) }}
                                                    ({{ $artisan->reviews_count ?? 0 }})ss="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full">
                                                </span> $artisan->category->name ?? 'Uncategorized' }}
                                            </div>

                                            @if ($artisan->hourly_rate)
                                                <div class="text-sm text-gray-600 mb-2">lass="mt-3">
                                                    <span class="font-semibold">€{{ $artisan->hourly_rate }}</span> per                                            <div class="flex text-amber-500 mb-1">
                                                    hour 1; $i <= 5; $i++)
                                                </div>ing ?? 0))
                                            @endifr"></i>
 0))
                                            <div class="flex items-center text-sm text-gray-600 mb-2">alt"></i>
                                                <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                                {{ $artisan->city ?? 'Location not specified' }}{{ $artisan->country ? ', ' . $artisan->country : '' }}
                                            </div>f

                                            @if (isset($artisan->skills) && is_array($artisan->skills) && count($artisan->skills) > 0)s="ml-2 text-gray-600 text-sm">
                                                <div class="flex flex-wrap gap-1 mb-3">number_format($artisan->rating ?? 0, 1) }}
                                                    @foreach (array_slice($artisan->skills, 0, 3) as $skill)
                                                        <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">
                                                            {{ $skill }}
                                                        </span>
                                                    @endforeachartisan->hourly_rate)
                                                    @if (count($artisan->skills) > 3)                                                <div class="text-sm text-gray-600 mb-2">
                                                        <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">emibold">€{{ $artisan->hourly_rate }}</span> per
                                                            +{{ count($artisan->skills) - 3 }} more
                                                        </span>
                                                    @endif
                                                </div>
                                            @endiflass="flex items-center text-sm text-gray-600 mb-2">
                                                <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                            <p class="text-sm text-gray-600 line-clamp-2 mb-4">tisan->country ? ', ' . $artisan->country : '' }}
                                                {{ $artisan->about_me ?? 'No description available.' }}
                                            </p>
                                        </div>sset($artisan->skills) && is_array($artisan->skills) && count($artisan->skills) > 0)
                                                <div class="flex flex-wrap gap-1 mb-3">
                                        <div class="mt-4 flex justify-end">
                                            <a href="{{ route('client.artisans.show', $artisan->id) }}"0 text-gray-800 px-2 py-1 rounded">
                                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm font-medium">
                                                View Profile
                                            </a>
                                        </div>$artisan->skills) > 3)
                                    </div>lass="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">
                                </div>s) - 3 }} more
                            @endforeach
                        @else
                            <div class="col-span-3 text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"ss="text-sm text-gray-600 line-clamp-2 mb-4">
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />                                                {{ $artisan->about_me ?? 'No description available.' }}
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-gray-900">No artisans found</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    @if (request()->anyFilled(['search', 'category', 'location', 'availability']))lass="mt-4 flex justify-end">
                                        No artisans match your search criteria. Try adjusting your filters.                                            <a href="{{ route('client.artisans.show', $artisan->id) }}"
                                    @else00 text-white rounded-md hover:bg-green-700 transition-colors text-sm font-medium">
                                        There are currently no artisans registered in the system.
                                    @endif
                                </p>
                                @if (request()->anyFilled(['search', 'category', 'location', 'availability']))
                                    <div class="mt-6">
                                        <a href="{{ route('client.find-artisans') }}"
                                            class="text-amber-600 hover:text-amber-500">
                                            Clear all filters"col-span-3 text-center py-12">
                                        </a>   <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    </div>"true">
                                @endif
                            </div>h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        @endif
                    </div>
ss="mt-1 text-sm text-gray-500">
                    <!-- Pagination -->ility']))
                    @if (isset($artisans) && method_exists($artisans, 'lastPage') && $artisans->lastPage() > 1)criteria. Try adjusting your filters.
                        <div class="mt-8 flex justify-center">
                            {{ $artisans->links() }}
                        </div>f
                    @endif
                </div>st()->anyFilled(['search', 'category', 'location', 'availability']))
            </div><div class="mt-6">
        </div>
    </div>t-amber-600 hover:text-amber-500">
@endsection
