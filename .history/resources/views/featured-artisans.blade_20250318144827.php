@extends('layouts.app')

@section('title', 'Featured Artisans - MyArtisan')
@section('description', 'Discover our featured Moroccan artisans, masters of traditional crafts including zellige tilework, carpet weaving, leather crafting, and metalwork.')

@section('content')
    <div class="bg-amber-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Hero section -->
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl font-bold text-amber-800 mb-6">Featured Artisans</h1>
            <p class="text-lg text-gray-700 max-w-3xl mx-auto">
                Meet our extraordinary craftspeople preserving Morocco's cultural heritage through exceptional skill and dedication.
            </p>
        </div>
    </div>

    <!-- Featured Artisans -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <!-- Artisan of the Month -->
            <div class="mb-20">
                <div class="flex items-center justify-center mb-12">
                    <span class="h-px bg-amber-300 w-12 mr-4"></span>
                    <h2 class="text-2xl font-bold text-amber-800">Artisan of the Month</h2>
                    <span class="h-px bg-amber-300 w-12 ml-4"></span>
                </div>

                <div class="bg-amber-50 rounded-xl overflow-hidden shadow-lg">
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <div class="h-96 lg:h-auto">
                            <img src="{{ asset('images/featured-artisans/artisan-month.jpg') }}" alt="Mohammed Ziani - Master Zellige Craftsman" class="w-full h-full object-cover">
                        </div>
                        <div class="p-8 lg:p-12 flex flex-col justify-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 mb-4">
                                Zellige Tilework
                            </span>
                            <h3 class="text-3xl font-bold text-gray-900 mb-4">Mohammed Ziani</h3>
                            <div class="flex items-center mb-4">
                                <div class="flex text-amber-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="ml-2 text-sm text-gray-600">5.0 (47 reviews)</span>
                            </div>
                            <p class="text-gray-600 mb-6">
                                A third-generation master of zellige tilework from Fez, Mohammed has perfected the geometric patterns that adorn Morocco's most beautiful buildings. His commitment to traditional techniques while embracing contemporary designs has earned him international recognition.
                            </p>
                            <div class="space-y-2 mb-8">
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-amber-500 w-5"></i>
                                    <span class="ml-2">Fez, Morocco</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-award text-amber-500 w-5"></i>
                                    <span class="ml-2">Master Craftsman (30+ years experience)</span>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('client.artisans.index') }}" class="inline-flex items-center px-6 py-3 bg-amber-600 border border-transparent rounded-md shadow-sm text-base font-medium text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                    View Profile
                                </a>
                                <a href="#" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-md shadow-sm bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 ml-4">
                                    Book Service
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Artisans Grid -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">More Outstanding Artisans</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Featured Artisan 1 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 transition-all duration-300 hover:shadow-lg hover:border-amber-200">
                        <div class="aspect-w-16 aspect-h-12">
                            <img src="{{ asset('images/featured-artisans/artisan-1.jpg') }}" alt="Fatima Zahra - Carpet Weaver" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-bold text-xl text-gray-900">Fatima Zahra</h3>
                                    <p class="text-amber-600">Carpet Weaving</p>
                                </div>
                                <span class="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full uppercase font-semibold tracking-wide">Featured</span>
                            </div>

                            <p class="text-gray-600 mb-4 line-clamp-3">
                                Creating intricate Berber-style carpets using ancient techniques passed down through generations, Fatima's work features natural dyes and traditional motifs.
                            </p>

                            <div class="flex items-center mb-4">
                                <div class="flex text-amber-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="ml-2 text-sm text-gray-600">4.8 (32 reviews)</span>
                            </div>

                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <i class="fas fa-map-marker-alt mr-2 text-amber-500"></i>
                                <span>Atlas Mountains</span>
                            </div>

                            <a href="{{ route('client.artisans.index') }}" class="block w-full text-center px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700 transition-colors">
                                View Profile
                            </a>
                        </div>
                    </div>

                    <!-- Featured Artisan 2 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 transition-all duration-300 hover:shadow-lg hover:border-amber-200">
                        <div class="aspect-w-16 aspect-h-12">
                            <img src="{{ asset('images/featured-artisans/artisan-2.jpg') }}" alt="Omar Belhaj - Leather Craftsman" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-bold text-xl text-gray-900">Omar Belhaj</h3>
                                    <p class="text-amber-600">Leather Crafting</p>
                                </div>
                                <span class="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full uppercase font-semibold tracking-wide">Featured</span>
                            </div>

                            <p class="text-gray-600 mb-4 line-clamp-3">
                                A master of traditional Moroccan leather crafting from Fez, Omar creates exquisite bags, poufs, and accessories using time-honored tanning and dyeing methods.
                            </p>

                            <div class="flex items-center mb-4">
                                <div class="flex text-amber-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="ml-2 text-sm text-gray-600">4.9 (41 reviews)</span>
                            </div>

                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <i class="fas fa-map-marker-alt mr-2 text-amber-500"></i>
                                <span>Fez</span>
                            </div>

                            <a href="{{ route('client.artisans.index') }}" class="block w-full text-center px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700 transition-colors">
                                View Profile
                            </a>
                        </div>
                    </div>

                    <!-- Featured Artisan 3 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 transition-all duration-300 hover:shadow-lg hover:border-amber-200">
                        <div class="aspect-w-16 aspect-h-12">
                            <img src="{{ asset('images/featured-artisans/artisan-3.jpg') }}" alt="Karim Idrissi - Metalwork" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-bold text-xl text-gray-900">Karim Idrissi</h3>
                                    <p class="text-amber-600">Metalwork</p>
                                </div>
                                <span class="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full uppercase font-semibold tracking-wide">Featured</span>
                            </div>

                            <p class="text-gray-600 mb-4 line-clamp-3">
                                Specializing in ornate brass and copper pieces, Karim combines traditional Moroccan designs with contemporary functionality to create stunning lamps and decorative items.
                            </p>

                            <div class="flex items-center mb-4">
                                <div class="flex text-amber-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="ml-2 text-sm text-gray-600">5.0 (28 reviews)</span>
                            </div>

                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <i class="fas fa-map-marker-alt mr-2 text-amber-500"></i>
                                <span>Marrakech</span>
                            </div>

                            <a href="{{ route('client.artisans.index') }}" class="block w-full text-center px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700 transition-colors">
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('client.artisans.index') }}" class="inline-flex items-center px-6 py-3 border border-amber-600 rounded-md text-amber-600 bg-white hover:bg-amber-50 font-medium">
                        Discover All Artisans <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Artisan Applications -->
    <div class="bg-amber-50 py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-amber-800 mb-6">Are You a Skilled Craftsperson?</h2>
            <p class="text-lg text-gray-700 max-w-3xl mx-auto mb-8">
                If you practice traditional Moroccan crafts and would like to be featured on our platform, we'd love to hear from you.
            </p>
            <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3 bg-amber-600 border border-transparent rounded-md shadow-sm text-lg font-medium text-white hover:bg-amber-700">
                Apply to Join <i class="fas fa-user-plus ml-2"></i>
            </a>
        </div>
    </div>
@endsection
