@extends('layouts.client')

@section('title', 'My Bookings')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">My Bookings</h1>
                <a href="{{ route('client.artisans.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                    Book New Service
                </a>
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
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 001.414-1.414L11.414 10l1.293-1.293a1 1 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Bookings Filters -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Filter Bookings
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('client.bookings.index') }}" method="GET"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="col-span-1">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                        </div>
                        <div class="col-span-1">
                            <label for="date_from" class="block text-sm font-medium text-gray-700">Date From</label>
                            <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                        <div class="col-span-1">
                            <label for="date_to" class="block text-sm font-medium text-gray-700">Date To</label>
                            <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                        <div class="col-span-1 flex items-end">
                            <button type="submit"
                                class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bookings List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                @if (count($bookings) > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach ($bookings as $booking)
                            <li>
                                <a href="{{ route('client.bookings.show', $booking->id) }}" class="block hover:bg-gray-50">
                                    <div class="flex items-center px-4 py-4 sm:px-6">
                                        <div class="min-w-0 flex-1 flex items-center">
                                            <div class="flex-shrink-0">
                                                @if ($booking->artisanProfile->profile_photo)
                                                    <img class="h-12 w-12 rounded-full"
                                                        src="{{ asset('storage/' . $booking->artisanProfile->profile_photo) }}"
                                                        alt="{{ $booking->artisanProfile->user->firstname }}">
                                                @else
                                                    <div
                                                        class="h-12 w-12 rounded-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center">
                                                        <span
                                                            class="text-white font-medium text-lg">{{ substr($booking->artisanProfile->user->firstname, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1 px-4">
                                                <div>
                                                    <p class="text-sm font-medium text-green-600 truncate">
                                                        {{ $booking->service->name }}
                                                    </p>
                                                    <p class="mt-1 flex items-center text-sm text-gray-500">
                                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span
                                                            class="truncate">{{ $booking->artisanProfile->user->firstname }}
                                                            {{ $booking->artisanProfile->user->lastname }}</span>
                                                    </p>
                                                </div>
                                                <div class="mt-2 flex items-center">
                                                    <p class="text-sm text-gray-500">
                                                        <time
                                                            datetime="{{ $booking->booking_date }}">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y - h:i A') }}</time>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="ml-5 flex-shrink-0 flex items-center space-x-4">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $booking->status == 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $booking->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                ">
                                                    {{ ucfirst($booking->status) }}
                                                </span>

                                                @if ($booking->status == 'completed' && !$booking->hasReview())
                                                    <a href="{{ route('client.reviews.create', ['id' => $booking->id]) }}"
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 hover:bg-green-100">
                                                        <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                                            viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3" />
                                                        </svg>
                                                        Leave Review
                                                    </a>
                                                @endif

                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Pagination -->
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $bookings->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings</h3>
                        <p class="mt-1 text-sm text-gray-500">You haven't made any bookings yet.</p>
                        <div class="mt-6">
                            <a href="{{ route('client.artisans.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Browse Artisans
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
