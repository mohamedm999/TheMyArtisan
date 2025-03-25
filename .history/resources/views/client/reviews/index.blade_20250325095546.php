@extends('layouts.client')

@section('title', 'My Reviews')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">My Reviews</h1>
            </div>

            @if (session('success'))
                <div class="rounded-md bg-green-50 p-4 mb-6">
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
                <div class="rounded-md bg-red-50 p-4 mb-6">
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

            <!-- Reviews List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                @if (count($reviews) > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach ($reviews as $review)
                            <li>
                                <div class="bg-white p-6 border-b border-gray-200">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <h3 class="text-lg font-medium text-gray-900">{{ $review->service->name }}</h3>
                                                <div class="flex items-center">
                                                    <div class="flex">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $review->rating)
                                                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @else
                                                                <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <span class="ml-1 text-sm text-gray-600">{{ date('M d, Y', strtotime($review->created_at)) }}</span>
                                                </div>
                                            </div>

                                            <div class="flex items-center mb-4">
                                                @if ($review->artisanProfile->profile_photo)
                                                    <img src="{{ asset('storage/' . $review->artisanProfile->profile_photo) }}"
                                                         alt="{{ $review->artisanProfile->user->firstname }}"
                                                         class="h-8 w-8 rounded-full mr-3">
                                                @else
                                                    <div class="h-8 w-8 rounded-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center mr-3">
                                                        <span class="text-white text-sm font-medium">
                                                            {{ substr($review->artisanProfile->user->firstname, 0, 1) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <span class="text-sm text-gray-700">Service by {{ $review->artisanProfile->user->firstname }} {{ $review->artisanProfile->user->lastname }}</span>
                                            </div>

                                            <div class="mt-2 text-sm text-gray-700">
                                                <p>{{ $review->comment }}</p>
                                            </div>

                                            @if ($review->response)
                                                <div class="mt-4 bg-gray-50 p-4 rounded-md">
                                                    <h4 class="text-sm font-medium text-gray-700">Response from Artisan:</h4>
                                                    <p class="mt-1 text-sm text-gray-600">{{ $review->response }}</p>
                                                    <p class="mt-1 text-xs text-gray-500">Responded on {{ date('M d, Y', strtotime($review->response_date)) }}</p>
                                                </div>
                                            @endif

                                            <div class="mt-4 flex">
                                                <a href="{{ route('client.artisans.show', $review->artisanProfile->id) }}"
                                                   class="text-sm text-green-600 hover:text-green-800">
                                                    View Artisan Profile
                                                </a>
                                                <span class="mx-2 text-gray-300">|</span>
                                                <a href="{{ route('client.bookings.show', $review->booking_id) }}"
                                                   class="text-sm text-green-600 hover:text-green-800">
                                                    View Booking Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Pagination -->
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No reviews yet</h3>
                        <p class="mt-1 text-sm text-gray-500">You haven't submitted any reviews yet.</p>
                        <div class="mt-6">
                            <a href="{{ route('client.bookings.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                View My Bookings
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
