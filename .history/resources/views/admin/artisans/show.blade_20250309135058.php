@extends('layouts.admin')

@section('title', 'Artisan Details')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('admin.artisans.index') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Artisans
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3 mb-6 md:mb-0 md:pr-6">
                            <div class="flex justify-center">
                                @if ($artisan->profile && $artisan->profile->avatar)
                                    <img src="{{ Storage::url($artisan->profile->avatar) }}"
                                        alt="{{ $artisan->firstname }} {{ $artisan->lastname }}"
                                        class="rounded-full h-48 w-48 object-cover">
                                @else
                                    <div
                                        class="rounded-full h-48 w-48 bg-gray-300 flex items-center justify-center text-4xl">
                                        {{ substr($artisan->firstname, 0, 1) }}{{ substr($artisan->lastname, 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <div class="mt-6 text-center">
                                <h1 class="text-2xl font-bold">{{ $artisan->firstname }} {{ $artisan->lastname }}</h1>
                                <p class="text-gray-600">{{ $artisan->email }}</p>

                                @if ($artisan->profile)
                                    <div class="mt-4">
                                        @if ($artisan->profile->status === 'approved')
                                            <span
                                                class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        @elseif($artisan->profile->status === 'rejected')
                                            <span
                                                class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Rejected
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                @if ($artisan->profile && $artisan->profile->status === 'pending')
                                    <div class="mt-4 flex justify-center space-x-2">
                                        <form method="POST" action="{{ route('admin.artisans.approve', $artisan->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                                Approve
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.artisans.reject', $artisan->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="md:w-2/3">
                            <div class="mb-6">
                                <h2 class="text-xl font-semibold border-b pb-2">Profile Information</h2>

                                @if ($artisan->profile)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                        <div>
                                            <p class="text-gray-600">Specialty</p>
                                            <p class="font-medium">{{ $artisan->profile->specialty ?? 'Not specified' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Experience</p>
                                            <p class="font-medium">{{ $artisan->profile->experience ?? 'Not specified' }}
                                                years</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Phone</p>
                                            <p class="font-medium">{{ $artisan->profile->phone ?? 'Not specified' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Location</p>
                                            <p class="font-medium">
                                                {{ $artisan->profile->city ?? 'Not specified' }}{{ $artisan->profile->city && $artisan->profile->country ? ', ' : '' }}{{ $artisan->profile->country ?? '' }}
                                            </p>
                                        </div>
                                        <div class="col-span-2">
                                            <p class="text-gray-600">Bio</p>
                                            <p class="font-medium">{{ $artisan->profile->bio ?? 'No bio available' }}</p>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-gray-500 mt-2">Profile not completed</p>
                                @endif
                            </div>

                            <div class="mb-6">
                                <h2 class="text-xl font-semibold border-b pb-2">Services Offered</h2>

                                @if (count($artisan->services) > 0)
                                    <div class="mt-4 space-y-4">
                                        @foreach ($artisan->services as $service)
                                            <div class="border rounded-lg p-4 bg-gray-50">
                                                <div class="flex justify-between">
                                                    <h3 class="font-medium">{{ $service->name }}</h3>
                                                    <span
                                                        class="font-medium">€{{ number_format($service->price, 2) }}</span>
                                                </div>
                                                <p class="text-gray-600 mt-2">{{ $service->description }}</p>
                                                <div class="mt-2">
                                                    <span
                                                        class="px-2 py-1 bg-gray-200 rounded text-xs">{{ $service->category->name ?? 'Uncategorized' }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 mt-2">No services listed</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bookings Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-semibold mb-4">Recent Bookings</h2>

                    @if (count($artisan->bookings) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Client</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Service</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($artisan->bookings->take(5) as $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $booking->client->firstname }} {{ $booking->client->lastname }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $booking->service->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $booking->booking_date->format('M d, Y') }} at
                                                {{ $booking->booking_time }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $booking->status === 'confirmed'
                                                    ? 'bg-green-100 text-green-800'
                                                    : ($booking->status === 'cancelled'
                                                        ? 'bg-red-100 text-red-800'
                                                        : ($booking->status === 'completed'
                                                            ? 'bg-blue-100 text-blue-800'
                                                            : 'bg-yellow-100 text-yellow-800')) }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                                    class="text-blue-600 hover:text-blue-900">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($artisan->bookings->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="{{ route('admin.bookings.index', ['artisan_id' => $artisan->id]) }}"
                                    class="text-blue-600 hover:text-blue-900">
                                    View all {{ $artisan->bookings->count() }} bookings
                                </a>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-500">No bookings found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
