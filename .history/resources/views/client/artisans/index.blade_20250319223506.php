@extends('layouts.cl')

@section('title', 'Browse Artisans - MyArtisan')
@section('description', 'Find skilled Moroccan artisans for your craft needs. Browse profiles, reviews, and book
    services.')

@section('content')
    <!-- Hero Section -->
    <div class="bg-amber-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-bold text-amber-800 mb-4">Find Skilled Artisans</h1>
            <p class="text-lg text-gray-700 max-w-3xl">
                Discover authentic Moroccan craftsmanship from our network of talented artisans.
                Filter by craft category, location, or search for specific skills.
            </p>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="bg-white py-6 px-4 sm:px-6 lg:px-8 border-b">
        <div class="max-w-7xl mx-auto">
            <form action="{{ route('client.artisans.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="sr-only">Search artisans</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search"
                            class="focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                            placeholder="Search by name or skill">
                    </div>
                </div>
                <div class="w-full md:w-48">
                    <label for="category" class="sr-only">Category</label>
                    <select id="category" name="category"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm rounded-md">
                        <option value="">All Categories</option>
                        <option value="pottery">Pottery</option>
                        <option value="zellige">Zellige</option>
                        <option value="leather">Leather Craft</option>
                        <option value="carpets">Carpets & Textiles</option>
                        <option value="woodwork">Woodwork</option>
                    </select>
                </div>
                <div class="w-full md:w-48">
                    <label for="location" class="sr-only">Location</label>
                    <select id="location" name="location"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm rounded-md">
                        <option value="">All Locations</option>
                        <option value="marrakech">Marrakech</option>
                        <option value="fez">Fez</option>
                        <option value="casablanca">Casablanca</option>
                        <option value="rabat">Rabat</option>
                        <option value="essaouira">Essaouira</option>
                    </select>
                </div>
                <div>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        Filter Results
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    <div class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            @if ($artisans->count() > 0)
                <div class="mb-6 text-gray-600">
                    Showing {{ $artisans->count() }} artisans
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($artisans as $artisan)
                        <a href="{{ route('client.artisans.show', $artisan->id) }}"
                            class="block bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden border border-gray-100">
                            <div class="bg-gray-200 h-48 overflow-hidden relative">
                                @if ($artisan->profile_image)
                                    <img src="{{ asset('storage/' . $artisan->profile_image) }}"
                                        alt="{{ $artisan->user->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full bg-amber-100">
                                        <i class="fas fa-user-circle text-6xl text-amber-300"></i>
                                    </div>
                                @endif

                                @if ($artisan->is_featured)
                                    <div
                                        class="absolute top-2 right-2 bg-amber-500 text-white px-2 py-1 rounded-md text-xs font-semibold">
                                        Featured
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $artisan->user->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $artisan->profession ?? 'Artisan' }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-amber-500"><i class="fas fa-star mr-1"></i></span>
                                        <span
                                            class="font-medium">{{ number_format($artisan->reviews->avg('rating') ?? 0, 1) }}</span>
                                        <span class="text-xs text-gray-500 ml-1">({{ $artisan->reviews->count() }})</span>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-wrap gap-1">
                                    @foreach ($artisan->services->take(3) as $service)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                                            {{ $service->title }}
                                        </span>
                                    @endforeach
                                    @if ($artisan->services->count() > 3)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            +{{ $artisan->services->count() - 3 }} more
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                    <div class="text-sm text-gray-500">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $artisan->city ?? 'Morocco' }}
                                    </div>
                                    <span class="text-amber-600 text-sm font-medium hover:text-amber-800">View
                                        Profile</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-8 rounded-lg shadow-sm text-center">
                    <i class="fas fa-search text-4xl text-gray-300 mb-3"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No artisans found</h3>
                    <p class="text-gray-600 mb-4">Try adjusting your search filters or check back later.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
