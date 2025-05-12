@extends('layouts.client')

@section('title', $product->name)

@section('content')
    <div class="container mx-auto px-4 py-4">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="flex py-2 px-3 bg-gray-100 rounded">
                <li class="flex items-center"><a href="{{ route('client.store.index') }}" class="text-blue-600 hover:text-blue-800">Store</a></li>
                <li class="mx-2">/</li>
                @if ($product->category)
                    <li class="flex items-center"><a href="{{ route('client.store.category', $product->category) }}" 
                        class="text-blue-600 hover:text-blue-800">{{ $product->category }}</a></li>
                    <li class="mx-2">/</li>
                @endif
                <li class="flex items-center text-gray-700" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="flex flex-wrap -mx-4">
            <div class="w-full lg:w-3/4 px-4">
                <div class="bg-white rounded-lg shadow mb-4">
                    <div class="p-0">
                        <div class="flex flex-wrap">
                            <div class="w-full md:w-5/12 border-r">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover rounded-tl-lg rounded-bl-lg"
                                        alt="{{ $product->name }}">
                                @else
                                    <div class="bg-gray-100 text-center py-5 h-full flex items-center justify-center">
                                        <i class="fas fa-gift text-5xl text-gray-500"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="w-full md:w-7/12">
                                <div class="p-4">
                                    <h1 class="text-xl font-semibold mb-3">{{ $product->name }}</h1>

                                    <div class="flex items-center mb-3">
                                        <div class="px-2 py-1 bg-blue-600 text-white rounded">
                                            <i class="fas fa-coins mr-1"></i> {{ number_format($product->points_cost) }}
                                            points
                                        </div>
                                        @if ($product->stock !== -1)
                                            <div class="ml-3 {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                <i class="fas {{ $product->stock > 0 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                                {{ $product->stock > 0 ? 'In Stock (' . $product->stock . ' left)' : 'Out of Stock' }}
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <p>{{ $product->description }}</p>
                                    </div>

                                    @if ($product->is_available && $product->isInStock())
                                        <hr class="my-4">

                                        @if (session('error'))
                                            <div class="p-4 bg-red-100 text-red-700 rounded mb-4">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        <form action="{{ route('client.store.purchase', $product->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <label for="quantity" class="block mb-1">Quantity</label>
                                                <input type="number" name="quantity" id="quantity" 
                                                    class="w-full p-2 border border-gray-300 rounded"
                                                    value="1" min="1"
                                                    max="{{ $product->stock == -1 ? 10 : min($product->stock, 10) }}">
                                            </div>

                                            <div class="mb-4">
                                                <label for="delivery_details" class="block mb-1">Delivery Details</label>
                                                <textarea name="delivery_details" id="delivery_details" 
                                                    class="w-full p-2 border border-gray-300 rounded" rows="3"
                                                    placeholder="Enter your shipping address or any special instructions" required></textarea>
                                            </div>

                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <button type="submit" 
                                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                                        {{ !$canAfford ? 'disabled' : '' }}>
                                                        <i class="fas fa-shopping-cart mr-1"></i> Redeem Now
                                                    </button>
                                                </div>

                                                <div class="text-right">
                                                    <p class="mb-0">Your Balance: <strong>{{ number_format($points) }}
                                                            points</strong></p>
                                                    @if (!$canAfford)
                                                        <small class="text-red-600">You don't have enough points</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    @elseif(!$product->is_available || !$product->isInStock())
                                        <div class="p-4 bg-yellow-100 text-yellow-700 rounded mt-4">
                                            This product is currently not available for purchase.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/4 px-4">
                <div class="bg-white rounded-lg shadow mb-4">
                    <div class="px-4 py-3 bg-gray-100 border-b">
                        <h5 class="font-medium">Your Points</h5>
                    </div>
                    <div class="p-4">
                        <div class="text-center">
                            <div class="text-xl font-bold text-blue-600 mb-3">
                                {{ number_format($points) }}
                            </div>
                            <a href="{{ route('client.points.index') }}" 
                               class="px-3 py-1 text-sm border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white rounded">
                               View Points History
                <!-- How to redeem -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">How to Redeem</h5>
                    </div>
                    <div class="card-body">
                        <ol class="pl-3 mb-0">
                            <li class="mb-2">Select your quantity</li>
                            <li class="mb-2">Enter your delivery details</li>
                            <li class="mb-2">Click "Redeem Now"</li>
                            <li>Receive your reward!</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <div class="mt-5">
                <h3 class="h4 mb-4">You might also like</h3>
                <div class="row">
                    @foreach ($relatedProducts as $related)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm">
                                @if ($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" class="card-img-top"
                                        alt="{{ $related->name }}" style="height: 150px; object-fit: cover;">
                                @else
                                    <div class="bg-light text-center p-3">
                                        <i class="fas fa-gift fa-2x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title h6">{{ $related->name }}</h5>
                                    <p class="card-text small text-muted">{{ \Str::limit($related->description, 50) }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <span class="badge badge-primary">{{ number_format($related->points_cost) }}
                                            points</span>
                                        <a href="{{ route('client.store.product', $related->id) }}"
                                            class="btn btn-sm btn-outline-primary">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
