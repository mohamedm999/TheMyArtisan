@extends('layouts.admin')

@section('title', 'Artisan Details')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Artisan Details</h2>
                    <a href="{{ route('admin.artisans.index') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Artisans
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-wrap">
                        <!-- Artisan basic info -->
                        <div class="w-full lg:w-1/3 px-4 mb-6">
                            <div class="bg-white rounded-lg shadow-sm p-6">
                                <div class="flex items-center mb-6">
                                    <div class="flex-shrink-0 h-20 w-20 rounded-full overflow-hidden bg-gray-100 mr-4">
                                        @if ($artisan->artisanProfile && $artisan->artisanProfile->profile_photo)
                                            <img src="{{ Storage::url($artisan->artisanProfile->profile_photo) }}"
                                                alt="{{ $artisan->firstname }}" class="h-full w-full object-cover">
                                        @else
                                            <div
                                                class="h-20 w-20 bg-blue-100 text-blue-800 flex items-center justify-center rounded-full">
                                                <span
                                                    class="text-2xl font-bold">{{ substr($artisan->firstname, 0, 1) }}{{ substr($artisan->lastname, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $artisan->firstname }}
                                            {{ $artisan->lastname }}</h3>
                                        <p class="text-sm text-gray-500">{{ $artisan->email }}</p>
                                        <p class="text-sm text-gray-500">Joined {{ $artisan->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>

                                @if ($artisan->artisanProfile)
                                    <div class="mb-6">
                                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Status
                                        </h4>
                                        <div class="flex items-center">
                                            @php
                                                $statusField = $artisan->artisanProfile->getAttributes();
                                                $status = isset($statusField['status'])
                                                    ? $statusField['status']
                                                    : 'pending';
                                            @endphp
                                            @if ($status === 'approved')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Approved
                                                </span>
                                            @elseif($status === 'rejected')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Rejected
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="border-t border-gray-200 pt-4">
                                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Contact
                                        Information</h4>
                                    <ul class="space-y-2">
                                        <li class="flex items-start">
                                            <div class="flex-shrink-0 h-5 w-5 text-gray-400">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <div class="ml-3 text-sm text-gray-700">{{ $artisan->email }}</div>
                                        </li>
                                        <li class="flex items-start">
                                            <div class="flex-shrink-0 h-5 w-5 text-gray-400">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                            <div class="ml-3 text-sm text-gray-700">
                                                {{ $artisan->artisanProfile->phone ?? 'Not provided' }}</div>
                                        </li>
                                        <li class="flex items-start">
                                            <div class="flex-shrink-0 h-5 w-5 text-gray-400">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                            <div class="ml-3 text-sm text-gray-700">
                                                @if ($artisan->artisanProfile && $artisan->artisanProfile->address)
                                                    {{ $artisan->artisanProfile->address }}<br>
                                                    @if ($artisan->artisanProfile->city)
                                                        {{ is_object($artisan->artisanProfile->city) ? $artisan->artisanProfile->city->name : $artisan->artisanProfile->city }}
                                                    @endif
                                                    @if ($artisan->artisanProfile->state)
                                                        {{ $artisan->artisanProfile->state }}
                                                    @endif
                                                    @if ($artisan->artisanProfile->postal_code)
                                                        {{ $artisan->artisanProfile->postal_code }}
                                                    @endif
                                                    @if ($artisan->artisanProfile->country)
                                                        <br>{{ is_object($artisan->artisanProfile->country) ? $artisan->artisanProfile->country->name : $artisan->artisanProfile->country }}
                                                    @endif
                                                @else
                                                    Not provided
                                                @endif
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Artisan professional info -->
                        <div class="w-full lg:w-2/3 px-4">
                            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Professional
                                    Information</h4>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-700">Specialty</h5>
                                        <p class="text-gray-900">
                                            {{ $artisan->artisanProfile && $artisan->artisanProfile->specialty ? $artisan->artisanProfile->specialty : 'Not specified' }}
                                        </p>
                                    </div>

                                    <div>
                                        <h5 class="text-sm font-medium text-gray-700">Years of Experience</h5>
                                        <p class="text-gray-900">
                                            {{ $artisan->artisanProfile && $artisan->artisanProfile->years_experience ? $artisan->artisanProfile->years_experience : 'Not specified' }}
                                        </p>
                                    </div>

                                    <div>
                                        <h5 class="text-sm font-medium text-gray-700">Service Radius</h5>
                                        <p class="text-gray-900">
                                            {{ $artisan->artisanProfile && $artisan->artisanProfile->service_radius ? $artisan->artisanProfile->service_radius . ' km' : 'Not specified' }}
                                        </p>
                                    </div>

                                    <div>
                                        <h5 class="text-sm font-medium text-gray-700">Categories</h5>
                                        <div class="flex flex-wrap">
                                            @if (
                                                $artisan->artisanProfile &&
                                                    isset($artisan->artisanProfile->categories) &&
                                                    $artisan->artisanProfile->categories->count() > 0)
                                                @foreach ($artisan->artisanProfile->categories as $category)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1 mb-1">
                                                        {{ $category->name }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <p class="text-gray-500">No categories assigned</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if ($artisan->artisanProfile)
                                    <div class="border-t border-gray-200 pt-4">
                                        <h5 class="text-sm font-medium text-gray-700 mb-2">Bio</h5>
                                        <p class="text-gray-900">{{ $artisan->artisanProfile->bio ?? 'No bio provided.' }}
                                        </p>
                                    </div>

                                    @if (isset($artisan->artisanProfile->skills) &&
                                            is_array($artisan->artisanProfile->skills) &&
                                            count($artisan->artisanProfile->skills) > 0)
                                        <div class="border-t border-gray-200 pt-4 mt-4">
                                            <h5 class="text-sm font-medium text-gray-700 mb-2">Skills</h5>
                                            <div class="flex flex-wrap">
                                                @foreach ($artisan->artisanProfile->skills as $skill)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-1 mb-1">
                                                        {{ $skill }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            <!-- Services -->
                            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Services
                                        ({{ $artisan->artisanProfile && isset($artisan->artisanProfile->services) ? $artisan->artisanProfile->services->count() : 0 }})
                                    </h4>
                                    <a href="{{ route('admin.artisans.services', $artisan->id) }}"
                                        class="text-sm text-blue-600 hover:text-blue-900">View All</a>
                                </div>

                                @if (
                                    $artisan->artisanProfile &&
                                        isset($artisan->artisanProfile->services) &&
                                        $artisan->artisanProfile->services->count() > 0)
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Service Name</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Price</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Duration</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($artisan->artisanProfile->services->take(5) as $service)
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            {{ $service->name }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ number_format($service->price, 2) }} MAD</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $service->duration }} minutes</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            @if ($service->is_active)
                                                                <span
                                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                                            @else
                                                                <span
                                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-gray-500 text-center py-4">No services available</p>
                                @endif
                            </div>

                            <!-- Bookings -->
                            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Recent Bookings
                                        ({{ $artisan->artisanProfile && isset($artisan->artisanProfile->bookings) ? $artisan->artisanProfile->bookings->count() : 0 }})
                                    </h4>
                                </div>

                                @if (
                                    $artisan->artisanProfile &&
                                        isset($artisan->artisanProfile->bookings) &&
                                        $artisan->artisanProfile->bookings->count() > 0)
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
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($artisan->artisanProfile->bookings->take(5) as $booking)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                            {{ $booking->client->name ?? 'Client #' . $booking->client_profile_id }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $booking->service->name ?? 'Unknown Service' }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            @if ($booking->booking_date)
                                                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y H:i') }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            @php
                                                                $statusClass =
                                                                    [
                                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                                        'confirmed' => 'bg-blue-100 text-blue-800',
                                                                        'completed' => 'bg-green-100 text-green-800',
                                                                        'cancelled' => 'bg-red-100 text-red-800',
                                                                    ][$booking->status] ?? 'bg-gray-100 text-gray-800';
                                                            @endphp
                                                            <span
                                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                                {{ ucfirst($booking->status) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-gray-500 text-center py-4">No bookings available</p>
                                @endif
                            </div>

                            <!-- Reviews -->
                            <div class="bg-white rounded-lg shadow-sm p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Reviews
                                        ({{ $artisan->artisanProfile && isset($artisan->artisanProfile->reviews) ? $artisan->artisanProfile->reviews->count() : 0 }})
                                    </h4>
                                </div>

                                @if (
                                    $artisan->artisanProfile &&
                                        isset($artisan->artisanProfile->reviews) &&
                                        $artisan->artisanProfile->reviews->count() > 0)
                                    <div class="space-y-4">
                                        @foreach ($artisan->artisanProfile->reviews->take(3) as $review)
                                            <div class="border-b border-gray-100 pb-4">
                                                <div class="flex justify-between">
                                                    <div class="flex items-center">
                                                        <div class="flex items-center">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $review->rating)
                                                                    <svg class="w-4 h-4 text-yellow-400 fill-current"
                                                                        viewBox="0 0 24 24">
                                                                        <path
                                                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                                        </path>
                                                                    </svg>
                                                                @else
                                                                    <svg class="w-4 h-4 text-gray-300 fill-current"
                                                                        viewBox="0 0 24 24">
                                                                        <path
                                                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z">
                                                                        </path>
                                                                    </svg>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <span
                                                            class="ml-2 text-sm text-gray-600">{{ $review->created_at->format('M d, Y') }}</span>
                                                    </div>
                                                </div>
                                                <p class="mt-2 text-sm text-gray-700">{{ $review->comment }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 text-center py-4">No reviews available</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 border-t border-gray-200 pt-6 flex flex-wrap justify-between">
                        <div>
                            <a href="{{ route('admin.artisans.services', $artisan->id) }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 mr-2">
                                <i class="fas fa-list mr-1"></i> View Services
                            </a>

                            @if ($artisan->artisanProfile)
                                @php
                                    $statusField = $artisan->artisanProfile->getAttributes();
                                    $status = isset($statusField['status']) ? $statusField['status'] : 'pending';
                                @endphp

                                @if ($status === 'pending')
                                    <form method="POST" action="{{ route('admin.artisans.approve', $artisan->id) }}"
                                        class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 mr-2">
                                            <i class="fas fa-check mr-1"></i> Approve
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.artisans.reject', $artisan->id) }}"
                                        class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                            <i class="fas fa-times mr-1"></i> Reject
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>

                        <div>
                            <a href="{{ route('admin.artisans.index') }}"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                                <i class="fas fa-arrow-left mr-1"></i> Back to Artisans
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
