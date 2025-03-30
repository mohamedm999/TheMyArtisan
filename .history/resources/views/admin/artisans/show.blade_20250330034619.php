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
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Artisan Profile</h2>
                        <div class="flex space-x-2">
                            @if ($artisan->artisanProfile && $artisan->artisanProfile->status === 'pending')
                                <form method="POST" action="{{ route('admin.artisans.approve', $artisan->id) }}"
                                    class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                        <i class="fas fa-check mr-2"></i> Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.artisans.reject', $artisan->id) }}"
                                    class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                        <i class="fas fa-times mr-2"></i> Reject
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Artisan Avatar and Basic Info -->
                        <div class="md:col-span-1">
                            <div class="flex flex-col items-center p-6 bg-gray-50 rounded-lg">
                                <div class="w-32 h-32 mb-4">
                                    @if ($artisan->artisanProfile && $artisan->artisanProfile->profile_photo)
                                        <img src="{{ asset('storage/' . $artisan->artisanProfile->profile_photo) }}"
                                            alt="{{ $artisan->firstname }} {{ $artisan->lastname }}"
                                            class="w-full h-full rounded-full object-cover border-4 border-white shadow">
                                    @else
                                        <div
                                            class="w-full h-full rounded-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center text-white text-4xl font-medium border-4 border-white shadow">
                                            {{ substr($artisan->firstname, 0, 1) }}{{ substr($artisan->lastname, 0, 1) }}
                                        </div>
                                    @endif
                                </div>

                                <h3 class="text-xl font-bold text-gray-800">{{ $artisan->firstname }}
                                    {{ $artisan->lastname }}</h3>
                                <p class="text-gray-600 mb-2">{{ $artisan->email }}</p>

                                <div class="mt-2">
                                    <span
                                        class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Artisan
                                    </span>
                                </div>

                                <div class="mt-4 w-full">
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-500">User ID:</span>
                                        <span class="font-medium">{{ $artisan->id }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-500">Status:</span>
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $artisan->artisanProfile && $artisan->artisanProfile->status === 'approved'
                                                ? 'bg-green-100 text-green-800'
                                                : ($artisan->artisanProfile && $artisan->artisanProfile->status === 'rejected'
                                                    ? 'bg-red-100 text-red-800'
                                                    : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $artisan->artisanProfile ? ucfirst($artisan->artisanProfile->status) : 'Pending' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-500">Joined:</span>
                                        <span>{{ $artisan->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <span class="text-gray-500">Last Updated:</span>
                                        <span>{{ $artisan->updated_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Artisan Details -->
                        <div class="md:col-span-2">
                            <div class="bg-white rounded-lg">
                                <div class="mb-6">
                                    <h4 class="text-lg font-medium border-b pb-2 mb-3">Personal Information</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm text-gray-500">First Name</label>
                                            <div class="font-medium">{{ $artisan->firstname }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-500">Last Name</label>
                                            <div class="font-medium">{{ $artisan->lastname }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-500">Email</label>
                                            <div class="font-medium">{{ $artisan->email }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-500">Phone</label>
                                            <div class="font-medium">
                                                {{ $artisan->artisanProfile->phone ?? 'Not provided' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Artisan Specific Information -->
                                @if ($artisan->artisanProfile)
                                    <div class="mb-6">
                                        <h4 class="text-lg font-medium border-b pb-2 mb-3">Artisan Details</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm text-gray-500">Specialty</label>
                                                <div class="font-medium">
                                                    {{ $artisan->artisanProfile->specialty ?? 'Not specified' }}</div>
                                            </div>
                                            <div>
                                                <label class="block text-sm text-gray-500">Experience</label>
                                                <div class="font-medium">
                                                    {{ $artisan->artisanProfile->years_experience ?? '0' }} years</div>
                                            </div>
                                            <div>
                                                <label class="block text-sm text-gray-500">Service Radius</label>
                                                <div class="font-medium">
                                                    {{ $artisan->artisanProfile->service_radius ?? 'Not specified' }} km
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm text-gray-500">Location</label>
                                                <div class="font-medium">
                                                    @if ($artisan->artisanProfile->city || $artisan->artisanProfile->state || $artisan->artisanProfile->country_id)
                                                        {{ $artisan->artisanProfile->city ?? '' }}
                                                        {{ $artisan->artisanProfile->city && $artisan->artisanProfile->state ? ', ' : '' }}
                                                        {{ $artisan->artisanProfile->state ?? '' }}
                                                    @else
                                                        Not specified
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        @if ($artisan->artisanProfile->bio)
                                            <div class="mt-4">
                                                <label class="block text-sm text-gray-500">Bio</label>
                                                <div class="mt-1 text-gray-800">{{ $artisan->artisanProfile->bio }}</div>
                                            </div>
                                        @endif

                                        @if ($artisan->artisanProfile->skills && count($artisan->artisanProfile->skills) > 0)
                                            <div class="mt-4">
                                                <label class="block text-sm text-gray-500">Skills</label>
                                                <div class="mt-1 flex flex-wrap gap-2">
                                                    @foreach ($artisan->artisanProfile->skills as $skill)
                                                        <span
                                                            class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $skill }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <!-- Services Section -->
                                @if (count($artisan->services) > 0)
                                    <div class="mb-6">
                                        <h4 class="text-lg font-medium border-b pb-2 mb-3">Services Offered</h4>
                                        <div class="grid grid-cols-1 gap-4">
                                            @foreach ($artisan->services as $service)
                                                <div class="border rounded-md p-3 bg-gray-50">
                                                    <div class="flex justify-between items-center mb-1">
                                                        <h5 class="font-medium">{{ $service->name }}</h5>
                                                        <span
                                                            class="font-medium text-gray-800">{{ number_format($service->price, 2) }}
                                                            DH</span>
                                                    </div>
                                                    <p class="text-sm text-gray-600">{{ $service->description }}</p>
                                                    <div class="mt-2 flex items-center justify-between">
                                                        <span class="text-xs px-2 py-1 bg-gray-200 rounded">
                                                            {{ $service->category->name ?? 'Uncategorized' }}
                                                        </span>
                                                        <span class="text-xs text-gray-500">{{ $service->duration ?? 0 }}
                                                            minutes</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Booking History -->
                                @if (count($artisan->bookings) > 0)
                                    <div class="mb-6">
                                        <h4 class="text-lg font-medium border-b pb-2 mb-3">Recent Bookings</h4>
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Date</th>
                                                        <th
                                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Client</th>
                                                        <th
                                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Service</th>
                                                        <th
                                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach ($artisan->bookings->take(5) as $booking)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                {{ $booking->booking_date->format('M d, Y H:i') }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                @if ($booking->client)
                                                                    {{ $booking->client->firstname }}
                                                                    {{ $booking->client->lastname }}
                                                                @else
                                                                    Unknown Client
                                                                @endif
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                {{ $booking->service->name ?? 'N/A' }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <span
                                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                    {{ $booking->status === 'completed'
                                                                        ? 'bg-green-100 text-green-800'
                                                                        : ($booking->status === 'cancelled'
                                                                            ? 'bg-red-100 text-red-800'
                                                                            : 'bg-yellow-100 text-yellow-800') }}">
                                                                    {{ ucfirst($booking->status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
