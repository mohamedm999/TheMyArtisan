@extends('layouts.client')

@section('title', 'All Available Artisans')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">All Available Artisans</h1>

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-6" role="alert">
                            <span class="block sm:inline">{{ session('info') }}</span>
                        </div>
                    @endif

                    <!-- Artisans Listing -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if(isset($artisans) && $artisans->count() > 0)
                            @foreach($artisans as $artisan)
                                <div class="bg-white rounded-lg overflow-hidden shadow border border-gray-200 hover:shadow-lg transition-shadow">
                                    <div class="p-4">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-full bg-amber-200 flex items-center justify-center text-amber-600 text-xl font-bold mr-4">
                                                {{ isset($artisan->user) ? substr($artisan->user->name, 0, 1) : 'A' }}
                                            </div>
                                            <div>
                                                <h3 class="font-medium">{{ $artisan->user->name ?? 'Unknown Artisan' }}</h3>
                                                <p class="text-sm text-gray-500">{{ $artisan->category->name ?? 'Uncategorized' }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <div class="flex text-amber-500 mb-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($artisan->rating ?? 0))
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
                            @endforeach
                        @else
                            <div class="col-span-3 text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-gray-900">No artisans found</h3>
                                <p class="mt-1 text-sm text-gray-500">There are currently no artisans registered in the system.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    @if(isset($artisans) && $artisans->lastPage() > 1)
                        <div class="mt-8 flex justify-center">
                            {{ $artisans->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
