@extends('layouts.client')

@section('title', $category)

@section('content')
    <div class="container mx-auto py-4 px-4">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="flex py-2 px-3 bg-gray-100 rounded">
                <li><a href="{{ route('client.store.index') }}" class="text-blue-600 hover:text-blue-800">Store</a></li>
                <li class="mx-2">/</li>
                <li class="text-gray-700" aria-current="page">{{ $category }}</li>
            </ol>
        </nav>

        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-semibold mb-0">{{ $category }}</h1>
                <p class="text-gray-600">Browse rewards in this category</p>
            </div>
            <div>
                <div class="bg-blue-600 text-white px-3 py-2 rounded font-bold">
                    <i class="fas fa-coins mr-1"></i> Your Points: {{ number_format($points) }}
                </div>
            </div>
        </div>

        @if ($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($products as $product)
                    <div class="mb-4">
                        <div class="bg-white rounded-lg shadow h-full flex flex-col">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                    class="w-full h-48 object-cover rounded-t-lg"
                                    alt="{{ $product->name }}">
                            @else
                                <div class="bg-gray-100 text-center py-12 rounded-t-lg">
                                    <i class="fas fa-gift text-gray-500 text-4xl"></i>
                                </div>
                            @endif
                            <div class="p-4 flex flex-col flex-grow">
                                <h5 class="text-lg font-medium">{{ $product->name }}</h5>
                                <p class="text-gray-600 mb-4 flex-grow">{{ \Str::limit($product->description, 100) }}</p>
                                <div class="mt-auto">
                                    <div class="flex justify-between items-center">
                                        <span class="font-bold text-blue-600">{{ number_format($product->points_cost) }} points</span>
                                        <a href="{{ route('client.store.product', $product->id) }}"
                                            class="px-3 py-1 border border-blue-600 text-blue-600 rounded hover:bg-blue-600 hover:text-white text-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($products->hasPages())
                <div class="flex justify-center mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded">
                <i class="fas fa-info-circle mr-2"></i> No products available in this category yet. Check back soon!
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('client.store.index') }}" class="px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-600 hover:text-white">
                <i class="fas fa-arrow-left mr-1"></i> Back to Store
            </a>
            <a href="{{ route('client.store.all-products') }}" class="px-4 py-2 border border-gray-600 text-gray-600 rounded hover:bg-gray-600 hover:text-white ml-2">
                <i class="fas fa-th-large mr-1"></i> View All Products
            </a>
        </div>
    </div>
@endsection
