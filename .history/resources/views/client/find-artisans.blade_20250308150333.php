@extends('layouts.client')

@section('title', 'Find Artisans')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Find Artisans</h1>

                    <!-- Search and Filter Section -->
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" id="search" placeholder="Search artisans..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Craft
                                    Category</label>
                                <select id="category"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    <option value="">All Categories</option>
                                    <option value="pottery">Pottery & Ceramics</option>
                                    <option value="textiles">Textiles & Carpet</option>
                                    <option value="woodwork">Woodwork</option>
                                    <option value="leather">Leather</option>
                                    <option value="metal">Metalwork</option>
                                </select>
                            </div>
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <select id="location"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    <option value="">All Locations</option>
                                    <option value="marrakech">Marrakech</option>
                                    <option value="fes">Fes</option>
                                    <option value="casablanca">Casablanca</option>
                                    <option value="rabat">Rabat</option>
                                    <option value="tangier">Tangier</option>
                                </select>
                            </div>
                            <div>
                                <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Minimum
                                    Rating</label>
                                <select id="rating"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    <option value="">Any Rating</option>
                                    <option value="5">5 Stars</option>
                                    <option value="4">4+ Stars</option>
                                    <option value="3">3+ Stars</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="button"
                                class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Search Artisans
                            </button>
                        </div>
                    </div>

                    <!-- Artisans Listing -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Sample Artisan Card 1 -->
                        <div
                            class="bg-white rounded-lg overflow-hidden shadow border border-gray-200 hover:shadow-lg transition-shadow">
                            <div class="p-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-12 h-12 rounded-full bg-amber-200 flex items-center justify-center text-amber-600 text-xl font-bold mr-4">
                                        AM</div>
                                    <div>
                                        <h3 class="font-medium">Ahmed Mansouri</h3>
                                        <p class="text-sm text-gray-500">Ceramic Artist</p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="flex text-amber-500 mb-1">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span class="ml-2 text-gray-600 text-sm">4.5 (28 reviews)</span>
                                    </div>
                                    <div class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i> Marrakech
                                    </div>
                                    <p class="mt-3 text-sm text-gray-600 line-clamp-2">Specializing in traditional Moroccan
                                        pottery with modern influences. Creating functional and decorative ceramic pieces.
                                    </p>
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                    <button class="text-sm text-amber-600 hover:text-amber-800 flex items-center">
                                        <i class="far fa-heart mr-1"></i> Save
                                    </button>
                                    <a href="#"
                                        class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">View
                                        Profile</a>
                                </div>
                            </div>
                        </div>

                        <!-- Sample Artisan Card 2 -->
                        <div
                            class="bg-white rounded-lg overflow-hidden shadow border border-gray-200 hover:shadow-lg transition-shadow">
                            <div class="p-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-12 h-12 rounded-full bg-amber-200 flex items-center justify-center text-amber-600 text-xl font-bold mr-4">
                                        FB</div>
                                    <div>
                                        <h3 class="font-medium">Fatima Benali</h3>
                                        <p class="text-sm text-gray-500">Textile Artisan</p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="flex text-amber-500 mb-1">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <span class="ml-2 text-gray-600 text-sm">5.0 (42 reviews)</span>
                                    </div>
                                    <div class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i> Fes
                                    </div>
                                    <p class="mt-3 text-sm text-gray-600 line-clamp-2">Expert in traditional Moroccan carpet
                                        weaving with over 20 years of experience. Specializes in authentic Berber designs.
                                    </p>
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                    <button class="text-sm text-amber-600 hover:text-amber-800 flex items-center">
                                        <i class="far fa-heart mr-1"></i> Save
                                    </button>
                                    <a href="#"
                                        class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">View
                                        Profile</a>
                                </div>
                            </div>
                        </div>

                        <!-- Sample Artisan Card 3 -->
                        <div
                            class="bg-white rounded-lg overflow-hidden shadow border border-gray-200 hover:shadow-lg transition-shadow">
                            <div class="p-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-12 h-12 rounded-full bg-amber-200 flex items-center justify-center text-amber-600 text-xl font-bold mr-4">
                                        YE</div>
                                    <div>
                                        <h3 class="font-medium">Youssef El Fassi</h3>
                                        <p class="text-sm text-gray-500">Metalworker</p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="flex text-amber-500 mb-1">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <span class="ml-2 text-gray-600 text-sm">4.0 (15 reviews)</span>
                                    </div>
                                    <div class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i> Casablanca
                                    </div>
                                    <p class="mt-3 text-sm text-gray-600 line-clamp-2">Skilled in traditional Moroccan
                                        metalwork, creating intricate lanterns, decorative items, and architectural
                                        elements.</p>
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                    <button class="text-sm text-amber-600 hover:text-amber-800 flex items-center">
                                        <i class="far fa-heart mr-1"></i> Save
                                    </button>
                                    <a href="#"
                                        class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">View
                                        Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex justify-center">
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-green-50 text-sm font-medium text-green-600 hover:bg-green-100">2</a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">3</a>
                            <span
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">8</a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">9</a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">10</a>
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
