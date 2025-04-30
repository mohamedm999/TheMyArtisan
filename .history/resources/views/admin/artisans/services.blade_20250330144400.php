@extends('layouts.admin')

@section('title', 'Artisan Services')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Services for {{ $artisan->firstname }} {{ $artisan->lastname }}</h2>
                    <a href="{{ route('admin.artisans.show', $artisan->id) }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Artisan Details
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Artisan Summary -->
                    <div class="flex items-center mb-6 pb-6 border-b border-gray-200">
                        <div class="flex-shrink-0 h-16 w-16 rounded-full overflow-hidden bg-gray-100 mr-4">
                            @if ($artisan->artisanProfile && $artisan->artisanProfile->profile_photo)
                                <img src="{{ Storage::url($artisan->artisanProfile->profile_photo) }}" alt="{{ $artisan->firstname }}" class="h-full w-full object-cover">
                            @else
                                <div class="h-16 w-16 bg-blue-100 text-blue-800 flex items-center justify-center rounded-full">
                                    <span class="text-xl font-bold">{{ substr($artisan->firstname, 0, 1) }}{{ substr($artisan->lastname, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $artisan->firstname }} {{ $artisan->lastname }}</h3>
                            <p class="text-sm text-gray-500">{{ $artisan->email }}</p>
                            <div class="mt-1 flex items-center">
                                @if ($artisan->artisanProfile)
                                    @php
                                        $statusField = $artisan->artisanProfile->getAttributes();
                                        $status = isset($statusField['status']) ? $statusField['status'] : 'pending';
                                    @endphp
                                    @if ($status === 'approved')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    @elseif($status === 'rejected')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @endif
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        No Profile
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Services List -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Services Offered</h3>
                            <span class="text-sm text-gray-500">
                                Total: {{ $artisan->artisanProfile && isset($artisan->artisanProfile->services) ? $artisan->artisanProfile->services->count() : 0 }} services
                            </span>
                        </div>

                        @if ($artisan->artisanProfile && isset($artisan->artisanProfile->services) && $artisan->artisanProfile->services->count() > 0)
                            <div class="overflow-x-auto bg-white rounded-lg shadow">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Service Name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Category
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Price
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Duration
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($artisan->artisanProfile->services as $service)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10 rounded-md overflow-hidden bg-gray-100">
                                                            @if ($service->image)
                                                                <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}" class="h-10 w-10 object-cover">
                                                            @else
                                                                <div class="h-10 w-10 bg-blue-50 text-blue-600 flex items-center justify-center">
                                                                    <i class="fas fa-concierge-bell"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $service->name }}
                                                            </div>
                                                            <div class="text-xs text-gray-500 line-clamp-1">
                                                                {{ Str::limit($service->description, 50) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($service->category)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ $service->category->name }}
                                                        </span>
                                                    @else
                                                        <span class="text-xs text-gray-500">No category</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ number_format($service->price, 2) }} MAD
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $service->duration }} minutes
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($service->is_active)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Inactive
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button type="button" onclick="showServiceDetails('{{ $service->id }}')" class="text-blue-600 hover:text-blue-900 mr-3">
                                                        <i class="fas fa-eye"></i> View
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-lg p-6 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="mt-4 text-gray-500">This artisan has not listed any services yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Service Bookings Summary -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Service Booking Summary</h3>
                        </div>

                        @if ($artisan->artisanProfile && isset($artisan->artisanProfile->services) && $artisan->artisanProfile->services->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($artisan->artisanProfile->services as $service)
                                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                        <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                {{ $service->name }}
                                            </h3>
                                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                                {{ number_format($service->price, 2) }} MAD | {{ $service->duration }} minutes
                                            </p>
                                        </div>
                                        <div class="px-4 py-5 sm:p-6">
                                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Total Bookings
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        {{ $service->bookings ? $service->bookings->count() : 0 }}
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Reviews
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        {{ $service->reviews ? $service->reviews->count() : 0 }}
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Category
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        {{ $service->category ? $service->category->name : 'No Category' }}
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-lg p-6 text-center">
                                <p class="text-gray-500">No services available to generate booking summary.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Navigation buttons -->
            <div class="mt-6 flex justify-between">
                <a href="{{ route('admin.artisans.show', $artisan->id) }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Artisan Details
                </a>
                <a href="{{ route('admin.artisans.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    <i class="fas fa-list mr-1"></i> All Artisans
                </a>
            </div>
        </div>
    </div>

    <!-- Service Details Modal (can be implemented with JavaScript) -->
    <div id="service-details-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden flex items-center justify-center" style="z-index: 50;">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl max-w-2xl w-full">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-service-name">Service Name</h3>
                <button type="button" onclick="hideServiceDetails()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-4 py-5 sm:p-6" id="modal-service-details">
                <!-- Details will be loaded here -->
            </div>
            <div class="px-4 py-3 sm:px-6 bg-gray-50 border-t border-gray-200 text-right">
                <button type="button" onclick="hideServiceDetails()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none">
                    Close
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Simple modal functionality for service details
    function showServiceDetails(serviceId) {
        // In a real application, you might want to fetch service details via AJAX
        // For now, we'll just show the modal with placeholder content
        document.getElementById('modal-service-name').innerText = 'Service #' + serviceId;
        document.getElementById('modal-service-details').innerHTML = `
            <p class="text-center text-gray-500">Loading service details...</p>
        `;
        document.getElementById('service-details-modal').classList.remove('hidden');
    }

    function hideServiceDetails() {
        document.getElementById('service-details-modal').classList.add('hidden');
    }
</script>
@endsection
