@extends('layouts.client')

@section('title', 'Browse Artisans - MyArtisan')
@section('description',
    'Find skilled Moroccan artisans for your craft needs. Browse profiles, reviews, and book
    services.')

@section('styles')
    <style>
        .view-toggle-btn.active {
            background-color: #f3f4f6;
            color: #111827;
        }
        .search-section-collapsed {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .search-section-expanded {
            max-height: 800px;
            overflow: hidden;
            transition: max-height 0.5s ease-in;
        }
        .search-toggle-rotate {
            transform: rotate(180deg);
            transition: transform 0.3s;
        }
        .filter-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            color: #4b5563;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .filter-badge button {
            margin-left: 0.25rem;
            color: #9ca3af;
        }
    </style>
@endsection

@section('content')
    <!-- Simplified Hero Section with Gradient Background -->
    <div class="bg-gradient-to-r from-green-700 to-green-800 text-white shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0 bg-repeat" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgdmlld0JveD0iMCAwIDYwIDYwIj48cGF0aCBkPSJNMzAgNS4xTDYwIDMwIDMwIDU0LjkgMCAzMHoiIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iLjMiLz48L3N2Zz4=')"></div>
        </div>
        <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-3xl font-extrabold text-white sm:text-4xl">
                Find Your Perfect Artisan
            </h1>
            <p class="mt-3 max-w-md mx-auto text-base text-white sm:text-lg">
                Connect with skilled craftspeople who bring Moroccan tradition and expertise to your projects
            </p>
            <div class="mt-5">
                <button id="toggle-search-btn"
                        class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-green-800 bg-white hover:bg-green-50 transition-all duration-200 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    Search Artisans
                    <svg id="search-caret" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Collapsible Modern Filter Section -->
    <div id="search-section" class="search-section-collapsed bg-white shadow-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form action="{{ route('client.artisans.index') }}" method="GET">
                <!-- Main Search Input -->
                <div class="relative rounded-md shadow-sm mb-4">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        class="block w-full pl-10 py-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 shadow-sm hover:shadow"
                        placeholder="Search by name, skill, or expertise">
                </div>

                <!-- Filter Pills -->
                <div id="active-filters" class="flex flex-wrap mb-4">
                    <!-- Dynamically generated filter pills go here -->
                </div>

                <!-- Collapsible Filters -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <div class="relative">
                            <select id="category" name="category"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                        <div class="relative">
                            <select id="country" name="country"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                                <option value="">All Countries</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" {{ request('country') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <div class="relative">
                            <select id="city" name="city"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                                <option value="">All Cities</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div>
                        <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Minimum Rating</label>
                        <div class="relative">
                            <select id="rating" name="rating"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                                <option value="">Any Rating</option>
                                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4+ Stars</option>
                                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3+ Stars</option>
                                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2+ Stars</option>
                                <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1+ Stars</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <div class="flex-1">
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select id="sort" name="sort" class="w-full sm:w-auto pl-3 pr-10 py-2 text-sm border-gray-300 focus:outline-none focus:ring-amber-500 focus:border-amber-500 rounded-lg shadow-sm">
                            <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="reviews" {{ request('sort') == 'reviews' ? 'selected' : '' }}>Most Reviewed</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        </select>
                    </div>

                    <div class="ml-3 flex items-center">
                        <button type="submit" class="px-4 py-2 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700 shadow-sm flex items-center justify-center transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                            Search
                        </button>
                        @if (request('search') || request('category') || request('country') || request('city') || request('rating') || request('sort'))
                            <a href="{{ route('client.artisans.index') }}" class="ml-2 px-3 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Applied Filters Bar -->
    <div id="applied-filters-bar" class="sticky top-0 z-20 bg-white border-b border-gray-200 shadow-sm {{ (!request('search') && !request('category') && !request('country') && !request('city') && !request('rating') && !request('sort')) ? 'hidden' : '' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-medium text-gray-700">Applied filters:</span>
                    <div class="flex flex-wrap items-center">
                        @if(request('search'))
                            <span class="filter-badge">
                                Keywords: {{ request('search') }}
                                <button type="button" onclick="removeFilter('search')" aria-label="Remove filter">×</button>
                            </span>
                        @endif

                        @if(request('category'))
                            <span class="filter-badge">
                                Category: {{ $categories->where('id', request('category'))->first()->name ?? '' }}
                                <button type="button" onclick="removeFilter('category')" aria-label="Remove filter">×</button>
                            </span>
                        @endif

                        @if(request('country'))
                            <span class="filter-badge">
                                Country: {{ $countries->where('id', request('country'))->first()->name ?? '' }}
                                <button type="button" onclick="removeFilter('country')" aria-label="Remove filter">×</button>
                            </span>
                        @endif

                        @if(request('city'))
                            <span class="filter-badge">
                                City: {{ $cities->where('id', request('city'))->first()->name ?? '' }}
                                <button type="button" onclick="removeFilter('city')" aria-label="Remove filter">×</button>
                            </span>
                        @endif

                        @if(request('rating'))
                            <span class="filter-badge">
                                Rating: {{ request('rating') }}+ stars
                                <button type="button" onclick="removeFilter('rating')" aria-label="Remove filter">×</button>
                            </span>
                        @endif

                        @if(request('sort') && request('sort') != 'featured')
                            <span class="filter-badge">
                                Sort: {{ ucfirst(request('sort')) }}
                                <button type="button" onclick="removeFilter('sort')" aria-label="Remove filter">×</button>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-2 mt-2 sm:mt-0">
                    <!-- View toggles -->
                    <div class="flex items-center space-x-1 bg-gray-100 p-1 rounded-md">
                        <button type="button" id="grid-view-btn"
                            class="view-toggle-btn active p-1.5 rounded-md hover:bg-gray-200 transition-colors duration-200"
                            title="Grid View">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </button>
                        <button type="button" id="list-view-btn"
                            class="view-toggle-btn p-1.5 rounded-md hover:bg-gray-200 transition-colors duration-200"
                            title="List View">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                    @if (request('search') || request('category') || request('country') || request('city') || request('rating') || request('sort'))
                        <a href="{{ route('client.artisans.index') }}"
                           class="text-xs text-gray-600 hover:text-gray-900 flex items-center px-2.5 py-1.5 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Clear All
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Results Section with Grid/List Toggle -->
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @if ($artisans->count() > 0)
                <div class="mb-5 flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900">
                        Found <span class="text-amber-600 font-semibold">{{ $artisans->total() }}</span> artisans
                    </h2>
                    <button id="mobile-filter-btn" class="md:hidden bg-white p-2 rounded-md shadow-sm border border-gray-200 text-gray-600 hover:text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- Grid View -->
                <div id="grid-view" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($artisans as $artisan)
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow transition duration-300 transform hover:-translate-y-1">
                            <a href="{{ route('client.artisans.show', $artisan->id) }}" class="block">
                                <div class="relative">
                                    <div class="aspect-w-16 aspect-h-10 bg-gray-100">
                                        @if ($artisan->profile_photo)
                                            <img src="{{ asset('storage/' . $artisan->profile_photo) }}" alt="{{ $artisan->user->firstname }}" class="object-cover w-full h-40">
                                        @else
                                            <div class="w-full h-40 bg-gradient-to-b from-amber-500 to-amber-700 flex justify-center items-center">
                                                <span class="text-3xl font-bold text-white">{{ substr($artisan->user->firstname, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    @if ($artisan->is_featured)
                                        <div class="absolute top-3 right-3">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                <svg class="mr-1 h-2 w-2 text-amber-500" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Featured
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4">
                                    <div class="flex items-center justify-between mb-1">
                                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-amber-600 transition-colors duration-200">
                                            {{ $artisan->user->firstname }} {{ $artisan->user->lastname }}
                                        </h3>
                                    </div>

                                    <p class="text-sm text-gray-500 mb-2">{{ $artisan->profession ?? 'Artisan' }}</p>

                                    <div class="flex items-center mb-3">
                                        <div class="flex items-center">
                                            @if ($artisan->reviews->count() > 0)
                                                <span class="text-sm font-medium text-gray-900">{{ number_format($artisan->reviews->avg('rating') ?? 0, 1) }}</span>
                                                <div class="ml-1 flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= round($artisan->reviews->avg('rating') ?? 0) ? 'text-amber-400' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <span class="ml-1 text-sm text-gray-500">({{ $artisan->reviews->count() }})</span>
                                            @else
                                                <span class="text-sm text-gray-500">No reviews yet</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center text-sm text-gray-500 mb-1">
                                        <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $artisan->city ?? 'Morocco' }}
                                    </div>

                                    @if ($artisan->years_experience)
                                        <div class="flex items-center text-sm text-gray-500 mb-3">
                                            <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                            </svg>
                                            {{ $artisan->years_experience }} {{ $artisan->years_experience == 1 ? 'year' : 'years' }} experience
                                        </div>
                                    @endif

                                    @if ($artisan->services->count() > 0)
                                        <div class="flex flex-wrap gap-1 mt-2">
                                            @foreach ($artisan->services->take(2) as $service)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                                    {{ Str::limit($service->name, 15) }}
                                                </span>
                                            @endforeach
                                            @if ($artisan->services->count() > 2)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-50 text-gray-600 border border-gray-100">
                                                    +{{ $artisan->services->count() - 2 }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </a>

                            <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                                <a href="{{ route('client.artisans.show', $artisan->id) }}" class="text-sm font-medium text-amber-600 hover:text-amber-700 flex items-center">
                                    View Profile
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <form action="{{ route('messages.start') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="artisan_id" value="{{ $artisan->id }}">
                                    <input type="hidden" name="message" value="Hello, I'm interested in your services. Are you available for a project?">
                                    <button type="submit" class="inline-flex items-center text-sm text-white bg-amber-600 px-3 py-1.5 rounded-md hover:bg-amber-700 transition-colors">
                                        <i class="fas fa-comment mr-1"></i> Contact
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- List View -->
                <div id="list-view" class="hidden">
                    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
                        <ul class="divide-y divide-gray-200">
                            @foreach ($artisans as $artisan)
                                <li class="hover:bg-gray-50 transition-colors duration-150">
                                    <a href="{{ route('client.artisans.show', $artisan->id) }}" class="block">
                                        <div class="px-4 py-4 sm:px-6">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-full overflow-hidden border border-gray-200">
                                                    @if ($artisan->profile_photo)
                                                        <img src="{{ asset('storage/' . $artisan->profile_photo) }}" alt="{{ $artisan->user->firstname }}" class="h-full w-full object-cover">
                                                    @else
                                                        <div class="h-full w-full bg-gradient-to-b from-amber-500 to-amber-700 flex items-center justify-center">
                                                            <span class="text-md font-bold text-white">{{ substr($artisan->user->firstname, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="ml-4 flex-1">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <h3 class="text-sm font-medium text-gray-900 flex items-center">
                                                                {{ $artisan->user->firstname }} {{ $artisan->user->lastname }}
                                                                @if ($artisan->is_featured)
                                                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                                        <svg class="mr-0.5 h-2 w-2 text-amber-500" fill="currentColor" viewBox="0 0 8 8">
                                                                            <circle cx="4" cy="4" r="3" />
                                                                        </svg>
                                                                        Featured
                                                                    </span>
                                                                @endif
                                                            </h3>
                                                            <p class="text-xs text-gray-500">{{ $artisan->profession ?? 'Artisan' }}</p>
                                                        </div>
                                                        <div class="flex items-center">
                                                            @if ($artisan->reviews->count() > 0)
                                                                <div class="flex items-center">
                                                                    <span class="text-xs font-medium text-gray-900">{{ number_format($artisan->reviews->avg('rating') ?? 0, 1) }}</span>
                                                                    <div class="flex items-center ml-1">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <svg class="w-3 h-3 {{ $i <= round($artisan->reviews->avg('rating') ?? 0) ? 'text-amber-400' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                            </svg>
                                                                        @endfor
                                                                    </div>
                                                                    <span class="text-xs text-gray-500 ml-1">({{ $artisan->reviews->count() }})</span>
                                                                </div>
                                                            @else
                                                                <span class="text-xs text-gray-500">No reviews yet</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mt-2 sm:flex sm:justify-between">
                                                        <div class="sm:flex items-center text-xs">
                                                            <p class="flex items-center text-gray-500">
                                                                <svg class="flex-shrink-0 mr-1 h-3.5 w-3.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                                </svg>
                                                                {{ $artisan->city ?? 'Morocco' }}
                                                            </p>
                                                            @if ($artisan->years_experience)
                                                                <p class="mt-2 flex items-center text-gray-500 sm:mt-0 sm:ml-6">
                                                                    <svg class="flex-shrink-0 mr-1 h-3.5 w-3.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                                                        <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                                                    </svg>
                                                                    {{ $artisan->years_experience }} {{ $artisan->years_experience == 1 ? 'year' : 'years' }} experience
                                                                </p>
                                                            @endif
                                                        </div>

                                                        <div class="mt-2 flex items-center text-sm sm:mt-0">
                                                            @if ($artisan->services->count() > 0)
                                                                <div class="flex flex-wrap gap-1">
                                                                    @foreach ($artisan->services->take(2) as $service)
                                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                                                            {{ Str::limit($service->name, 15) }}
                                                                        </span>
                                                                    @endforeach
                                                                    @if ($artisan->services->count() > 2)
                                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-50 text-gray-600 border border-gray-100">
                                                                            +{{ $artisan->services->count() - 2 }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <form action="{{ route('messages.start') }}" method="POST" class="ml-4">
                                                    @csrf
                                                    <input type="hidden" name="artisan_id" value="{{ $artisan->id }}">
                                                    <input type="hidden" name="message" value="Hello, I'm interested in your services. Are you available for a project?">
                                                    <button type="submit" class="inline-flex items-center text-xs text-white bg-amber-600 px-3 py-1.5 rounded-md hover:bg-amber-700 transition-colors">
                                                        <i class="fas fa-comment mr-1"></i> Contact
                                                    </button>
                                                </form>

                                                <div class="ml-3 text-amber-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    {{ $artisans->links() }}
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-amber-50 mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">No artisans found</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Try adjusting your search criteria or check back later as new artisans join our platform.</p>
                    <div class="mt-6">
                        <a href="{{ route('client.artisans.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                            Clear All Filters
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle search section
            const searchSection = document.getElementById('search-section');
            const toggleSearchBtn = document.getElementById('toggle-search-btn');
            const searchCaret = document.getElementById('search-caret');
            const mobileFilterBtn = document.getElementById('mobile-filter-btn');

            function toggleSearchSection() {
                if (searchSection.classList.contains('search-section-collapsed')) {
                    searchSection.classList.remove('search-section-collapsed');
                    searchSection.classList.add('search-section-expanded');
                    searchCaret.classList.add('search-toggle-rotate');
                } else {
                    searchSection.classList.remove('search-section-expanded');
                    searchSection.classList.add('search-section-collapsed');
                    searchCaret.classList.remove('search-toggle-rotate');
                }
            }

            toggleSearchBtn.addEventListener('click', toggleSearchSection);
            if (mobileFilterBtn) {
                mobileFilterBtn.addEventListener('click', toggleSearchSection);
            }

            // Grid/List view toggle functionality
            const gridViewBtn = document.getElementById('grid-view-btn');
            const listViewBtn = document.getElementById('list-view-btn');
            const gridView = document.getElementById('grid-view');
            const listView = document.getElementById('list-view');

            gridViewBtn.addEventListener('click', function() {
                gridView.classList.remove('hidden');
                listView.classList.add('hidden');
                gridViewBtn.classList.add('active');
                listViewBtn.classList.remove('active');
                localStorage.setItem('preferredView', 'grid');
            });

            listViewBtn.addEventListener('click', function() {
                gridView.classList.add('hidden');
                listView.classList.remove('hidden');
                listViewBtn.classList.add('active');
                gridViewBtn.classList.remove('active');
                localStorage.setItem('preferredView', 'list');
            });

            // Check for saved preference
            const preferredView = localStorage.getItem('preferredView');
            if (preferredView === 'list') {
                listViewBtn.click();
            }

            // If any filters are applied, expand the search section
            const hasFilters = {{ (request('search') || request('category') || request('country') || request('city') || request('rating') || request('sort')) ? 'true' : 'false' }};
            if (hasFilters) {
                // Expand the search section if filters are active but only on initial load
                toggleSearchSection();
            }

            // Function to update filter pills
            updateFilterPills();
        });

        // Function to remove a specific filter
        function removeFilter(filterName) {
            // Get current URL and create a URL object
            const url = new URL(window.location.href);
            // Remove the specified parameter
            url.searchParams.delete(filterName);
            // Redirect to the new URL
            window.location.href = url.toString();
        }

        // Function to update filter pills display
        function updateFilterPills() {
            const activeFilters = document.getElementById('active-filters');
            if (!activeFilters) return;

            // Clear existing pills
            activeFilters.innerHTML = '';

            // Get URL parameters
            const urlParams = new URLSearchParams(window.location.search);

            // Add pills for each parameter
            for (const [key, value] of urlParams.entries()) {
                if (value && key !== 'page') { // Skip empty values and page parameter
                    const pill = document.createElement('span');
                    pill.className = 'filter-badge';

                    // Format the pill label
                    let label = key.charAt(0).toUpperCase() + key.slice(1) + ': ' + value;

                    // Special case for rating
                    if (key === 'rating') {
                        label = `Rating: ${value}+ stars`;
                    }

                    pill.innerHTML = `
                        ${label}
                        <button type="button" onclick="removeFilter('${key}')" aria-label="Remove filter">×</button>
                    `;

                    activeFilters.appendChild(pill);
                }
            }
        }
    </script>
@endsection
