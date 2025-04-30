@extends('layouts.client')

@section('title', 'Booking Details')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Back button -->
            <div class="mb-6">
                <a href="{{ route('client.bookings.index') }}"
                    class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                    <svg class="mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Back to My Bookings
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Booking Details
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Information about your service booking.
                        </p>
                    </div>
                    <div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $booking->status == 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $booking->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                        ">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Service
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $booking->service->name }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Artisan
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $booking->artisanProfile->user->firstname }}
                                {{ $booking->artisanProfile->user->lastname }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Date & Time
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('F j, Y - h:i A') }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Booking Made On
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $booking->created_at->format('F j, Y') }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Price
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ number_format($booking->service->price, 2) }} DH
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Notes
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $booking->notes ?? 'No additional notes' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Actions Section -->
                <div class="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        @if ($booking->status == 'pending' || $booking->status == 'confirmed')
                            <form action="{{ route('client.bookings.cancel', $booking->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to cancel this booking?')"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Cancel Booking
                                </button>
                            </form>
                        @endif

                        @if ($booking->status == 'completed' && !$booking->review)
                            <a href="#"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                                Leave Review
                            </a>
                        @endif

                        <a href="{{ route('client.artisans.show', $booking->artisanProfile->id) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            View Artisan Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
