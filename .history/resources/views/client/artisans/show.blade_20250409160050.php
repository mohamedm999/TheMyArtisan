@extends('layouts.client')

@section('title', $artisan->user->firstname . ' - Profile')

@section('styles')
    <style>
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .tab-btn.active {
            border-bottom: 2px solid #047857;
            color: #047857;
            font-weight: 600;
        }

        .skill-tag {
            transition: all 0.2s ease;
        }

        .skill-tag:hover {
            transform: translateY(-2px);
        }

        .specialty-badge {
            position: absolute;
            top: -10px;
            left: 20px;
            z-index: 10;
        }

        .craft-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section with Specialty Badge -->
    <div class="bg-gradient-to-r from-green-50 to-blue-50 relative">
        @if ($artisan->speciality)
            <div
                class="specialty-badge px-4 py-1 bg-gradient-to-r from-green-600 to-blue-600 text-white rounded-full shadow-lg">
                <div class="flex items-center">
                    <span class="craft-icon bg-white">
                        @if (strtolower($artisan->speciality) == 'pottery')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                        @elseif(strtolower($artisan->speciality) == 'leather')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-700" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                    clip-rule="evenodd" />
                            </svg>
                        @elseif(strtolower($artisan->speciality) == 'woodwork')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-800" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                        @endif
                    </span>
                    <span class="font-bold">{{ $artisan->speciality }} Expert</span>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center">
                        @if ($artisan->profile_photo)
                            <img src="{{ asset('storage/' . $artisan->profile_photo) }}"
                                alt="{{ $artisan->user->firstname }}"
                                class="w-20 h-20 md:w-24 md:h-24 rounded-full object-cover border-4 border-white shadow-lg">
                        @else
                            <div
                                class="w-20 h-20 md:w-24 md:h-24 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex justify-center items-center border-4 border-white shadow-lg">
                                <span
                                    class="text-3xl font-bold text-white">{{ substr($artisan->user->firstname, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="ml-4">
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $artisan->user->firstname }}</h1>
                            <p class="text-sm md:text-base text-gray-500">{{ implode(', ', $artisan->skills ?? []) }}</p>

                            <div class="flex items-center mt-2">
                                <div class="flex">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $artisan->reviews_avg_rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-xs md:text-sm text-gray-600 ml-2">({{ $artisan->reviews_count }}
                                    reviews)</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $artisan->city }}, {{ $artisan->state }}
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Member since {{ $artisan->created_at->format('M Y') }}
                        </div>
                    </div>

                    <!-- Skills List - Enhanced Display -->
                    @if (is_array($artisan->skills) && count($artisan->skills) > 0)
                        <div class="mt-4">
                            <div class="flex flex-wrap gap-2">
                                @foreach ($artisan->skills as $skill)
                                    <span
                                        class="skill-tag inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 shadow-sm">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="mt-5 flex lg:mt-0 lg:ml-4 flex-col sm:flex-row gap-3">
                    <a href="#contact"
                        class="sm:inline-flex sm:items-center px-5 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Contact Me
                    </a>
                    <a href="#" onclick="switchTab(event, 'services')"
                        class="sm:inline-flex sm:items-center px-5 py-2 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        View Services
                    </a>

                    <!-- Save Artisan Button -->
                    @auth
                        @php
                            // Fix: Use proper relationship check with exists() instead of contains()
                            $isSaved = Auth::user()
                                ->savedArtisans()
                                ->where('artisan_profile_id', $artisan->id)
                                ->exists();
                        @endphp

                        @if ($isSaved)
                            <form action="{{ route('client.unsave-artisan', $artisan->id) }}" method="POST"
                                id="save-artisan-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="sm:inline-flex sm:items-center px-5 py-2 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Saved
                                </button>
                            </form>
                        @else
                            <form action="{{ route('client.save-artisan', $artisan->id) }}" method="POST"
                                id="save-artisan-form">
                                @csrf
                                <button type="submit"
                                    class="sm:inline-flex sm:items-center px-5 py-2 border border-red-300 text-base font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    Save Artisan
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}?redirect={{ url()->current() }}"
                            class="sm:inline-flex sm:items-center px-5 py-2 border border-red-300 text-base font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            Login to Save
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex overflow-x-auto py-3 space-x-8">
                <button onclick="switchTab(event, 'about')"
                    class="tab-btn active whitespace-nowrap py-2 px-1 text-gray-500 hover:text-gray-900">About</button>
                <button onclick="switchTab(event, 'services')"
                    class="tab-btn whitespace-nowrap py-2 px-1 text-gray-500 hover:text-gray-900">Services</button>
                <button onclick="switchTab(event, 'experience')"
                    class="tab-btn whitespace-nowrap py-2 px-1 text-gray-500 hover:text-gray-900">Experience</button>
                <button onclick="switchTab(event, 'certifications')"
                    class="tab-btn whitespace-nowrap py-2 px-1 text-gray-500 hover:text-gray-900">Certifications</button>
                <button onclick="switchTab(event, 'availability')"
                    class="tab-btn whitespace-nowrap py-2 px-1 text-gray-500 hover:text-gray-900">Availability</button>
                <button onclick="switchTab(event, 'reviews')"
                    class="tab-btn whitespace-nowrap py-2 px-1 text-gray-500 hover:text-gray-900">Reviews</button>
                <button onclick="switchTab(event, 'book')"
                    class="tab-btn whitespace-nowrap py-2 px-1 text-gray-500 hover:text-gray-900">Book Now</button>
                <button onclick="switchTab(event, 'contact')"
                    class="tab-btn whitespace-nowrap py-2 px-1 text-gray-500 hover:text-gray-900">Contact</button>
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- About Tab -->
        <div id="about" class="tab-content active">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-5">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">About {{ $artisan->user->firstname }}</h2>
                    <div class="prose max-w-none text-gray-600">
                        {{ $artisan->bio }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Tab - With Category Information -->
        <div id="services" class="tab-content">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Services Offered</h2>
                <p class="text-gray-500 text-sm mt-1">Browse through {{ $artisan->user->firstname }}'s professional
                    services</p>
            </div>

            <!-- Category Filter for Services -->
            @if ($artisan->services->pluck('category_id')->unique()->count() > 1)
                <div class="mb-4">
                    <div class="flex flex-wrap gap-2">
                        <button
                            class="service-category-filter active px-3 py-1 rounded-full text-sm bg-green-600 text-white"
                            data-category="all">
                            All
                        </button>
                        @foreach ($artisan->services->pluck('category.name', 'category_id')->unique() as $id => $name)
                            @if ($name)
                                <button
                                    class="service-category-filter px-3 py-1 rounded-full text-sm bg-gray-200 hover:bg-gray-300 text-gray-700"
                                    data-category="{{ $id }}">
                                    {{ $name }}
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($artisan->services as $service)
                    <div class="service-card bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100
                                transition transform hover:-translate-y-1 hover:shadow-md"
                        data-category="{{ $service->category_id ?? 'none' }}">
                        @if ($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" class="w-full h-48 object-cover"
                                alt="{{ $service->name }}">
                        @else
                            <div
                                class="w-full h-32 bg-gradient-to-r from-green-200 to-blue-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-white opacity-75" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path
                                        d="M12 6a6 6 0 00-6 6c0 1.8.8 3.4 2 4.5V18a2 2 0 002 2h4a2 2 0 002-2v-1.5c1.2-1 2-2.7 2-4.5a6 6 0 00-6-6zm2 12h-4v-1h4v1zm.5-3.5l-.5.5v1h-4v-1l-.5-.5A4 4 0 018 12a4 4 0 118 0c0 1.5-.8 2.8-2 3.5zM14 9h1v3h-1V9zm-5 0h1v3H9V9z" />
                                </svg>
                            </div>
                        @endif
                        <div class="p-5">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $service->name }}</h3>
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    {{ number_format($service->price, 2) }} DH
                                </span>
                            </div>

                            <!-- Category Badge -->
                            @if ($service->category)
                                <div class="mt-1 mb-2">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $service->category->name }}
                                    </span>
                                </div>
                            @endif

                            <p class="text-gray-600 text-sm mt-2">{{ Str::limit($service->description, 100) }}</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-xs text-gray-500">{{ $service->duration }} min</span>
                                <button type="button"
                                    onclick="toggleServiceDetails('service-details-{{ $service->id }}')"
                                    class="inline-flex items-center px-3 py-1 text-sm bg-white border border-green-600 text-green-600 rounded-md hover:bg-green-50">
                                    View Details
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Service Details Section (Initially Hidden) -->
                        <div id="service-details-{{ $service->id }}"
                            class="hidden bg-gray-50 border-t border-gray-100 p-5">
                            <h4 class="font-medium text-gray-900 mb-2">Service Details</h4>
                            <div class="prose prose-sm text-gray-600">
                                <p>{{ $service->description }}</p>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="block text-gray-500">Duration</span>
                                    <span class="font-medium text-gray-900">{{ $service->duration }} minutes</span>
                                </div>
                                <div>
                                    <span class="block text-gray-500">Price</span>
                                    <span class="font-medium text-gray-900">{{ number_format($service->price, 2) }}
                                        DH</span>
                                </div>
                                @if ($service->category)
                                    <div>
                                        <span class="block text-gray-500">Category</span>
                                        <span class="font-medium text-gray-900">{{ $service->category->name }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="button"
                                    onclick="toggleServiceDetails('service-details-{{ $service->id }}')"
                                    class="text-sm text-gray-600 hover:text-gray-900 inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Close Details
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-gray-50 rounded-lg p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="mt-4 text-gray-500">This artisan has not listed any services yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Experience Tab -->
        <div id="experience" class="tab-content">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Work Experience</h2>
                <p class="text-gray-500 text-sm mt-1">Professional background and expertise</p>
            </div>
            <div class="space-y-5">
                @forelse($artisan->workExperiences as $experience)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden border-l-4 border-green-500 pl-0 pr-6">
                        <div class="p-5">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $experience->position }}</h3>
                                    <h4 class="text-md text-gray-600">{{ $experience->company_name }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $experience->start_date->format('M Y') }} -
                                        {{ $experience->is_current ? 'Present' : $experience->end_date->format('M Y') }}
                                    </p>
                                    <div class="mt-3 text-gray-600">
                                        {{ $experience->description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <p class="mt-4 text-gray-500">No work experience listed.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Certifications Tab -->
        <div id="certifications" class="tab-content">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Certifications</h2>
                <p class="text-gray-500 text-sm mt-1">Professional qualifications and credentials</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($artisan->certifications as $certification)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                        <div class="p-5">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $certification->name }}</h3>
                                    <h4 class="text-md text-gray-600">{{ $certification->issuer }}</h4>
                                    @if ($certification->valid_until)
                                        <p class="text-sm text-gray-500 mt-1">Valid until:
                                            {{ $certification->valid_until->format('M Y') }}</p>
                                    @endif
                                    @if ($certification->description)
                                        <p class="mt-3 text-gray-600 text-sm">{{ $certification->description }}</p>
                                    @endif
                                    @if ($certification->credential_url)
                                        <a href="{{ $certification->credential_url }}" target="_blank"
                                            class="mt-2 inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                            <span>Verify Credential</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                                <path
                                                    d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-gray-50 rounded-lg p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-4 text-gray-500">No certifications listed.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Availability Tab -->
        <div id="availability" class="tab-content">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Availability</h2>
                <p class="text-gray-500 text-sm mt-1">When this artisan is available for booking</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                <div class="p-5">
                    @if (count($artisan->availabilities) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($artisan->availabilities->sortBy('date')->take(6) as $availability)
                                <div
                                    class="bg-white rounded-md border {{ $availability->status === 'booked' ? 'border-red-200 bg-red-50' : 'border-green-200 bg-green-50' }} p-3">
                                    <div class="font-medium text-gray-900">{{ $availability->date->format('D, M d, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-700 mt-1">
                                        {{ $availability->start_time->format('g:i A') }} -
                                        {{ $availability->end_time->format('g:i A') }}
                                    </div>
                                    <div
                                        class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $availability->status === 'booked' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($availability->status ?? 'available') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if (count($artisan->availabilities) > 6)
                            <div class="mt-6 text-center">
                                <button
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    View More Availability
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="text-center p-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-4 text-gray-500">No availability information provided.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Reviews Tab -->
        <div id="reviews" class="tab-content">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Client Reviews</h2>
                <p class="text-gray-500 text-sm mt-1">What others say about working with {{ $artisan->user->firstname }}
                </p>
            </div>

            <div class="space-y-5">
                @forelse($artisan->reviews as $review)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                        <span
                                            class="text-gray-500 font-medium">{{ substr($review->user->firstname ?? 'A', 0, 1) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="font-medium text-gray-900">
                                            {{ $review->user->firstname ?? 'Anonymous' }}</h3>
                                        <p class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center bg-gray-100 px-2 py-1 rounded-md">
                                    <span class="text-sm font-medium text-gray-700 mr-1">{{ $review->rating }}</span>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="prose prose-sm max-w-none text-gray-600">
                                <p>{{ $review->comment }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="mt-4 text-gray-500">No reviews yet. Be the first to leave a review!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Contact Tab -->
        <div id="contact" class="tab-content">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Contact {{ $artisan->user->firstname }}</h2>
                <p class="text-gray-500 text-sm mt-1">Send a message or schedule a consultation</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                <div class="p-5">
                    @if (session('success'))
                        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('client.contact') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="artisan_id" value="{{ $artisan->id }}">

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                            <div class="mt-1">
                                <input type="text" name="subject" id="subject" required
                                    class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md @error('subject') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                @error('subject')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number
                                    (optional)</label>
                                <div class="mt-1">
                                    <input type="tel" name="phone" id="phone"
                                        class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md @error('phone') border-red-300 @enderror">
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="preferred_contact" class="block text-sm font-medium text-gray-700">Preferred
                                    Contact Method</label>
                                <div class="mt-1">
                                    <select id="preferred_contact" name="preferred_contact"
                                        class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="email">Email</option>
                                        <option value="phone">Phone</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                            <div class="mt-1">
                                <textarea id="message" name="message" rows="4" required
                                    class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md @error('message') border-red-300 @enderror"></textarea>
                                @error('message')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="schedule_date" class="block text-sm font-medium text-gray-700">Schedule a Meeting
                                (optional)</label>
                            <div class="mt-1">
                                <input type="datetime-local" name="schedule_date" id="schedule_date"
                                    class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required
                                    class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded @error('terms') border-red-300 @enderror">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700">I agree to the terms and
                                    conditions</label>
                                @error('terms')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="mr-2 -ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                                Send Message
                            </button>
                            <a href="{{ route('client.artisans.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="mr-2 -ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                                Back to Artisans
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Book Now Tab -->
        <div id="book" class="tab-content">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Book {{ $artisan->user->firstname }}'s Services</h2>
                <p class="text-gray-500 text-sm mt-1">Schedule a service appointment</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                <div class="p-5">
                    @if (session('success'))
                        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @auth
                        @if (Auth::user()->clientProfile)
                            <form action="{{ route('client.bookings.store') }}" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="artisan_profile_id" value="{{ $artisan->id }}">

                                <div>
                                    <label for="service_id" class="block text-sm font-medium text-gray-700">Select
                                        Service</label>
                                    <div class="mt-1">
                                        <select id="service_id" name="service_id" required
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                                            <option value="">Select a service</option>
                                            @foreach ($artisan->services as $service)
                                                <option value="{{ $service->id }}" data-price="{{ $service->price }}"
                                                    data-duration="{{ $service->duration }}">
                                                    {{ $service->name }} - {{ number_format($service->price, 2) }} DH
                                                    ({{ $service->duration }} min)
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('service_id')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="booking_date" class="block text-sm font-medium text-gray-700">Booking Date &
                                        Time</label>
                                    <div class="mt-1">
                                        <input type="datetime-local" name="booking_date" id="booking_date" required
                                            min="{{ date('Y-m-d\TH:i') }}"
                                            class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        @error('booking_date')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Please select a date and time for your booking</p>
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Additional
                                        Notes</label>
                                    <div class="mt-1">
                                        <textarea id="notes" name="notes" rows="3"
                                            class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            placeholder="Add any special requests or information the artisan should know"></textarea>
                                        @error('notes')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Service Summary -->
                                <div id="service-summary" class="hidden bg-gray-50 p-4 rounded-md">
                                    <h4 class="font-medium text-gray-900">Booking Summary</h4>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Service:</span>
                                            <span class="text-sm font-medium" id="summary-service">Not selected</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Price:</span>
                                            <span class="text-sm font-medium" id="summary-price">-</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Duration:</span>
                                            <span class="text-sm font-medium" id="summary-duration">-</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="terms" name="terms" type="checkbox" required
                                            class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="terms" class="font-medium text-gray-700">I agree to the terms and
                                            conditions</label>
                                        @error('terms')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="mr-2 -ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Book Now
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="text-center py-6">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Complete your profile first</h3>
                                <p class="mt-1 text-sm text-gray-500">You need to complete your client profile before booking
                                    services.</p>
                                <div class="mt-6">
                                    <a href="{{ route('client.profile') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Complete Profile
                                    </a>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-6">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Login to book services</h3>
                            <p class="mt-1 text-sm text-gray-500">You need to login before you can book services.</p>
                            <div class="mt-6">
                                <a href="{{ route('login') }}?redirect={{ url()->current() }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Login
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <div class="mt-6 bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Contact {{ $artisan->firstname }}</h2>

            @include('client.partials.message-form', ['artisan' => $artisan])
        </div>

        <!-- Contact Form -->
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Contact {{ $artisan->firstname }}</h3>

            <form action="{{ route('messages.start') }}" method="POST">
                @csrf
                <input type="hidden" name="artisan_id" value="{{ $artisan->id }}">

                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                    <textarea id="message" name="message" rows="4"
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                        placeholder="Write your message here..."></textarea>
                </div>

                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Send Message
                </button>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function switchTab(event, tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Deactivate all tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Activate the selected tab content
            document.getElementById(tabId).classList.add('active');

            // Activate the clicked button
            if (event && event.currentTarget) {
                event.currentTarget.classList.add('active');
            } else {
                // If called from elsewhere (like "View Services" button in hero)
                document.querySelector(`[onclick="switchTab(event, '${tabId}')"]`).classList.add('active');
            }

            // Scroll to the top of the tab content
            window.scrollTo({
                top: document.getElementById(tabId).offsetTop - 100,
                behavior: 'smooth'
            });
        }

        // Toggle service details visibility
        function toggleServiceDetails(detailsId) {
            const detailsElement = document.getElementById(detailsId);
            if (detailsElement.classList.contains('hidden')) {
                detailsElement.classList.remove('hidden');
            } else {
                detailsElement.classList.add('hidden');
            }
        }

        // Service category filtering
        document.addEventListener('DOMContentLoaded', function() {
            const categoryButtons = document.querySelectorAll('.service-category-filter');
            const serviceCards = document.querySelectorAll('.service-card');

            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    categoryButtons.forEach(btn => btn.classList.remove('active', 'bg-green-600',
                        'text-white'));
                    btn.classList.add('bg-gray-200', 'text-gray-700');

                    // Add active class to clicked button
                    this.classList.add('active', 'bg-green-600', 'text-white');
                    this.classList.remove('bg-gray-200', 'text-gray-700');

                    const selectedCategory = this.dataset.category;

                    // Filter services
                    serviceCards.forEach(card => {
                        if (selectedCategory === 'all' || card.dataset.category ===
                            selectedCategory) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });

            // Booking form service selection
            const serviceSelect = document.getElementById('service_id');
            const serviceSummary = document.getElementById('service-summary');
            const summaryService = document.getElementById('summary-service');
            const summaryPrice = document.getElementById('summary-price');
            const summaryDuration = document.getElementById('summary-duration');

            if (serviceSelect) {
                serviceSelect.addEventListener('change', function() {
                    if (this.value) {
                        const option = this.options[this.selectedIndex];
                        const price = option.dataset.price;
                        const duration = option.dataset.duration;

                        summaryService.textContent = option.text.split(' - ')[0];
                        summaryPrice.textContent = price ? `${price} DH` : '-';
                        summaryDuration.textContent = duration ? `${duration} minutes` : '-';

                        serviceSummary.classList.remove('hidden');
                    } else {
                        serviceSummary.classList.add('hidden');
                    }
                });
            }
        });

        // Hash URL handling
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash.substring(1);
            if (hash && document.getElementById(hash)) {
                switchTab(null, hash);
            }
        });

        // Add AJAX save functionality for the profile page
        document.addEventListener('DOMContentLoaded', function() {
            const saveForm = document.getElementById('save-artisan-form');

            if (saveForm) {
                saveForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const isUnsave = this.method === 'DELETE' || this.innerHTML.includes('method="DELETE"');

                    fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                const toast = document.createElement('div');
                                toast.className =
                                    'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50';
                                toast.innerHTML = data.message || (isUnsave ?
                                    'Artisan removed from saved list' : 'Artisan saved successfully'
                                );
                                document.body.appendChild(toast);

                                // Update button appearance
                                if (isUnsave) {
                                    // Change to "Save" button
                                    this.action = this.action.replace('unsave', 'save');
                                    this.innerHTML = `
                                    @csrf
                                    <button type="submit" class="sm:inline-flex sm:items-center px-5 py-2 border border-red-300 text-base font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        Save Artisan
                                    </button>
                                `;
                                } else {
                                    // Change to "Unsave" button
                                    this.action = this.action.replace('save', 'unsave');
                                    this.innerHTML = `
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="sm:inline-flex sm:items-center px-5 py-2 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                        </svg>
                                        Saved
                                    </button>
                                `;
                                }

                                // Remove toast after 3 seconds
                                setTimeout(() => {
                                    toast.remove();
                                }, 3000);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            }
        });
    </script>
@endsection
