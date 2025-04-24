@extends('layouts.client')

@section('title', $product->name)

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Modern Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-6 animate__animated animate__fadeIn">
            <ol class="flex items-center py-3 px-5 bg-gradient-to-r from-gray-50 to-white rounded-lg shadow-sm border border-gray-100">
                <li class="flex items-center">
                    <a href="{{ route('client.store.index') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors inline-flex items-center">
                        <i class="fas fa-store mr-2 text-blue-500"></i>
                        <span>Store</span>
                    </a>
                </li>
                <li class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    @if ($product->category)
                        <a href="{{ route('client.store.category', $product->category) }}"
                            class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                            {{ $product->category }}
                        </a>
                    @else
                        <a href="{{ route('client.store.all-products') }}"
                            class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                            All Products
                        </a>
                    @endif
                </li>
                <li class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-gray-700 font-medium" aria-current="page">{{ $product->name }}</span>
                </li>
            </ol>
        </nav>

        <!-- Main Product Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Product Images -->
            <div class="lg:col-span-2 animate__animated animate__fadeIn">
                <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
                    <div class="relative">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                class="w-full h-auto max-h-[500px] object-cover transition-all duration-500"
                                alt="{{ $product->name }}">
                        @else
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 h-[400px] flex items-center justify-center">
                                <i class="fas fa-gift text-7xl text-blue-300"></i>
                            </div>
                        @endif

                        <!-- Status Badges -->
                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            @if($product->is_featured)
                                <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1.5 rounded-full flex items-center">
                                    <i class="fas fa-star mr-1"></i> Featured
                                </span>
                            @endif

                            @if($product->created_at->diffInDays(now()) < 7)
                                <span class="bg-green-500 text-white text-xs font-bold px-3 py-1.5 rounded-full flex items-center">
                                    <i class="fas fa-bolt mr-1"></i> NEW
                                </span>
                            @endif

                            @if($product->stock > 0 && $product->stock < 5 && $product->stock !== -1)
                                <span class="bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full flex items-center">
                                    <i class="fas fa-fire mr-1"></i> Limited Stock
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Description Card -->
                <div class="mt-6 bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-3">Product Details</h2>
                    <div class="prose max-w-none text-gray-700">
                        <p>{{ $product->description }}</p>
                    </div>

                    @if($product->category)
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <div class="flex items-center">
                                <span class="text-gray-600 font-medium mr-2">Category:</span>
                                <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-sm font-medium">
                                    {{ $product->category }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Purchase Panel -->
            <div class="animate__animated animate__fadeIn animate__delay-1s">
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 sticky top-6">
                    <!-- Product Title and Cost -->
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>

                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-coins text-yellow-300 mr-2"></i>
                            <span class="text-xl font-bold">{{ number_format($product->points_cost) }}</span>
                            <span class="ml-1 text-blue-100">points</span>
                        </div>

                        @if ($product->is_available && $product->stock !== 0)
                            <div class="ml-3 text-green-600 flex items-center">
                                <i class="fas fa-check-circle mr-1"></i>
                                <span class="font-medium">Available</span>
                            </div>
                        @else
                            <div class="ml-3 text-red-600 flex items-center">
                                <i class="fas fa-times-circle mr-1"></i>
                                <span class="font-medium">Unavailable</span>
                            </div>
                        @endif
                    </div>

                    <!-- Stock Status -->
                    @if ($product->stock !== -1)
                        <div class="mb-6">
                            @if ($product->stock > 0)
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm text-gray-500">Available Stock</span>
                                    <span class="text-sm font-medium">{{ $product->stock }} remaining</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    @php
                                        // Assuming original stock was higher, for display purposes
                                        $originalStock = max(20, $product->stock + 5);
                                        $percentRemaining = min(100, ($product->stock / $originalStock) * 100);
                                    @endphp
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentRemaining }}%"></div>
                                </div>
                            @else
                                <div class="bg-red-100 border border-red-200 text-red-800 rounded-lg p-3 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <span>Currently out of stock</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Points Balance Card -->
                    <div class="bg-blue-50 rounded-xl p-4 mb-6 border border-blue-100">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Your Balance:</span>
                            <span class="font-bold text-blue-600">{{ number_format($points) }} points</span>
                        </div>

                        @if ($canAfford)
                            <div class="mt-2 text-green-600 text-sm font-medium flex items-center">
                                <i class="fas fa-check-circle mr-1"></i>
                                <span>You can afford this reward</span>
                            </div>
                        @else
                            <div class="mt-2">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-gray-500 text-xs">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        You need {{ number_format($product->points_cost - $points) }} more points
                                    </span>
                                    <span class="text-xs text-blue-600">{{ round(($points / $product->points_cost) * 100) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ min(100, ($points / $product->points_cost) * 100) }}%"></div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-3 text-center">
                            <a href="{{ route('client.points.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center">
                                <i class="fas fa-history mr-1"></i>
                                View Points History
                            </a>
                        </div>
                    </div>

                    <!-- Purchase Form -->
                    @if ($product->is_available && $product->isInStock())
                        @if (session('error'))
                            <div class="p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg mb-4 flex items-start">
                                <i class="fas fa-exclamation-circle mt-0.5 mr-2"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                        @endif

                        <form action="{{ route('client.store.purchase', $product->id) }}" method="POST">
                            @csrf
                            <div class="mb-5">
                                <label for="quantity" class="block mb-2 text-sm font-medium text-gray-700">Quantity</label>
                                <div class="relative flex rounded-md">
                                    <button type="button" onclick="decrementQuantity()" class="px-4 py-2 bg-gray-100 border border-gray-300 text-gray-600 rounded-l-md hover:bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-minus text-sm"></i>
                                    </button>
                                    <input type="number" name="quantity" id="quantity"
                                        class="flex-grow px-4 py-2 border-t border-b border-gray-300 text-center font-medium text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        value="1" min="1"
                                        max="{{ $product->stock == -1 ? 10 : min($product->stock, 10) }}">
                                    <button type="button" onclick="incrementQuantity()" class="px-4 py-2 bg-gray-100 border border-gray-300 text-gray-600 rounded-r-md hover:bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-plus text-sm"></i>
                                    </button>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $product->stock == -1 ? 'Maximum 10 per order' : 'Available: ' . $product->stock }}
                                </p>
                            </div>

                            <div class="mb-5">
                                <label for="delivery_details" class="block mb-2 text-sm font-medium text-gray-700">Delivery Details</label>
                                <textarea name="delivery_details" id="delivery_details"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-gray-700 resize-none"
                                    rows="3" placeholder="Enter your shipping address or any special instructions" required></textarea>
                            </div>

                            <div class="flex flex-col gap-3">
                                <button type="submit"
                                    class="w-full py-3 px-4 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all shadow-sm hover:shadow flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed transform hover:-translate-y-0.5 active:translate-y-0"
                                    {{ !$canAfford ? 'disabled' : '' }}>
                                    <i class="fas fa-shopping-cart mr-2"></i> Redeem Now
                                </button>

                                @if (!$canAfford)
                                    <a href="{{ route('client.points.index') }}" class="w-full py-3 px-4 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-all shadow-sm hover:shadow flex items-center justify-center">
                                        <i class="fas fa-coins mr-2"></i> Earn More Points
                                    </a>
                                @endif
                            </div>
                        </form>
                    @elseif(!$product->is_available || !$product->isInStock())
                        <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-lg flex items-start">
                            <i class="fas fa-exclamation-triangle mt-0.5 mr-2"></i>
                            <div>
                                <span class="font-medium block mb-1">Currently Unavailable</span>
                                <span class="text-sm">This product is currently not available for purchase.</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('client.store.all-products') }}" class="w-full py-3 px-4 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all shadow-sm hover:shadow flex items-center justify-center">
                                <i class="fas fa-arrow-left mr-2"></i> Browse Other Rewards
                            </a>
                        </div>
                    @endif
                </div>

                <!-- How to Redeem Card -->
                <div class="mt-6 bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i> How to Redeem
                    </h3>
                    <ol class="space-y-3">
                        <li class="flex">
                            <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold mr-3">
                                1
                            </div>
                            <div>
                                <span class="text-gray-700">Select your desired quantity</span>
                            </div>
                        </li>
                        <li class="flex">
                            <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold mr-3">
                                2
                            </div>
                            <div>
                                <span class="text-gray-700">Enter your delivery information</span>
                            </div>
                        </li>
                        <li class="flex">
                            <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold mr-3">
                                3
                            </div>
                            <div>
                                <span class="text-gray-700">Click "Redeem Now" to confirm</span>
                            </div>
                        </li>
                        <li class="flex">
                            <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold mr-3">
                                4
                            </div>
                            <div>
                                <span class="text-gray-700">Your reward will be processed and delivered</span>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @if ($relatedProducts->count() > 0)
            <div class="mt-12 animate__animated animate__fadeIn animate__delay-2s">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">You Might Also Like</h2>
                    @if ($product->category)
                        <a href="{{ route('client.store.category', $product->category) }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center font-medium">
                            View all {{ $product->category }}
                            <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $related)
                        <div class="group">
                            <div class="h-full bg-white rounded-xl shadow-sm overflow-hidden flex flex-col transition-all duration-300 hover:shadow-md border border-gray-100 hover:border-blue-200 transform hover:-translate-y-1">
                                <div class="relative overflow-hidden">
                                    @if ($related->image)
                                        <img src="{{ asset('storage/' . $related->image) }}" class="w-full h-48 object-cover transition-transform group-hover:scale-110 duration-700"
                                            alt="{{ $related->name }}">
                                    @else
                                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 h-48 flex items-center justify-center">
                                            <i class="fas fa-gift text-4xl text-blue-300"></i>
                                        </div>
                                    @endif

                                    @if($related->is_featured)
                                        <div class="absolute top-3 left-3">
                                            <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full flex items-center">
                                                <i class="fas fa-star mr-1 text-yellow-200"></i> Featured
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4 flex flex-col flex-grow">
                                    <h5 class="font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">{{ $related->name }}</h5>
                                    <p class="text-gray-600 text-sm mb-4 flex-grow line-clamp-2">{{ \Str::limit($related->description, 60) }}</p>
                                    <div class="mt-auto">
                                        <div class="flex justify-between items-center">
                                            <span class="font-bold text-blue-600">{{ number_format($related->points_cost) }} <span class="text-xs">points</span></span>
                                            <a href="{{ route('client.store.product', $related->id) }}"
                                                class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center">
                                                View
                                                <i class="fas fa-arrow-right ml-1.5 text-xs"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Back to Store Button -->
        <div class="mt-10 text-center animate__animated animate__fadeIn animate__delay-3s">
            <a href="{{ route('client.store.all-products') }}"
              class="inline-flex items-center px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to All Rewards
            </a>
        </div>
    </div>

    <!-- Add JavaScript for quantity controls and animations -->
    <script>
        function incrementQuantity() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.getAttribute('max'));
            const currentValue = parseInt(input.value) || 0;
            if (currentValue < max) {
                input.value = currentValue + 1;
            }
        }

        function decrementQuantity() {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value) || 0;
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
    </script>

    <!-- Add animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
