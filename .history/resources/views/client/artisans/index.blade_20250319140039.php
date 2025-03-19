@extends('layouts.client')

@section('title', 'Find Artisans')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Find Artisans</h1>

            @if (isset($error))
                <div class="bg-red-100 p-4 mb-6 rounded text-red-700">
                    {{ $error }}
                </div>
            @endif

            <!-- Search and Filter -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <form action="{{ route('client.artisans.index') }}" method="GET" class="space-y-4">
                    <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                        <div class="md:w-1/2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search by name,
                                business or location</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50"
                                placeholder="Search artisans...">
                        </div>
                        <div class="md:w-1/4">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select id="category" name="category"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:w-1/4 flex items-end">
                            <button type="submit"
                                class="w-full py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                <i class="fas fa-search mr-2"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Artisans List -->
            @if (isset($paginator) && $paginator->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($paginator as $artisan)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:scale-[1.02]">
                            <a href="{{ route('client.artisans.show', $artisan->id) }}">
                                <div class="h-48 bg-gray-200 relative">
                                    @if ($artisan->artisanProfile && $artisan->artisanProfile->profile_photo)
                                        <img src="{{ asset('storage/' . $artisan->artisanProfile->profile_photo) }}"
                                            alt="{{ $artisan->firstname }} {{ $artisan->lastname }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center bg-amber-50 text-amber-700">
                                            <i class="fas fa-user-circle text-6xl"></i>
                                        </div>
                                    @endif

                                    <div
                                        class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 text-white">
                                        <h3 class="font-semibold text-lg">{{ $artisan->firstname }}
                                            {{ $artisan->lastname }}</h3>
                                        @if ($artisan->artisanProfile && $artisan->artisanProfile->business_name)
                                            <p class="text-sm">{{ $artisan->artisanProfile->business_name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </a>

                            <div class="p-4">
                                <div class="mb-3">
                                    <div class="flex items-center">
                                        <div class="flex items-center text-amber-400 mr-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= round($artisan->rating))
                                                    <i class="fas fa-star"></i>
                                                @elseif($i - 0.5 <= $artisan->rating)
                                                    <i class="fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-600">
                                            {{ number_format($artisan->rating, 1) }} ({{ $artisan->reviews_count }}
                                            reviews)
                                        </span>
                                    </div>
                                </div>

                                @if ($artisan->artisanProfile && $artisan->artisanProfile->profession)
                                    <p class="text-gray-700 mb-2"><i class="fas fa-tools mr-2 text-amber-600"></i>
                                        {{ $artisan->artisanProfile->profession }}</p>
                                @endif

                                @if ($artisan->artisanProfile && $artisan->artisanProfile->city)
                                    <p class="text-gray-700 mb-2"><i class="fas fa-map-marker-alt mr-2 text-amber-600"></i>
                                        {{ $artisan->artisanProfile->city }}
                                    </p>
                                @endif

                                @php
                                    $services = \App\Models\Service::where(
                                        'artisan_profile_id',
                                        $artisan->artisanProfile->id,
                                    )
                                        ->where('is_active', true)
                                        ->take(4)
                                        ->get();
                                @endphp

                                @if ($services->count() > 0)
                                    <div class="mt-2 mb-3">
                                        <p class="text-xs text-gray-500 mb-1">Services:</p>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($services->take(3) as $service)
                                                <span class="text-xs bg-amber-50 text-amber-700 px-2 py-1 rounded">
                                                    {{ $service->name }}
                                                </span>
                                            @endforeach
                                            @if ($services->count() > 3)
                                                <span class="text-xs text-gray-500">+{{ $services->count() - 3 }}
                                                    more</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <a href="{{ route('client.artisans.show', $artisan->id) }}"
                                    class="mt-4 block w-full text-center py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition-colors">
                                    View Profile
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $paginator->links() }}
                </div>
            @else
                <div class="bg-white p-12 rounded-lg shadow text-center">
                    <div class="text-amber-500 text-5xl mb-4">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">No artisans available</h3>
                    <p class="text-gray-500">
                        @if (request('search') || request('category'))
                            No artisans match your current search criteria. Try adjusting your search filters or explore
                            different categories.
                        @else
                            There are currently no artisans available in our system. Please check back later.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
