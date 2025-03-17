@extends('layouts.artisan')

@section('title', $service->name)

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <a href="{{ route('artisan.services.index') }}" class="text-amber-600 hover:text-amber-800">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Services
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <div class="rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                @if($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}"
                                         alt="{{ $service->name }}"
                                         class="w-full h-80 object-cover">
                                @else
                                    <div class="w-full h-80 bg-amber-100 flex items-center justify-center">
                                        <span class="text-6xl font-bold text-amber-600">
                                            {{ strtoupper(substr($service->name, 0, 2)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Service Details</h3>
                                <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                                    <div>
                                        <p class="text-sm text-gray-500">Price</p>
                                        <p class="font-medium">€{{ number_format($service->price, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Duration</p>
                                        <p class="font-medium">{{ $service->duration }} minutes</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Category</p>
                                        <p class="font-medium">{{ $service->category->name ?? 'Uncategorized' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Status</p>
                                        <p class="font-medium">
                                            @if($service->is_active)
                                                <span class="text-green-600">Active</span>
                                            @else
                                                <span class="text-red-600">Inactive</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex space-x-4">
                                <a href="{{ route('artisan.services.edit', $service->id) }}"
                                   class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    <i class="fas fa-edit mr-2"></i>Edit Service
                                </a>
                                <form action="{{ route('artisan.services.destroy', $service->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                                            onclick="return confirm('Are you sure you want to delete this service?')">
                                        <i class="fas fa-trash mr-2"></i>Delete Service
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $service->name }}</h1>
                            <div class="prose max-w-none mb-8">
                                <p>{{ $service->description }}</p>
                            </div>

                            <!-- Additional service information can go here -->
                            <div class="bg-amber-50 p-6 rounded-lg mt-6">
                                <h3 class="text-lg font-medium text-amber-800 mb-4">Book This Service</h3>
                                <p class="mb-4">Interested in this service? Contact the artisan to schedule an appointment.</p>
                                <a href="{{ route('contact.artisan', $service->artisan_id) }}"
                                   class="px-4 py-2 bg-amber-600 text-white rounded-md block text-center hover:bg-amber-700">
                                    <i class="fas fa-calendar-plus mr-2"></i>Request Booking
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
