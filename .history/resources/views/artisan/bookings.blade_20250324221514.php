@extends('layouts.artisan')

@section('title', 'My Bookings')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-amber-800 mb-6">My Bookings</h1>

                    @if (session('success'))
                        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 001.414 0l4-4z"
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
                        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 101.414 1.414L10 11.414l1.293 1.293a1 1 001.414-1.414L11.414 10l1.293-1.293a1 1 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Booking Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-6">
                            <a href="{{ route('artisan.bookings', ['status' => 'pending']) }}"
                                class="{{ $status == 'pending' ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                Pending ({{ $counts['pending'] ?? 0 }})
                            </a>
                            <a href="{{ route('artisan.bookings', ['status' => 'confirmed']) }}"
                                class="{{ $status == 'confirmed' ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                Confirmed ({{ $counts['confirmed'] ?? 0 }})
                            </a>
                            <a href="{{ route('artisan.bookings', ['status' => 'in_progress']) }}"
                                class="{{ $status == 'in_progress' ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                In Progress ({{ $counts['in_progress'] ?? 0 }})
                            </a>
                            <a href="{{ route('artisan.bookings', ['status' => 'completed']) }}"
                                class="{{ $status == 'completed' ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                Completed ({{ $counts['completed'] ?? 0 }})
                            </a>
                            <a href="{{ route('artisan.bookings', ['status' => 'cancelled']) }}"
                                class="{{ $status == 'cancelled' ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                Cancelled ({{ $counts['cancelled'] ?? 0 }})
                            </a>
                        </nav>
                    </div>

                    <!-- Booking Items -->
                    <div class="space-y-4">
                        @forelse($bookings as $booking)
                            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                                <div class="flex flex-col md:flex-row">
                                    <div class="md:w-1/4 bg-gray-50 p-4 flex flex-col justify-between">
                                        <div>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if ($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($booking->status == 'confirmed') bg-blue-100 text-blue-800
                                                @elseif($booking->status == 'in_progress') bg-indigo-100 text-indigo-800
                                                @elseif($booking->status == 'completed') bg-green-100 text-green-800
                                                @elseif($booking->status == 'cancelled') bg-red-100 text-red-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                            </span>
                                            <h3 class="text-lg font-medium text-gray-900 mt-2">
                                                {{ $booking->service->name }}</h3>
                                            <p class="text-sm text-gray-500 mt-1">Service ID: #{{ $booking->service->id }}
                                            </p>
                                        </div>
                                        <div class="mt-4 md:mt-0">
                                            <p class="text-sm font-medium text-gray-500">Price</p>
                                            <p class="text-lg font-semibold text-amber-600">
                                                {{ number_format($booking->service->price, 2) }} DH</p>
                                        </div>
                                    </div>

                                    <div
                                        class="md:w-2/4 p-4 border-t md:border-t-0 md:border-l md:border-r border-gray-200">
                                        <div class="flex items-center mb-3">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                @if ($booking->clientProfile->profile_photo)
                                                    <img src="{{ asset('storage/' . $booking->clientProfile->profile_photo) }}"
                                                        alt="{{ $booking->clientProfile->user->firstname }}"
                                                        class="h-10 w-10 rounded-full">
                                                @else
                                                    <span class="text-gray-500 font-medium">
                                                        {{ substr($booking->clientProfile->user->firstname ?? 'A', 0, 1) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <h4 class="text-sm font-medium text-gray-900">
                                                    {{ $booking->clientProfile->user->firstname }}
                                                    {{ $booking->clientProfile->user->lastname }}
                                                </h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ $booking->clientProfile->city }},
                                                    {{ $booking->clientProfile->state }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="space-y-2">
                                            <div class="flex items-center text-sm">
                                                <i class="fas fa-calendar text-amber-500 mr-2 w-4"></i>
                                                <span>Requested for:
                                                    <strong>{{ \Carbon\Carbon::parse($booking->booking_date)->format('F d, Y - h:i A') }}</strong>
                                                </span>
                                            </div>
                                            <div class="flex items-center text-sm">
                                                <i class="fas fa-clock text-amber-500 mr-2 w-4"></i>
                                                <span>Duration:
                                                    <strong>{{ $booking->service->duration }} minutes</strong>
                                                </span>
                                            </div>
                                            <div class="flex items-start text-sm">
                                                <i class="fas fa-comment-alt text-amber-500 mr-2 w-4 mt-1"></i>
                                                <p class="text-gray-600">{{ $booking->notes ?? 'No special instructions' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="md:w-1/4 p-4 bg-gray-50 border-t md:border-t-0 md:border-l border-gray-200 flex flex-col justify-between">
                                        <div class="text-sm text-gray-500">
                                            <p>Requested: <span
                                                    class="text-gray-900">{{ $booking->created_at->format('M d, Y') }}</span>
                                            </p>
                                        </div>

                                        <div class="mt-4 space-y-2">
                                            @if ($booking->status == 'pending')
                                                <form action="{{ route('artisan.bookings.update', $booking) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit"
                                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none">
                                                        Accept
                                                    </button>
                                                </form>
                                                <form action="{{ route('artisan.bookings.update', $booking) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit"
                                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                                        Decline
                                                    </button>
                                                </form>
                                            @elseif($booking->status == 'confirmed')
                                                <form action="{{ route('artisan.bookings.update', $booking) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="in_progress">
                                                    <button type="submit"
                                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none">
                                                        Start Work
                                                    </button>
                                                </form>
                                            @elseif($booking->status == 'in_progress')
                                                <form action="{{ route('artisan.bookings.update', $booking) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit"
                                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none">
                                                        Mark Complete
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('artisan.bookings.show', $booking->id) }}"
                                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-amber-600 bg-white hover:bg-gray-50 focus:outline-none">
                                                <i class="fas fa-eye mr-2"></i> View Details
                                            </a>

                                            @if ($booking->clientProfile->user->id && Route::has('messages.conversation'))
                                                <a href="{{ route('messages.conversation', $booking->clientProfile->user->id) }}"
                                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-amber-600 bg-white hover:bg-gray-50 focus:outline-none">
                                                    <i class="fas fa-comment mr-2"></i> Message
                                                </a>
                                            @elseif ($booking->clientProfile->user->id)
                                                <!-- Messaging functionality not yet implemented -->
                                                <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-400 bg-white cursor-not-allowed" disabled>
                                                    <i class="fas fa-comment mr-2"></i> Messaging coming soon
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-gray-50 p-6 text-center rounded-lg">
                                <p class="text-gray-500">No {{ $status }} bookings found.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($bookings->count() > 0)
                        <div class="mt-8">
                            {{ $bookings->appends(['status' => $status])->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
