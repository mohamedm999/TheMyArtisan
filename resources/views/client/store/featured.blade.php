@extends('layouts.client')

@section('title', 'Featured Rewards')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Enhanced Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-6">
            <ol class="flex items-center py-2 px-4 bg-gray-50 rounded-lg shadow-sm">
                <li class="mr-2"><a href="{{ route('client.store.index') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">Store</a></li>
                <li class="before:content-['/'] before:mx-2 text-gray-600 font-medium" aria-current="page">Featured Rewards</li>
            </ol>
        </nav>

        <!-- Improved Header Section -->
        <div class="flex flex-wrap items-center justify-between mb-8 bg-gradient-to-r from-yellow-50 to-amber-50 p-6 rounded-xl shadow-sm">
            <div class="flex-grow">
                <div class="flex items-center mb-1">
                    <i class="fas fa-star text-yellow-500 mr-2"></i>
                    <h1 class="text-3xl font-bold text-gray-800">Featured Rewards</h1>
                </div>
                <p class="text-gray-600">Our handpicked selection of premium rewards and exclusive offers</p>
            </div>
            <div class="flex-none mt-4 md:mt-0">
                <div class="bg-gradient-to-r from-yellow-600 to-amber-600 text-white p-3 rounded-lg shadow-md flex items-center">
                    <i class="fas fa-coins mr-2 text-yellow-300"></i>
                    <span class="font-bold">{{ number_format($points) }} Points</span>
                </div>
            </div>
        </div>

        <!-- Filter & Sort Controls -->
        <div class="mb-6 flex flex-col md:flex-row gap-4">
            <div class="relative flex-grow">
                <input type="text" placeholder="Search featured rewards..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <div class="flex gap-2">
                <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 bg-white">
                    <option value="newest">Newest</option>
                    <option value="points-low">Points: Low to High</option>
                    <option value="points-high">Points: High to Low</option>
                </select>
            </div>
        </div>

        @if ($products->count() > 0)
            <!-- Featured Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="group">
                        <div class="h-full bg-white rounded-xl shadow-sm overflow-hidden flex flex-col transition-all duration-300 hover:shadow-lg border border-gray-100">
                            <div class="relative">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-56 object-cover transition-transform group-hover:scale-105"
                                        alt="{{ $product->name }}">
                                @else
                                    <div class="bg-gradient-to-br from-gray-100 to-gray-200 text-center py-16">
                                        <i class="fas fa-gift text-5xl text-gray-400"></i>
                                    </div>
                                @endif

                                <!-- Featured badge -->
                                <div class="absolute top-0 left-0 w-full h-full">
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full flex items-center">
                                            <i class="fas fa-star mr-1 text-yellow-200"></i> Featured
                                        </span>
                                    </div>
                                </div>

                                <!-- New Tag (conditionally shown) -->
                                @if($product->created_at->diffInDays(now()) < 7)
                                    <span class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">NEW</span>
                                @endif
                            </div>

                            <div class="p-5 flex flex-col flex-grow">
                                <h5 class="font-bold text-lg text-gray-800 mb-2 group-hover:text-yellow-600 transition-colors">{{ $product->name }}</h5>

                                @if ($product->category)
                                    <div class="mb-3">
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">
                                            @if(is_object($product->category))
                                                {{ $product->category->name }}
                                            @elseif(is_array($product->category) && isset($product->category['name']))
                                                {{ $product->category['name'] }}
                                            @else
                                                {{ $product->category }}
                                            @endif
                                        </span>
                                    </div>
                                @endif

                                <p class="text-gray-600 mb-4 text-sm flex-grow">{{ \Str::limit($product->description, 100) }}</p>

                                <div class="mt-auto pt-4 border-t border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <span class="font-bold text-lg text-yellow-600">{{ number_format($product->points_cost) }} <span class="text-sm">points</span></span>
                                        <a href="{{ route('client.store.product', $product->id) }}"
                                            class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors transform hover:-translate-y-1 duration-200 inline-flex items-center">
                                            <span>Details</span>
                                            <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                        </a>
                                    </div>

                                    <!-- Affordability Indicator -->
                                    @if($points >= $product->points_cost)
                                        <div class="mt-3 text-green-600 text-xs font-medium">
                                            <i class="fas fa-check-circle mr-1"></i> You have enough points
                                        </div>
                                    @else
                                        <div class="mt-3 text-gray-500 text-xs">
                                            <i class="fas fa-info-circle mr-1"></i> You need {{ number_format($product->points_cost - $points) }} more points
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Enhanced Pagination -->
            @if ($products->hasPages())
                <div class="flex justify-center mt-8">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-2">
                        {{ $products->links() }}
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8 text-center">
                <div class="flex flex-col items-center">
                    <div class="bg-yellow-100 p-4 rounded-full mb-4">
                        <i class="fas fa-star text-yellow-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">No Featured Rewards Available</h3>
                    <p class="text-gray-600 max-w-md mx-auto mb-4">We're currently selecting new featured rewards. Check back soon for exclusive offers!</p>
                    <a href="{{ route('client.store.index') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                        <i class="fas fa-store mr-2"></i> Back to Store
                    </a>
                </div>
            </div>
        @endif

        <!-- Bottom Navigation with Additional Actions -->
        <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-10">
            <a href="{{ route('client.store.index') }}"
                class="inline-flex items-center px-5 py-2.5 border-2 border-yellow-600 rounded-lg text-yellow-600 hover:bg-yellow-50 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back to Store
            </a>

            <a href="{{ route('client.store.all-products') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-200 transition-colors">
                <i class="fas fa-th-large mr-2"></i> View All Rewards
            </a>

            <a href="{{ route('client.orders.index') }}" class="inline-flex items-center px-5 py-2.5 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                <i class="fas fa-shopping-bag mr-2"></i> My Orders
            </a>
        </div>
    </div>
@endsection
