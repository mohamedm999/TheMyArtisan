@extends('layouts.client')

@section('title', 'All Rewards')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Modern Breadcrumb with Animation -->
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
                    <span class="text-gray-700 font-medium" aria-current="page">All Rewards</span>
                </li>
            </ol>
        </nav>

        <!-- Enhanced Header Section with Animation -->
        <div class="flex flex-wrap items-center justify-between mb-8 bg-gradient-to-r from-blue-50 via-indigo-50 to-blue-50 p-8 rounded-2xl shadow-md border border-blue-100 animate__animated animate__fadeInUp">
            <div class="flex-grow">
                <div class="inline-block mb-3 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                    <i class="fas fa-th-large mr-1"></i> Our Collection
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold mb-2 text-gray-800 flex items-center">
                    <span>All Rewards</span>
                    <span class="ml-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text text-2xl">Collection</span>
                </h1>
                <p class="text-gray-600 md:text-lg">Discover and redeem exclusive rewards with your earned points</p>
            </div>
            <div class="flex-none mt-4 md:mt-0">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-4 rounded-xl shadow-md flex items-center transform transition-all hover:scale-105 hover:shadow-lg">
                    <div class="bg-white/20 p-2 mr-3 rounded-lg">
                        <i class="fas fa-coins text-yellow-300 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-blue-100 text-xs">Your Balance</p>
                        <span class="font-bold text-xl">{{ number_format($points) }} Points</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Filter & Sort Controls -->
        <div class="mb-8 bg-white p-5 rounded-xl shadow-sm border border-gray-200 animate__animated animate__fadeIn animate__delay-1s">
            <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" placeholder="Search rewards..."
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-700">
                </div>

                <div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-tag text-gray-400"></i>
                        </div>
                        <select class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white appearance-none text-gray-700">
                            <option value="">All Categories</option>
                            <option value="gift-cards">Gift Cards</option>
                            <option value="merchandise">Merchandise</option>
                            <option value="experiences">Experiences</option>
                            <option value="vouchers">Vouchers</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-sort text-gray-400"></i>
                        </div>
                        <select class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white appearance-none text-gray-700">
                            <option value="newest">Newest First</option>
                            <option value="points-low">Points: Low to High</option>
                            <option value="points-high">Points: High to Low</option>
                            <option value="popular">Most Popular</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Active Filters (optional display) -->
            <div class="flex flex-wrap gap-2 mt-3 pt-3 border-t border-gray-100">
                <span class="text-sm text-gray-500 self-center">Active filters:</span>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full flex items-center">
                    All Products
                    <button type="button" class="ml-1 text-blue-500 hover:text-blue-700">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </span>
            </div>
        </div>

        @if ($products->count() > 0)
            <!-- Product Count & View Toggle -->
            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600 font-medium">Showing <span class="text-blue-600">{{ $products->count() }}</span> of <span class="text-blue-600">{{ $products->total() }}</span> rewards</p>
                <div class="flex gap-2">
                    <button class="p-2 bg-blue-600 text-white rounded-lg" title="Grid view">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button class="p-2 bg-gray-200 text-gray-600 rounded-lg hover:bg-gray-300" title="List view">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>

            <!-- Enhanced Product Grid with Hover Effects -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach ($products as $product)
                    <div class="group animate__animated animate__fadeIn" style="animation-delay: {{ $loop->iteration * 0.05 }}s">
                        <div class="h-full bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl border border-gray-100 hover:border-blue-200 transform hover:-translate-y-1">
                            <div class="relative overflow-hidden">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110"
                                        alt="{{ $product->name }}">
                                @else
                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 h-64 flex items-center justify-center">
                                        <i class="fas fa-gift text-5xl text-blue-300"></i>
                                    </div>
                                @endif

                                <!-- Enhanced Labels -->
                                <div class="absolute top-0 left-0 p-4 flex flex-col items-start gap-2">
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

                                    @if($product->stock > 0 && $product->stock < 5)
                                        <span class="bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full flex items-center">
                                            <i class="fas fa-fire mr-1"></i> Limited
                                        </span>
                                    @endif
                                </div>

                                <!-- Quick Actions Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center p-6">
                                    <a href="{{ route('client.store.product', $product->id) }}"
                                       class="bg-white/90 backdrop-blur-sm text-gray-800 font-medium px-4 py-2.5 rounded-lg hover:bg-white transition-colors inline-flex items-center">
                                        <i class="fas fa-eye mr-2"></i> Quick View
                                    </a>
                                </div>
                            </div>

                            <div class="p-5 flex flex-col flex-grow">
                                <!-- Category Badge -->
                                @if ($product->category)
                                    <div class="mb-2">
                                        <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-xs font-medium inline-flex items-center">
                                            <i class="fas fa-tag mr-1 text-indigo-600"></i>
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

                                <h5 class="font-bold text-xl text-gray-800 mb-2 group-hover:text-blue-600 transition-colors leading-snug">
                                    {{ $product->name }}
                                </h5>

                                <p class="text-gray-600 mb-4 text-sm flex-grow line-clamp-3">
                                    {{ \Str::limit($product->description, 120) }}
                                </p>

                                <div class="mt-auto pt-4 border-t border-gray-100">
                                    <div class="flex justify-between items-center mb-3">
                                        <div>
                                            <span class="font-bold text-xl text-blue-600">{{ number_format($product->points_cost) }}</span>
                                            <span class="text-gray-500 text-sm">points</span>
                                        </div>

                                        <!-- Stock Indicator (if applicable) -->
                                        @if($product->stock !== null && $product->stock !== -1)
                                            <span class="text-xs text-gray-500">
                                                {{ $product->stock }} in stock
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <a href="{{ route('client.store.product', $product->id) }}"
                                           class="flex-1 px-4 py-2.5 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition-all shadow-sm hover:shadow transform hover:-translate-y-0.5 inline-flex items-center justify-center">
                                            <span>View Details</span>
                                            <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                        </a>

                                        <button type="button" class="w-full sm:w-auto px-4 py-2.5 border border-gray-200 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors inline-flex items-center justify-center">
                                            <i class="far fa-bookmark"></i>
                                        </button>
                                    </div>

                                    <!-- Affordability Indicator with Progress Bar -->
                                    @if($points >= $product->points_cost)
                                        <div class="mt-3 text-green-600 text-sm font-medium">
                                            <i class="fas fa-check-circle mr-1"></i> You can redeem this reward
                                        </div>
                                    @else
                                        <div class="mt-3">
                                            <div class="flex justify-between items-center mb-1">
                                                <span class="text-gray-500 text-xs">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    Need {{ number_format($product->points_cost - $points) }} more points
                                                </span>
                                                <span class="text-xs text-blue-600">{{ round(($points / $product->points_cost) * 100) }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ min(100, ($points / $product->points_cost) * 100) }}%"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Enhanced Pagination with Custom Styling -->
            @if ($products->hasPages())
                <div class="flex justify-center my-10">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 inline-flex">
                        {{ $products->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State with Animation -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-10 text-center animate__animated animate__fadeIn">
                <div class="flex flex-col items-center max-w-md mx-auto">
                    <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-gift text-blue-500 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">No Rewards Available Yet</h3>
                    <p class="text-gray-600 mb-6">We're currently curating an exclusive collection of rewards just for you. Check back soon for exciting new offers!</p>
                    <div class="flex flex-wrap gap-3 justify-center">
                        <a href="{{ route('client.store.index') }}"
                           class="inline-flex items-center px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all shadow-sm hover:shadow">
                            <i class="fas fa-store mr-2"></i> Back to Store
                        </a>
                        <button type="button"
                                class="inline-flex items-center px-5 py-3 border border-gray-300 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all">
                            <i class="fas fa-bell mr-2"></i> Notify Me
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Enhanced Bottom Navigation with Card Layout -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-12 mb-6">
            <a href="{{ route('client.store.index') }}"
               class="bg-white border border-blue-200 rounded-xl p-5 flex items-center hover:shadow-md transition-all group">
                <div class="mr-4 bg-blue-100 rounded-lg p-3 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i class="fas fa-arrow-left text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">Back to Store</h3>
                    <p class="text-gray-600 text-sm">Return to the main store page</p>
                </div>
            </a>

            <a href="{{ route('client.orders.index') }}"
               class="bg-white border border-purple-200 rounded-xl p-5 flex items-center hover:shadow-md transition-all group">
                <div class="mr-4 bg-purple-100 rounded-lg p-3 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <i class="fas fa-history text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">Your Orders</h3>
                    <p class="text-gray-600 text-sm">View your redemption history</p>
                </div>
            </a>

            <a href="#"
               class="bg-white border border-green-200 rounded-xl p-5 flex items-center hover:shadow-md transition-all group">
                <div class="mr-4 bg-green-100 rounded-lg p-3 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <i class="fas fa-coins text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 mb-1">Earn More Points</h3>
                    <p class="text-gray-600 text-sm">Learn how to earn additional points</p>
                </div>
            </a>
        </div>

        <!-- Featured Categories Section -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-8 border border-gray-200 mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Explore Categories</h3>
            <div class="flex flex-wrap gap-3">
                <a href="#" class="px-4 py-2 bg-white rounded-lg text-gray-700 shadow-sm hover:bg-blue-600 hover:text-white transition-colors">
                    Gift Cards
                </a>
                <a href="#" class="px-4 py-2 bg-white rounded-lg text-gray-700 shadow-sm hover:bg-blue-600 hover:text-white transition-colors">
                    Merchandise
                </a>
                <a href="#" class="px-4 py-2 bg-white rounded-lg text-gray-700 shadow-sm hover:bg-blue-600 hover:text-white transition-colors">
                    Experiences
                </a>
                <a href="#" class="px-4 py-2 bg-white rounded-lg text-gray-700 shadow-sm hover:bg-blue-600 hover:text-white transition-colors">
                    Vouchers
                </a>
                <a href="#" class="px-4 py-2 bg-white rounded-lg text-gray-700 shadow-sm hover:bg-blue-600 hover:text-white transition-colors">
                    Digital Products
                </a>
            </div>
        </div>

        <!-- Newsletter or Promo Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-8 text-white shadow-lg mb-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h3 class="text-2xl font-bold mb-2">Get Notified About New Rewards</h3>
                    <p class="text-blue-100">Be the first to know when new exciting rewards become available</p>
                </div>
                <div class="flex">
                    <button type="button" class="px-6 py-3 bg-white text-blue-600 rounded-lg font-medium hover:bg-blue-50 transition-colors shadow-sm">
                        Enable Notifications
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
