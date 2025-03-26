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
    </style>
@endsection

@section('content')
    <!-- Enhanced Hero Section with Gradient Background -->
    <div class="bg-gradient-to-r from-green-50 to-blue-50">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Find Your Perfect Artisan</h1>
            <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                Connect with skilled craftspeople who bring Moroccan tradition and expertise to your projects
            </p>
        </div>
    </div>

    <!-- Modern Filter Section -->
    <div class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form action="{{ route('client.artisans.index') }}" method="GET">
                <div class="space-y-4">
                    <div class="flex flex-col md:flex-row md:items-end md:space-x-4">
                        <div class="flex-1">
                            <label for="search" class="block text-sm font-medium text-gray-700">Find artisans</label>
                            <div class="mt-1 relative rounded-md shadow-sm group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-400 group-hover:text-green-500 transition-colors duration-200"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    class="block w-full pl-10 py-2.5 border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 shadow-sm hover:shadow"
                                    placeholder="Search by name, skill, or expertise">
                            </div>
                        </div>

                        <div class="mt-4 md:mt-0">
                            <button type="submit"
                                class="w-full md:w-auto px-5 py-2.5 bg-gradient-to-r from-green-600 to-green-500 text-white font-medium rounded-md hover:from-green-700 hover:to-green-600 shadow-sm flex items-center justify-center transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Search</span>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-5">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <div class="relative">
                                <select id="category" name="category"
                                    class="appearance-none mt-1 block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm transition-all duration-200 hover:shadow">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <div class="relative">
                                <select id="country" name="country"
                                    class="appearance-none mt-1 block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm transition-all duration-200 hover:shadow">
                                    <option value="">All Countries</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ request('country') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <div class="relative">
                                <select id="city" name="city"
                                    class="appearance-none mt-1 block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm transition-all duration-200 hover:shadow">
                                    <option value="">All Cities</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ request('city') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Minimum
                                Rating</label>
                            <div class="relative">
                                <select id="rating" name="rating"
                                    class="appearance-none mt-1 block w-full pl-3 pr-10 py-2.5 text-base border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm transition-all duration-200 hover:shadow">
                                    <option value="">Any Rating</option>
                                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4+ Stars
                                    </option>
                                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3+ Stars
                                    </option>
                                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2+ Stars
                                    </option>
                                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1+ Stars
                                    </option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
                            <select id="sort" name="sort"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                                <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured
                                </option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated
                                </option>
                                <option value="reviews" {{ request('sort') == 'reviews' ? 'selected' : '' }}>Most Reviewed
                                </option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-2">
                        <div class="flex space-x-2 items-center">
                            @if (request('search') ||
                                    request('category') ||
                                    request('country') ||
                                    request('city') ||
                                    request('rating') ||
                                    request('sort'))
                                <a href="{{ route('client.artisans.index') }}"
                                    class="text-sm text-gray-600 hover:text-gray-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Clear Filters
                                </a>
                            @endif
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500">View:</span>
                            <button type="button" id="grid-view-btn"
                                class="view-toggle-btn active p-1 rounded-md hover:bg-gray-100" title="Grid View">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                            </button>
                            <button type="button" id="list-view-btn"
                                class="view-toggle-btn p-1 rounded-md hover:bg-gray-100" title="List View">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section with Grid/List Toggle -->
    <div class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if ($artisans->count() > 0)
                <div class="mb-4 flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        Found {{ $artisans->count() }} artisans matching your criteria
                    </div>
                </div>

                <!-- Grid View -->
                <div id="grid-view" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($artisans as $artisan)
                        <div
                            class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-md transition duration-300">
                            <a href="{{ route('client.artisans.show', $artisan->id) }}" class="block">
                                <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                                    @if ($artisan->profile_photo)
                                        <img src="{{ asset('storage/' . $artisan->profile_photo) }}"
                                            alt="{{ $artisan->user->firstname }}" class="object-cover w-full h-48">
                                    @else
                                        <div
                                            class="w-full h-48 bg-gradient-to-r from-green-400 to-blue-500 flex justify-center items-center">
                                            <span
                                                class="text-4xl font-bold text-white">{{ substr($artisan->user->firstname, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-5">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $artisan->user->firstname }}
                                            {{ $artisan->user->lastname }}</h3>
                                        @if ($artisan->is_featured)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="mr-1 h-2 w-2 text-green-500" fill="currentColor"
                                                    viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Featured
                                            </span>
                                        @endif
                                    </div>

                                    <p class="text-sm text-gray-500 mb-3">{{ $artisan->profession ?? 'Artisan' }}</p>

                                    <div class="flex items-center mb-3">
                                        <div class="flex items-center">
                                            @if ($artisan->reviews->count() > 0)
                                                <span
                                                    class="text-sm font-medium text-gray-900">{{ number_format($artisan->reviews->avg('rating') ?? 0, 1) }}</span>
                                                <div class="ml-1 flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= round($artisan->reviews->avg('rating') ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <span
                                                    class="ml-1 text-sm text-gray-500">({{ $artisan->reviews->count() }})</span>
                                            @else
                                                <span class="text-sm text-gray-500">No reviews yet</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $artisan->city ?? 'Morocco' }}
                                    </div>

                                    @if ($artisan->years_experience)
                                        <div class="flex items-center text-sm text-gray-500 mb-4">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                                    clip-rule="evenodd" />
                                                <path
                                                    d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                            </svg>
                                            {{ $artisan->years_experience }}
                                            {{ $artisan->years_experience == 1 ? 'year' : 'years' }} experience
                                        </div>
                                    @endif

                                    @if ($artisan->services->count() > 0)
                                        <div class="flex flex-wrap gap-1 mt-3">
                                            @foreach ($artisan->services->take(2) as $service)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ Str::limit($service->name, 15) }}
                                                </span>
                                            @endforeach
                                            @if ($artisan->services->count() > 2)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    +{{ $artisan->services->count() - 2 }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="px-5 py-3 bg-gray-50 border-t border-gray-200">
                                    <div class="text-sm font-medium text-green-600 hover:text-green-700 flex items-center">
                                        View Profile
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- List View -->
                <div id="list-view" class="hidden">
                    <div class="bg-white shadow rounded-md overflow-hidden">
                        <ul class="divide-y divide-gray-200">
                            @foreach ($artisans as $artisan)
                                <li class="hover:bg-gray-50">
                                    <a href="{{ route('client.artisans.show', $artisan->id) }}" class="block">
                                        <div class="px-4 py-4 sm:px-6">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-full overflow-hidden border border-gray-200">
                                                    @if ($artisan->profile_photo)
                                                        <img src="{{ asset('storage/' . $artisan->profile_photo) }}"
                                                            alt="{{ $artisan->user->firstname }}"
                                                            class="h-full w-full object-cover">
                                                    @else
                                                        <div
                                                            class="h-full w-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center">
                                                            <span
                                                                class="text-lg font-bold text-white">{{ substr($artisan->user->firstname, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="ml-4 flex-1">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <h3
                                                                class="text-base font-medium text-gray-900 flex items-center">
                                                                {{ $artisan->user->firstname }}
                                                                {{ $artisan->user->lastname }}
                                                                @if ($artisan->is_featured)
                                                                    <span
                                                                        class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                        <svg class="mr-0.5 h-2 w-2 text-green-500"
                                                                            fill="currentColor" viewBox="0 0 8 8">
                                                                            <circle cx="4" cy="4" r="3" />
                                                                        </svg>
                                                                        Featured
                                                                    </span>
                                                                @endif
                                                            </h3>
                                                            <p class="text-sm text-gray-500">
                                                                {{ $artisan->profession ?? 'Artisan' }}</p>
                                                        </div>
                                                        <div class="flex items-center">
                                                            @if ($artisan->reviews->count() > 0)
                                                                <div class="flex items-center">
                                                                    <span
                                                                        class="text-sm font-medium text-gray-900">{{ number_format($artisan->reviews->avg('rating') ?? 0, 1) }}</span>
                                                                    <div class="flex items-center ml-1">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <svg class="w-4 h-4 {{ $i <= round($artisan->reviews->avg('rating') ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 20 20" fill="currentColor">
                                                                                <path
                                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                            </svg>
                                                                        @endfor
                                                                    </div>
                                                                    <span
                                                                        class="text-sm text-gray-500 ml-1">({{ $artisan->reviews->count() }})</span>
                                                                </div>
                                                            @else
                                                                <span class="text-sm text-gray-500">No reviews yet</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mt-2 sm:flex sm:justify-between">
                                                        <div class="sm:flex">
                                                            <p class="flex items-center text-sm text-gray-500">
                                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                    fill="currentColor">
                                                                    <path fill-rule="evenodd"
                                                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                {{ $artisan->city ?? 'Morocco' }}
                                                            </p>
                                                            @if ($artisan->years_experience)
                                                                <p
                                                                    class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd"
                                                                            d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                                                            clip-rule="evenodd" />
                                                                        <path
                                                                            d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                                                    </svg>
                                                                    {{ $artisan->years_experience }}
                                                                    {{ $artisan->years_experience == 1 ? 'year' : 'years' }}
                                                                    experience
                                                                </p>
                                                            @endif
                                                        </div>

                                                        <div class="mt-2 flex items-center text-sm sm:mt-0">
                                                            @if ($artisan->services->count() > 0)
                                                                <div class="flex flex-wrap gap-1">
                                                                    @foreach ($artisan->services->take(2) as $service)
                                                                        <span
                                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                            {{ Str::limit($service->name, 15) }}
                                                                        </span>
                                                                    @endforeach
                                                                    @if ($artisan->services->count() > 2)
                                                                        <span
                                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                                            +{{ $artisan->services->count() - 2 }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="ml-4">
                                                    <div class="text-green-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Pagination placeholder - would integrate with Laravel's pagination -->
                <div class="mt-8 flex justify-center">
                    <!-- Pagination links would go here -->
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-50 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900">No artisans found</h3>
                    <p class="mt-2 text-gray-500 max-w-md mx-auto">Try adjusting your search criteria or check back later
                        as new artisans join our platform.</p>
                    <div class="mt-6">
                        <a href="{{ route('client.artisans.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
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
        // Grid/List view toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
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


        });
    </script>
@endsection
