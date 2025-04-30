@extends('layouts.client')

@section('title', 'Saved Artisans')

@section('content')
    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
        <div class="px-4 sm:px-0">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">My Saved Artisans</h1>
                <a href="{{ route('client.artisans.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Find Artisans
                </a>
            </div>

            @if (session('success'))
                <div class="rounded-md bg-green-50 p-4 mb-6 border border-green-200 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-md bg-red-50 p-4 mb-6 border border-red-200 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-100">
                <!-- Check if there are any saved artisans -->
                @if (isset($savedArtisans) && count($savedArtisans) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                        @foreach ($savedArtisans as $artisan)
                            <div id="artisan-card-{{ $artisan->id }}"
                                class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 transition-all duration-200 hover:shadow-md hover:border-green-300">
                                <div class="p-5">
                                    <div class="flex items-center mb-4">
                                        @if ($artisan->profile_photo)
                                            <img src="{{ asset('storage/' . $artisan->profile_photo) }}"
                                                alt="{{ $artisan->user->firstname }}"
                                                class="h-14 w-14 rounded-full object-cover border-2 border-gray-200 mr-3">
                                        @else
                                            <div
                                                class="h-14 w-14 rounded-full bg-gradient-to-r from-green-500 to-blue-600 flex items-center justify-center mr-3 shadow-sm">
                                                <span class="text-white text-lg font-semibold">
                                                    {{ substr($artisan->user->firstname, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-semibold text-gray-800 text-lg">{{ $artisan->user->firstname }}
                                                {{ $artisan->user->lastname }}</h3>
                                            <p class="text-sm text-gray-500">
                                                {{ $artisan->profession ?? ($artisan->speciality ?? 'Artisan') }}</p>
                                        </div>
                                        <button
                                            class="ml-auto text-red-500 hover:text-red-700 focus:outline-none unsave-button"
                                            data-artisan-id="{{ $artisan->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                            </svg>
                                        </button>
                                        <form id="unsave-form-{{ $artisan->id }}"
                                            action="{{ route('client.unsave-artisan', $artisan->id) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                    <div class="mb-4 space-y-2">
                                        <div class="flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>{{ $artisan->city }}, {{ $artisan->state }}</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                            </svg>
                                            <span>
                                                {{ number_format($artisan->reviews_avg_rating ?? 0, 1) }}
                                                ({{ $artisan->reviews_count }}
                                                {{ Str::plural('review', $artisan->reviews_count) }})
                                            </span>
                                        </div>
                                        @if ($artisan->verified)
                                            <div class="flex items-center text-sm text-green-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                                <span>Verified Professional</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('client.artisans.show', $artisan->id) }}"
                                            class="flex-1 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition-colors duration-150 ease-in-out text-center flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Profile
                                        </a>
                                        <a href="{{ route('client.artisans.show', [$artisan->id, '#book']) }}"
                                            class="flex-1 px-4 py-2 border border-green-600 text-green-600 text-sm font-medium rounded-md hover:bg-green-50 transition-colors duration-150 ease-in-out text-center flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination if needed -->
                    @if (isset($savedArtisans) && method_exists($savedArtisans, 'links'))
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                            {{ $savedArtisans->links() }}
                        </div>
                    @endif
                @else
                    <!-- Empty state with improved design -->
                    <div class="text-center py-16 px-4">
                        <svg class="mx-auto h-16 w-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">No saved artisans yet</h3>
                        <p class="mt-2 text-base text-gray-600 max-w-md mx-auto">When you find artisans you like, save them
                            here for quick access and easy booking.</p>
                        <div class="mt-8">
                            <a href="{{ route('client.artisans.index') }}"
                                class="inline-flex items-center px-5 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Discover Artisans
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Handle unsave buttons with AJAX
                document.querySelectorAll('.unsave-button').forEach(button => {
                    button.addEventListener('click', function() {
                        const artisanId = this.dataset.artisanId;
                        const formId = `unsave-form-${artisanId}`;
                        const form = document.getElementById(formId);
                        const artisanCard = document.getElementById(`artisan-card-${artisanId}`);

                        // Send AJAX request
                        fetch(form.action, {
                                method: 'POST',
                                body: new FormData(form),
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Show success notification
                                    const toast = document.createElement('div');
                                    toast.className =
                                        'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50';
                                    toast.innerText = data.message ||
                                        'Artisan removed from your saved list';
                                    document.body.appendChild(toast);

                                    // Remove the artisan card with animation
                                    artisanCard.classList.add('opacity-0', 'scale-95');
                                    setTimeout(() => {
                                        artisanCard.remove();

                                        // Check if there are no more artisans and reload if needed
                                        const remainingCards = document.querySelectorAll(
                                            '[id^="artisan-card-"]');
                                        if (remainingCards.length === 0) {
                                            window.location.reload();
                                        }
                                    }, 300);

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
                });
            });
        </script>
    @endpush
@endsection
