@extends('layouts.client')

@section('title', 'My Reviews')

@section('content')
    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
        <div class="px-4 sm:px-0">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">My Reviews</h1>
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

            <!-- Reviews List -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-100">
                @if (count($reviews) > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach ($reviews as $review)
                            <li class="transition duration-150 ease-in-out hover:bg-gray-50">
                                <div class="p-6">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3">
                                                <h3 class="text-xl font-semibold text-gray-900 mb-2 sm:mb-0">
                                                    {{ $review->service->name }}</h3>
                                                <div class="flex items-center">
                                                    <div class="flex">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $review->rating)
                                                                <svg class="h-5 w-5 text-yellow-500"
                                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                    fill="currentColor">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @else
                                                                <svg class="h-5 w-5 text-gray-300"
                                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                    fill="currentColor">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <span
                                                        class="ml-2 text-sm font-medium text-gray-600">{{ date('M d, Y', strtotime($review->created_at)) }}</span>
                                                </div>
                                            </div>

                                            <div class="flex items-center mb-4">
                                                @if ($review->artisanProfile->profile_photo)
                                                    <img src="{{ asset('storage/' . $review->artisanProfile->profile_photo) }}"
                                                        alt="{{ $review->artisanProfile->user->firstname }}"
                                                        class="h-10 w-10 rounded-full mr-3 object-cover border-2 border-gray-200">
                                                @else
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-gradient-to-r from-green-500 to-blue-600 flex items-center justify-center mr-3 shadow-sm">
                                                        <span class="text-white text-sm font-medium">
                                                            {{ substr($review->artisanProfile->user->firstname, 0, 1) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <span class="text-sm font-medium text-gray-700">Service by
                                                    <span
                                                        class="text-green-700">{{ $review->artisanProfile->user->firstname }}
                                                        {{ $review->artisanProfile->user->lastname }}</span>
                                                </span>
                                            </div>

                                            <div class="mt-3 text-base text-gray-700 bg-gray-50 p-4 rounded-md">
                                                <p>{{ $review->comment }}</p>
                                            </div>

                                            @if ($review->response)
                                                <div class="mt-4 bg-blue-50 p-4 rounded-md border-l-4 border-blue-400">
                                                    <h4 class="text-sm font-semibold text-gray-800">Response from Artisan:
                                                    </h4>
                                                    <p class="mt-1 text-sm text-gray-700">{{ $review->response }}</p>
                                                    <p class="mt-2 text-xs font-medium text-gray-500">Responded on
                                                        {{ date('M d, Y', strtotime($review->response_date)) }}</p>
                                                </div>
                                            @endif

                                            <div class="mt-5 flex space-x-4">
                                                <a href="{{ route('client.artisans.show', $review->artisanProfile->id) }}"
                                                    class="text-sm font-medium text-green-600 hover:text-green-800 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    View Artisan Profile
                                                </a>
                                                <a href="{{ route('client.bookings.show', $review->booking_id) }}"
                                                    class="text-sm font-medium text-green-600 hover:text-green-800 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                    </svg>
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
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">No reviews yet</h3>
                        <p class="mt-2 text-base text-gray-600 max-w-md mx-auto">You haven't submitted any reviews for your
                            bookings. Reviews help other clients make informed decisions.</p>
                        <div class="mt-8">
                            <a href="{{ route('client.bookings.index') }}"
                                class="inline-flex items-center px-5 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                View My Bookings
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
