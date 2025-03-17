@extends('layouts.artisan')

@section('title', 'Artisan Services')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-amber-800">My Services</h1>
                        <a href="{{ route('artisan.services.create') }}" 
                           class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700">
                            <i class="fas fa-plus mr-2"></i>Add New Service
                        </a>
                    </div>

                    @if(count($services) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($services as $service)
                                <div class="bg-white border border-gray-200 rounded-lg shadow overflow-hidden">
                                    <div class="h-48 overflow-hidden">
                                        @if($service->image)
                                            <img src="{{ asset('storage/' . $service->image) }}" 
                                                 alt="{{ $service->name }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-amber-200 flex items-center justify-center">
                                                <span class="text-2xl font-semibold text-amber-800">
                                                    {{ strtoupper(substr($service->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h2 class="text-xl font-medium text-gray-900 mb-2">{{ $service->name }}</h2>
                                        <p class="text-gray-700 mb-3 line-clamp-2">{{ $service->description }}</p>
                                        <div class="flex justify-between items-center">
                                            <span class="text-amber-700 font-bold">€{{ number_format($service->price, 2) }}</span>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('artisan.services.edit', $service->id) }}" 
                                                   class="text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('artisan.services.destroy', $service->id) }}" method="POST" 
                                                      onsubmit="return confirm('Are you sure you want to delete this service?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-4">You haven't added any services yet.</p>
                            <a href="{{ route('artisan.services.create') }}" 
                               class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700">
                                <i class="fas fa-plus mr-2"></i>Add Your First Service
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
