@extends('layouts.client')

@section('title', 'All Available Artisans')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">All Available Artisans</h1>

                    <!-- Artisans Listing -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($artisans as $artisan)
                            <div class="bg-white rounded-lg overflow-hidden shadow border border-gray-200 hover:shadow-lg transition-shadow">
                                <div class="p-4">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-full bg-amber-200 flex items-center justify-center text-amber-600 text-xl font-bold mr-4">
                                            {{ substr($artisan->user->name ?? 'A', 0, 1) }}
                                        </div>
                                        <div>
                                            <h3 class="font-medium">{{ $artisan->user->name ?? 'Artisan' }}</h3>
                                            <p class="text-sm text-gray-500">{{ $artisan->category->name ?? 'Artisan' }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="flex text-amber-500 mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($artisan->rating ?? 0))
                                                    <i class="fas fa-star"></i>
                                                @elseif($i - 0.5 <= ($artisan->rating ?? 0))
                                                    <i class="fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                            <span class="ml-2 text-gray-600 text-sm">
                                                {{ number_format($artisan->rating ?? 0, 1) }}
                                                ({{ $artisan->reviews_count ?? 0 }} reviews)
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                            {{ $artisan->city ?? 'Location not specified' }}
                                        </div>
                                        <p class="mt-3 text-sm text-gray-600 line-clamp-2">
                                            {{ $artisan->description ?? 'No description available.' }}
                                        </p>
                                    </div>
                                    <div class="mt-4 flex justify-end items-center">
                                        <a href="{{ url('/artisans') }}/{{ $artisan->id }}"
                                           class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                                            View Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-8">
                                <p class="text-gray-500">No artisans are currently available.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex justify-center">
                        {{ $artisans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
