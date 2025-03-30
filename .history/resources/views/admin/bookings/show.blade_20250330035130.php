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
                        <div class="flex space-x-2">
                            <div>
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
                            <button type="button" onclick="openStatusModal()"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                <i class="fas fa-edit mr-2"></i> Change Status
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Booking Details -->
                        <div>
                            <div class="bg-gray-50 p-5 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Booking Information</h3>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Service</p>
                                        <p class="font-medium">{{ $booking->service->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Price</p>
                                        <p class="font-medium">{{ number_format($booking->service->price, 2) }} DH</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Booking Date</p>
                                        <p class="font-medium">{{ $booking->booking_date->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Time</p>
                                        <p class="font-medium">{{ $booking->booking_date->format('h:i A') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Created On</p>
                                        <p class="font-medium">{{ $booking->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Last Updated</p>
                                        <p class="font-medium">{{ $booking->updated_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>

                                @if ($booking->notes)
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500">Notes</p>
                                        <p class="font-medium">{{ $booking->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Client & Artisan Info -->
                        <div>
                            <div class="bg-gray-50 p-5 rounded-lg mb-5">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Client Information</h3>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if ($booking->client->clientProfile && $booking->client->clientProfile->profile_photo)
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ Storage::url($booking->client->clientProfile->profile_photo) }}"
                                                alt="{{ $booking->client->firstname }}">
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-full bg-blue-200 flex items-center justify-center text-blue-600 font-medium">
                                                {{ substr($booking->client->firstname, 0, 1) }}{{ substr($booking->client->lastname, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $booking->client->firstname }} {{ $booking->client->lastname }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $booking->client->email }}
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 text-sm">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-gray-500">Phone</p>
                                            <p class="font-medium">
                                                {{ $booking->client->clientProfile->phone ?? 'Not provided' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Address</p>
                                            <p class="font-medium">
                                                {{ $booking->client->clientProfile->address ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-5 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Artisan Information</h3>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if ($booking->artisan->artisanProfile && $booking->artisan->artisanProfile->profile_photo)
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ Storage::url($booking->artisan->artisanProfile->profile_photo) }}"
                                                alt="{{ $booking->artisan->firstname }}">
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-full bg-green-200 flex items-center justify-center text-green-600 font-medium">
                                                {{ substr($booking->artisan->firstname, 0, 1) }}{{ substr($booking->artisan->lastname, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $booking->artisan->firstname }} {{ $booking->artisan->lastname }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $booking->artisan->email }}
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 text-sm">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-gray-500">Phone</p>
                                            <p class="font-medium">
                                                {{ $booking->artisan->artisanProfile->phone ?? 'Not provided' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Specialty</p>
                                            <p class="font-medium">
                                                {{ $booking->artisan->artisanProfile->specialty ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review Section, if available -->
                    @if ($booking->review)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Client Review</h3>
                            <div class="bg-gray-50 p-5 rounded-lg">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-yellow-100 text-yellow-500">
                                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="flex items-center">
                                            <div class="flex items-center text-yellow-400">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $booking->review->rating)
                                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                                            <path
                                                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-5 w-5 fill-current text-gray-300" viewBox="0 0 24 24">
                                                            <path
                                                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                                        </svg>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span
                                                class="ml-2 text-sm text-gray-600">{{ $booking->review->rating }}/5</span>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-700">
                                            <p>{{ $booking->review->comment }}</p>
                                        </div>
                                        <div class="mt-1 text-xs text-gray-500">
                                            Reviewed on {{ $booking->review->created_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('admin.bookings.status', $booking) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Update Booking Status
                                </h3>
                                <div class="mt-4">
                                    <select name="status" id="status"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="confirmed"
                                            {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="completed"
                                            {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled"
                                            {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Update Status
                        </button>
                        <button type="button" onclick="closeStatusModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openStatusModal() {
            document.getElementById('statusModal').classList.remove('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }
    </script>
@endsection
