@extends('layouts.client')

@section('title', 'Browse Artisans - MyArtisan')
@section('description', 'Find skilled Moroccan artisans for your craft needs. Browse profiles, reviews, and book
    services.')

@section('styles')
    <style>
        .pattern-bg {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2316a34a' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .artisan-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .artisan-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .tag-badge {
            transition: all 0.2s ease;
        }

        .tag-badge:hover {
            transform: scale(1.05);
        }

        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.2);
        }
    </style>
@endsection

@section('content')
    <!-- Advanced Search & Filter Section -->
    <div class="bg-white py-6 px-4 sm:px-6 lg:px-8 border-b border-gray-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto">
            <form action="{{ route('client.artisans.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <div class="md:col-span-4">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" id="search"
                                class="search-input focus:ring-green-500 focus:border-green-500 block w-full pl-10 pr-3 py-2 border-gray-300 rounded-md"
                                placeholder="Name, skill or keyword">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select id="category" name="category"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 rounded-md">
                            <option value="">All Categories</option>
                            <option value="pottery">Pottery</option>
                            <option value="zellige">Zellige</option>
                            <option value="leather">Leather Craft</option>
                            <option value="carpets">Carpets & Textiles</option>
                            <option value="woodwork">Woodwork</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <select id="location" name="location"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 rounded-md">
                            <option value="">All Locations</option>
                            <option value="marrakech">Marrakech</option>
                            <option value="fez">Fez</option>
                            <option value="casablanca">Casablanca</option>
                            <option value="rabat">Rabat</option>
                            <option value="essaouira">Essaouira</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select id="sort" name="sort"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 rounded-md">
                            <option value="featured">Featured</option>
                            <option value="rating">Highest Rated</option>
                            <option value="reviews">Most Reviews</option>
                            <option value="newest">Newest</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 flex justify-end">
                        <button type="submit"
                            class="w-full md:w-auto flex items-center justify-center px-6 py-2 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                            <i class="fas fa-filter mr-2"></i> Filter Results
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    <div class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            @if ($artisans->count() > 0)
                <div class="flex justify-between items-center mb-8">
                    <div class="text-gray-600 font-medium">
                        Showing <span class="text-green-600">{{ $artisans->count() }}</span> artisans
                    </div>
                    <div class="flex space-x-2">
                        <button class="bg-white p-2 rounded-md border border-gray-200 text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="bg-white p-2 rounded-md border border-gray-200 text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($artisans as $artisan)
                        <div class="artisan-card bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                            <div class="relative">
                                <!-- Artisan image -->
                                <div class="bg-gray-200 h-48 overflow-hidden">
                                    @if ($artisan->profile_photo)
                                        <img src="{{ asset('storage/' . $artisan->profile_photo) }}"
                                            alt="{{ $artisan->user->firstname }}" class="w-full h-full object-cover">
                                    @else
                                        <div
                                            class="flex items-center justify-center h-full bg-gradient-to-r from-green-100 to-green-200">
                                            <i class="fas fa-user-circle text-6xl text-green-300"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Featured badge -->
                                @if ($artisan->is_featured)
                                    <div
                                        class="absolute top-3 right-3 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">
                                        <i class="fas fa-trophy mr-1"></i> Featured
                                    </div>
                                @endif

                                <!-- Rating badge -->
                                <div
                                    class="absolute -bottom-4 right-4 bg-white rounded-full shadow-md px-3 py-1 flex items-center">
                                    <span class="text-green-500 mr-1"><i class="fas fa-star"></i></span>
                                    <span
                                        class="font-bold text-gray-700">{{ number_format($artisan->reviews->avg('rating') ?? 0, 1) }}</span>
                                    <span class="text-xs text-gray-500 ml-1">({{ $artisan->reviews->count() }})</span>
                                </div>
                            </div>

                            <div class="p-5">
                                <div class="mb-4">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $artisan->user->firstname }}
                                        {{ $artisan->user->lastname }}</h3>
                                    <p class="text-sm text-gray-600">{{ $artisan->profession ?? 'Artisan' }}</p>
                                </div>

                                @if ($artisan->services->count() > 0)
                                    <div class="mb-4">
                                        <h4 class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-2">
                                            Specialties</h4>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($artisan->services->take(3) as $service)
                                                <span
                                                    class="tag-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $service->title }}
                                                </span>
                                            @endforeach
                                            @if ($artisan->services->count() > 3)
                                                <span
                                                    class="tag-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    +{{ $artisan->services->count() - 3 }} more
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <i class="fas fa-map-marker-alt mr-1 text-green-500"></i>
                                    {{ $artisan->city ?? 'Morocco' }}

                                    @if ($artisan->years_experience)
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-briefcase mr-1 text-green-500"></i>
                                        {{ $artisan->years_experience }}
                                        {{ $artisan->years_experience == 1 ? 'year' : 'years' }} experience
                                    @endif
                                </div>

                                <a href="{{ route('client.artisans.show', $artisan->id) }}"
                                    class="mt-2 inline-flex w-full items-center justify-center px-4 py-2 border border-green-600 rounded-md shadow-sm text-sm font-medium text-green-600 bg-white hover:bg-green-50 transition-colors">
                                    View Profile
                                    <i class="fas fa-arrow-right ml-1.5"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination would go here if you have it -->
            @else
                <div class="bg-white rounded-xl shadow-md p-10 text-center max-w-xl mx-auto">
                    <div class="rounded-full bg-green-100 w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-3xl text-green-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No artisans found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your search criteria or check back later as our artisan
                        community is growing every day.</p>
                    <a href="{{ route('client.artisans.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Clear filters
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Initialize any JavaScript needed for interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Animation for cards when they enter viewport
            if ('IntersectionObserver' in window) {
                const cards = document.querySelectorAll('.artisan-card');

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = 1;
                            entry.target.style.transform = 'translateY(0)';
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1
                });

                cards.forEach(card => {
                    card.style.opacity = 0;
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                    observer.observe(card);
                });
            }
        });
    </script>
@endsection
