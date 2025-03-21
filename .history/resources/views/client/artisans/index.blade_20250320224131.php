@extends('layouts.client')

@section('title', 'Browse Artisans - MyArtisan')
@section('description', 'Find skilled Moroccan artisans for your craft needs. Browse profiles, reviews, and book services.')

@section('content')
    <!-- Simple Hero Section -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900">Find an Artisan</h1>
            <p class="text-gray-600 mt-1">Browse our network of skilled artisans and craftsmen</p>
        </div>
    </div>

    <!-- Simple Filter Section -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form action="{{ route('client.artisans.index') }}" method="GET">
                <div class="flex flex-col md:flex-row md:items-end gap-4">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" id="search" 
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            placeholder="Name or skill">
                    </div>
                    
                    <div class="w-full md:w-1/5">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select id="category" name="category"
                            class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            <option value="">All Categories</option>
                            <option value="pottery">Pottery</option>
                            <option value="zellige">Zellige</option>
                            <option value="leather">Leather Craft</option>
                            <option value="carpets">Carpets & Textiles</option>
                            <option value="woodwork">Woodwork</option>
                        </select>
                    </div>
                    
                    <div class="w-full md:w-1/5">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <select id="location" name="location"
                            class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
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
                            class="w-full md:w-auto px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section - List View -->
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @if ($artisans->count() > 0)
                <div class="mb-4 text-sm text-gray-500">
                    Found {{ $artisans->count() }} artisans matching your criteria
                </div>

                <div class="bg-white border border-gray-200 rounded-md shadow-sm overflow-hidden">
                    <!-- Artisans List -->
                    <ul class="divide-y divide-gray-200">
                        @foreach ($artisans as $artisan)
                            <li class="hover:bg-gray-50">
                                <a href="{{ route('client.artisans.show', $artisan->id) }}" class="block">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <!-- Artisan image -->
                                            <div class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-full overflow-hidden border border-gray-200">
                                                @if ($artisan->profile_photo)
                                                    <img src="{{ asset('storage/' . $artisan->profile_photo) }}" 
                                                        alt="{{ $artisan->user->firstname }}" 
                                                        class="h-full w-full object-cover">
                                                @else
                                                    <div class="flex items-center justify-center h-full w-full bg-gray-200">
                                                        <i class="fas fa-user text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Artisan Info -->
                                            <div class="ml-4 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <h3 class="text-base font-medium text-gray-900">
                                                            {{ $artisan->user->firstname }} {{ $artisan->user->lastname }}
                                                            @if ($artisan->is_featured)
                                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Featured</span>
                                                            @endif
                                                        </h3>
                                                        <p class="text-sm text-gray-500">{{ $artisan->profession ?? 'Artisan' }}</p>
                                                    </div>
                                                    <div class="flex items-center">
                                                        @if($artisan->reviews->count() > 0)
                                                            <div class="flex items-center">
                                                                <span class="text-sm font-medium text-gray-900">{{ number_format($artisan->reviews->avg('rating') ?? 0, 1) }}</span>
                                                                <div class="flex items-center ml-1">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        @if($i <= round($artisan->reviews->avg('rating') ?? 0))
                                                                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                                                                        @else
                                                                            <i class="far fa-star text-yellow-400 text-xs"></i>
                                                                        @endif
                                                                    @endfor
                                                                </div>
                                                                <span class="text-sm text-gray-500 ml-1">({{ $artisan->reviews->count() }})</span>
                                                            </div>
                                                        @else
                                                            <span class="text-sm text-gray-500">No reviews yet</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-2 sm:flex sm:justify-between">
                                                    <div class="sm:flex">
                                                        <p class="flex items-center text-sm text-gray-500">
                                                            <i class="fas fa-map-marker-alt flex-shrink-0 mr-1.5 text-gray-400"></i>
                                                            {{ $artisan->city ?? 'Morocco' }}
                                                        </p>
                                                        @if($artisan->years_experience)
                                                            <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                                <i class="fas fa-briefcase flex-shrink-0 mr-1.5 text-gray-400"></i>
                                                                {{ $artisan->years_experience }} {{ $artisan->years_experience == 1 ? 'year' : 'years' }} experience
                                                            </p>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="mt-2 flex items-center text-sm sm:mt-0">
                                                        @if($artisan->services->count() > 0)
                                                            <div class="flex flex-wrap gap-1">
                                                                @foreach($artisan->services->take(2) as $service)
                                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                                        {{ $service->title }}
                                                                    </span>
                                                                @endforeach
                                                                @if($artisan->services->count() > 2)
                                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                                        +{{ $artisan->services->count() - 2 }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Arrow icon -->
                                            <div class="ml-4">
                                                <i class="fas fa-chevron-right text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Pagination would go here -->
                
            @else
                <div class="bg-white p-6 text-center border border-gray-200 rounded-md">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 mb-4">
                        <i class="fas fa-search text-gray-500"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No artisans found</h3>
                    <p class="mt-1 text-gray-500">Try adjusting your search filters or check back later.</p>
                    <div class="mt-4">
                        <a href="{{ route('client.artisans.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                            Clear filters
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
