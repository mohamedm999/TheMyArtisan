@extends('layouts.client')

@section('title', 'All Rewards')

@section('content')
    <div class="container mx-auto px-4 py-4">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="flex py-2 px-4 bg-gray-100 rounded">
                <li class="mr-2"><a href="{{ route('client.store.index') }}" class="text-blue-500 hover:underline">Store</a></li>
                <li class="before:content-['/'] before:mx-2 text-gray-600" aria-current="page">All Rewards</li>
            </ol>
        </nav>

        <div class="flex flex-wrap items-center mb-4">
            <div class="flex-grow">
                <h1 class="text-2xl font-bold mb-0">All Rewards</h1>
                <p class="text-gray-500">Browse our complete collection of rewards</p>
            </div>
            <div class="flex-none">
                <div class="bg-blue-500 text-white p-2 rounded font-bold">
                    <i class="fas fa-coins mr-1"></i> Your Points: {{ number_format($points) }}
                </div>
            </div>
        </div>

        @if ($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($products as $product)
                    <div class="mb-4">
                        <div class="h-full bg-white rounded shadow-sm overflow-hidden">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-[180px] object-cover"
                                    alt="{{ $product->name }}">
                            @else
                                <div class="bg-gray-100 text-center py-8">
                                    <i class="fas fa-gift text-4xl text-gray-400"></i>
                                </div>
                            @endif
                            <div class="p-4 flex flex-col h-full">
                                <h5 class="font-bold text-lg">{{ $product->name }}</h5>
                                @if ($product->category)
                                    <div class="mb-2">
                                        <span class="bg-gray-200 text-gray-700 px-2 py-1
                                    </div>
                                @endif
                                <p class="card-text text-muted mb-4">{{ \Str::limit($product->description, 80) }}</p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span
                                            class="font-weight-bold text-primary">{{ number_format($product->points_cost) }}
                                            points</span>
                                        <a href="{{ route('client.store.product', $product->id) }}"
                                            class="btn btn-sm btn-outline-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($products->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i> No rewards are currently available. Check back soon!
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('client.store.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left mr-1"></i> Back to Store
            </a>
        </div>
    </div>
@endsection
