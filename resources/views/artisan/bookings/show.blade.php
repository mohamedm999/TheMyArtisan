@extends('layouts.artisan')

@section('title', 'Booking Details')

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back button -->
            <div class="mb-6">
                <a href="{{ route('artisan.bookings', ['status' => $booking->status]) }}"
                    class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Back to Bookings
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                    <h1 class="text-xl font-semibold text-amber-800">Booking Details</h1>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if ($booking->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($booking->status == 'confirmed') bg-blue-100 text-blue-800
                        @elseif($booking->status == 'in_progress') bg-indigo-100 text-indigo-800
                        @elseif($booking->status == 'completed') bg-green-100 text-green-800
                        @elseif($booking->status == 'cancelled') bg-red-100 text-red-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                    <!-- Client Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Client Information</h2>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-14 w-14 rounded-full bg-gray-200 flex items-center justify-center">
                                @if ($booking->clientProfile->profile_photo)
                                    <img src="{{ asset('storage/' . $booking->clientProfile->profile_photo) }}"
                                        alt="{{ $booking->clientProfile->user->firstname }}" class="h-14 w-14 rounded-full">
                                @else
                                    <span class="text-gray-500 font-medium text-lg">
                                        {{ substr($booking->clientProfile->user->firstname ?? 'A', 0, 1) }}
                                    </span>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h3 class="font-medium text-gray-900">
                                    {{ $booking->clientProfile->user->firstname }}
                                    {{ $booking->clientProfile->user->lastname }}
                                </h3>
                                <p class="text-sm text-gray-500">{{ $booking->clientProfile->phone ?? 'No phone provided' }}
                                </p>
                                <p class="text-sm text-gray-500">{{ $booking->clientProfile->user->email }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">Location:</p>
                            <p class="text-sm text-gray-900">
                                {{ $booking->clientProfile->address ?? 'No address provided' }}<br>
                                {{ $booking->clientProfile->city }}, {{ $booking->clientProfile->state }}
                                {{ $booking->clientProfile->postal_code }}
                            </p>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('messages.conversation', $booking->clientProfile->user->id) }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-amber-600 bg-white hover:bg-gray-50 focus:outline-none">
                                <i class="fas fa-comment mr-2"></i>
                                Contact Client
                            </a>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="md:col-span-2 bg-white border border-gray-200 rounded-lg divide-y divide-gray-200">
                        <div class="p-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $booking->service->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Service ID: #{{ $booking->service->id }}</p>
                        </div>

                        <div class="p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Booking Date:</p>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('F d, Y - h:i A') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Booking Created:</p>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $booking->created_at->format('F d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Duration:</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $booking->service->duration }} minutes
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Price:</p>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ number_format($booking->service->price, 2) }} DH
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if ($booking->notes)
                            <div class="p-4">
                                <p class="text-sm text-gray-500">Client Notes:</p>
                                <p class="text-sm font-medium text-gray-900 mt-1">{{ $booking->notes }}</p>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="p-4">
                            <p class="text-sm text-gray-500 mb-3">Actions:</p>
                            <div class="flex flex-col sm:flex-row gap-2">
                                @if ($booking->status == 'pending')
                                    <form action="{{ route('artisan.bookings.update', $booking) }}" method="POST"
                                        class="flex-1">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit"
                                            class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none">
                                            Accept Booking
                                        </button>
                                    </form>
                                    <form action="{{ route('artisan.bookings.update', $booking) }}" method="POST"
                                        class="flex-1">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit"
                                            class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                            Decline Booking
                                        </button>
                                    </form>
                                @elseif($booking->status == 'confirmed')
                                    <form action="{{ route('artisan.bookings.update', $booking) }}" method="POST"
                                        class="flex-1">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="in_progress">
                                        <button type="submit"
                                            class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none">
                                            Start Work
                                        </button>
                                    </form>
                                @elseif($booking->status == 'in_progress')
                                    <form action="{{ route('artisan.bookings.update', $booking) }}" method="POST"
                                        class="flex-1">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit"
                                            class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none">
                                            Mark as Completed
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
