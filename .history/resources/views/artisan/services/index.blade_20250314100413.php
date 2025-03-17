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
                    <h1 class="text-2xl font-semibold text-amber-800 mb-6">My Services</h1>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        @foreach($services as $service)
                            <div class="service-item bg-amber-50 p-6 rounded-lg shadow">
                                @if($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-48 object-cover rounded-t-lg">
                                @else
                                    <div class="w-full h-48 bg-amber-200 flex items-center justify-center text-amber-600 rounded-t-lg">
                                        <span class="text-2xl font-semibold">{{ strtoupper(substr($service->name, 0, 2)) }}</span>
                                    </div>
                                @endif
                                <h2 class="text-xl font-medium">{{ $service->name }}</h2>
                                <p class="text-gray-500">{{ $service->description }}</p>
                                <p class="text-gray-500">Price: €{{ $service->price }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
