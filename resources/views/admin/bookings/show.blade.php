@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('admin.bookings.index') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Bookings
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Booking #{{ $booking->id }}</h2>
                        <span
                            class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                        {{ $booking->status === 'confirmed'
                            ? 'bg-green-100 text-green-800'
                            : ($booking->status === 'cancelled'
                                ? 'bg-red-100 text-red-800'
                                : ($booking->status === 'completed'
                                    ? 'bg-blue-100 text-blue-800'
                                    : 'bg-yellow-100 text-yellow-800')) }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Booking Details</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Service:</span>
                                    <span class="font-medium">{{ $booking->service->name ?? 'Unknown Service' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Date:</span>
                                    <span
                                        class="font-medium">{{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : 'Unknown' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Time:</span>
                                    <span class="font-medium">{{ $booking->booking_time ?? 'No time set' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Duration:</span>
                                    <span class="font-medium">{{ $booking->duration ?? 'Unknown' }} minutes</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Price:</span>
                                    <span class="font-medium">€{{ number_format($booking->price ?? 0, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Created at:</span>
                                    <span class="font-medium">{{ $booking->created_at->format('M d, Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="border p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Client & Artisan</h3>
                            <div class="mb-4">
                                <h4 class="text-md font-medium text-gray-700 mb-2">Client</h4>
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        {{ substr($booking->client->firstname ?? '', 0, 1) }}{{ substr($booking->client->lastname ?? '', 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $booking->client->firstname ?? 'Unknown' }}
                                            {{ $booking->client->lastname ?? '' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $booking->client->email ?? 'No email' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-2">Artisan</h4>
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        {{ substr($booking->artisan->firstname ?? '', 0, 1) }}{{ substr($booking->artisan->lastname ?? '', 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $booking->artisan->firstname ?? 'Unknown' }}
                                            {{ $booking->artisan->lastname ?? '' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $booking->artisan->email ?? 'No email' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($booking->notes)
                        <div class="mt-6 border p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-800 mb-2">Booking Notes</h3>
                            <p class="text-gray-700">{{ $booking->notes }}</p>
                        </div>
                    @endif

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Update Booking Status</h3>
                        <form method="POST" action="{{ route('admin.bookings.status', $booking) }}"
                            class="flex items-center space-x-4">
                            @csrf
                            @method('PUT')
                            <select name="status"
                                class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>
                                    Confirmed</option>
                                <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>
                                    Completed</option>
                                <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>
                                    Cancelled</option>
                            </select>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Update Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
