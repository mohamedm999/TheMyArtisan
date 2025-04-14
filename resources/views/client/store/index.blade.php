@extends('layouts.client')

@section('title', 'Rewards Store')

@section('content')
    <div class="container mx-auto px-4 py-4">
        <div class="flex flex-col md:flex-row items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-semibold mb-0">Rewards Store</h1>
                <p class="text-gray-500">Redeem your points for exclusive rewards</p>
            </div>
            <div>
                <div class="bg-blue-600 text-white rounded-md p-2 font-bold">
                    <i class="fas fa-coins mr-1"></i> Your Points: {{ number_format($points) }}
                </div>
            </div>
        </div>

        <!-- Featured Products Section -->
        @if ($featuredProducts->count() > 0)
            <div class="bg-white rounded-lg shadow mb-5">
                <div class="bg-blue-600 text-white px-4 py-3 rounded-t-lg">
                    <h5 class="mb-0 font-medium">Featured Rewards</h5>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach ($featuredProducts as $product)
                            <div class="mb-4">
                                <div class="h-full bg-white border-0 rounded-lg shadow">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-44 object-cover rounded-t-lg"
                                            alt="{{ $product->name }}">
                                    @else
                                        <div class="bg-gray-100 text-center py-5">
                                            <i class="fas fa-gift text-3xl text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="p-4">
                                        <h5 class="font-medium">{{ $product->name }}</h5>
                                        <p class="text-sm text-gray-500 mb-3">
                                            {{ \Str::limit($product->description, 80) }}</p>
                                        <div class="flex justify-between items-center">
                                            <span class="font-bold text-blue-600">{{ number_format($product->points_cost) }} points</span>
                                            <a href="{{ route('client.store.product', $product->id) }}"
                                                class="px-3 py-1 text-sm border border-blue-600 text-blue-600 rounded hover:bg-blue-600 hover:text-white transition-colors">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Categories Section -->
        <div class="mb-5">
            <div class="mb-4">
                <h2 class="text-xl font-medium">Browse Categories</h2>
                <hr class="my-2">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @forelse($categories as $category)
                    <div class="mb-4">
                        <div class="bg-white rounded-lg shadow">
                            <div class="p-4">
                                <div class="flex items-center">
                                    <div class="bg-blue-600 text-white rounded-full p-3 mr-3">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $category }}</h5>
                                        <a href="{{ route('client.store.category', $category) }}"
                                            class="text-blue-600 text-sm hover:underline">
                                            Browse Products <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3">
                        <div class="bg-blue-100 text-blue-700 p-4 rounded-lg">
                            No categories available yet. Check back soon for more rewards!
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- All Products Button -->
        <div class="text-center mb-5">
            <a href="{{ route('client.store.all-products') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition-colors">
                View All Rewards
            </a>
        </div>

        <!-- How It Works Section -->
        <div class="bg-white rounded-lg shadow mb-4">
            <div class="bg-gray-100 px-4 py-3 rounded-t-lg">
                <h5 class="mb-0 font-medium">How It Works</h5>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center mb-3 md:mb-0">
                        <div class="rounded-full bg-blue-600 text-white flex items-center justify-center mx-auto mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-search text-lg"></i>
                        </div>
                        <h5 class="font-medium">1. Browse Rewards</h5>
                        <p class="text-sm text-gray-500">Explore our collection of exclusive rewards available for redemption.</p>
                    </div>
                    <div class="text-center mb-3 md:mb-0">
                        <div class="rounded-full bg-blue-600 text-white flex items-center justify-center mx-auto mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-shopping-cart text-lg"></i>
                        </div>
                        <h5 class="font-medium">2. Redeem with Points</h5>
                        <p class="text-sm text-gray-500">Use your earned points to purchase rewards you love.</p>
                    </div>
                    <div class="text-center">
                        <div class="rounded-full bg-blue-600 text-white flex items-center justify-center mx-auto mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-gift text-lg"></i>
                        </div>
                        <h5 class="font-medium">3. Enjoy Your Reward</h5>
                        <p class="text-sm text-gray-500">We'll process your order and deliver your reward.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="text-center">
            <a href="{{ route('client.orders.index') }}" class="border border-gray-500 text-gray-700 hover:bg-gray-100 font-medium py-2 px-4 rounded transition-colors inline-flex items-center">
                <i class="fas fa-history mr-1"></i> View Your Orders
            </a>
        </div>
    </div>
@endsection
