@extends('layouts.client')

@section('title', 'Rewards Store')

@section('content')
    <!-- More compact hero/header section with collapsible search -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 relative overflow-hidden">
        <!-- Background decorative elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-2xl -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-400/10 rounded-full blur-2xl translate-y-1/3"></div>
        </div>

        <div class="container mx-auto px-4 py-8 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="text-white mb-6 md:mb-0 animate__animated animate__fadeIn">
                    <h1 class="text-3xl font-bold mb-1">Rewards Store</h1>
                    <p class="text-blue-100">Redeem your points for exclusive rewards</p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('client.store.all-products') }}"
                           class="inline-flex items-center px-4 py-2 bg-white text-blue-700 rounded-lg hover:bg-blue-50 transition-colors font-medium shadow-sm">
                            Browse All Rewards
                            <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                        <a href="{{ route('client.points.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-500/30 text-white rounded-lg hover:bg-blue-500/40 transition-colors backdrop-blur-sm border border-white/10">
                            <i class="fas fa-coins mr-2"></i>
                            Earn Points
                        </a>
                    </div>
                </div>
                <div class="bg-white/15 backdrop-blur-sm rounded-xl border border-white/20 p-4 text-center shadow-lg">
                    <p class="text-blue-100 mb-1 text-sm">Your Balance</p>
                    <div class="flex items-center justify-center">
                        <i class="fas fa-coins text-yellow-300 text-xl mr-2"></i>
                        <span class="text-white text-2xl font-bold">{{ number_format($points) }}</span>
                    </div>
                    <p class="text-blue-100 mt-1 text-xs">Available Points</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50">
        <div class="container mx-auto px-4 py-5">
            <!-- Quick Navigation Tiles -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 -mt-6 mb-6">
                <a href="{{ route('client.store.all-products') }}" class="flex flex-col items-center justify-center bg-white p-3 rounded-xl shadow-sm border border-gray-100 transition-all duration-200 hover:shadow hover:border-blue-200">
                    <div class="bg-blue-100 text-blue-600 p-2.5 rounded-full mb-2">
                        <i class="fas fa-th"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-700">All Rewards</span>
                </a>
                <a href="{{ route('client.store.featured') }}" class="flex flex-col items-center justify-center bg-white p-3 rounded-xl shadow-sm border border-gray-100 transition-all duration-200 hover:shadow hover:border-blue-200">
                    <div class="bg-yellow-100 text-yellow-600 p-2.5 rounded-full mb-2">
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-700">Featured</span>
                </a>
                <a href="{{ route('client.orders.index') }}" class="flex flex-col items-center justify-center bg-white p-3 rounded-xl shadow-sm border border-gray-100 transition-all duration-200 hover:shadow hover:border-blue-200">
                    <div class="bg-green-100 text-green-600 p-2.5 rounded-full mb-2">
                        <i class="fas fa-history"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-700">My Orders</span>
                </a>
                <a href="{{ route('client.points.index') }}" class="flex flex-col items-center justify-center bg-white p-3 rounded-xl shadow-sm border border-gray-100 transition-all duration-200 hover:shadow hover:border-blue-200">
                    <div class="bg-purple-100 text-purple-600 p-2.5 rounded-full mb-2">
                        <i class="fas fa-coins"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-700">Earn Points</span>
                </a>
            </div>

            <!-- Compact Categories Slider -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-bold text-gray-800">Categories</h2>
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                        View all <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
                
                <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide hide-scrollbar snap-x">
                    @forelse($categories as $category)
                        <a href="{{ route('client.store.category', $category) }}" class="flex-shrink-0 snap-start">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-100 transition-all duration-300 hover:shadow hover:border-blue-200 px-5 py-3 flex items-center gap-3 w-[180px]">
                                <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-full p-2.5 flex-shrink-0">
                                    <i class="fas fa-tag text-sm"></i>
                                </div>
                                <div class="truncate">
                                    <h3 class="font-medium text-gray-800 text-sm truncate">{{ $category }}</h3>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="w-full">
                            <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg flex items-start">
                                <i class="fas fa-info-circle mt-1 mr-3"></i>
                                <p class="text-sm">Our team is adding new reward categories soon!</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Featured Products Section - Modernized -->
            @if ($featuredProducts->count() > 0)
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-2"></i> Featured Rewards
                        </h2>
                        <a href="{{ route('client.store.featured') }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                            View all <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach ($featuredProducts as $product)
                            <div class="group">
                                <div class="h-full bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md hover:border-blue-200">
                                    <div class="relative">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-40 object-cover transition-transform group-hover:scale-105"
                                                alt="{{ $product->name }}">
                                        @else
                                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 h-40 flex items-center justify-center">
                                                <i class="fas fa-gift text-4xl text-blue-300"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="absolute top-2 left-2">
                                            <span class="bg-yellow-500 text-white text-xs font-bold px-2.5 py-1 rounded-full flex items-center">
                                                <i class="fas fa-star mr-1 text-yellow-200 text-xs"></i> Featured
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-bold text-gray-800 mb-1 group-hover:text-blue-600 transition-colors">{{ $product->name }}</h3>
                                        <p class="text-xs text-gray-600 mb-3 line-clamp-2">{{ \Str::limit($product->description, 60) }}</p>
                                        <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                                            <span class="font-bold text-blue-600">{{ number_format($product->points_cost) }} <span class="text-xs">points</span></span>
                                            <a href="{{ route('client.store.product', $product->id) }}"
                                                class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                                View
                                            </a>
                                        </div>
                                        
                                        @if($points >= $product->points_cost)
                                            <div class="mt-2 text-green-600 text-xs font-medium">
                                                <i class="fas fa-check-circle mr-1"></i> You can afford this
                                            </div>
                                        @else
                                            <div class="mt-2 text-gray-500 text-xs">
                                                <i class="fas fa-info-circle mr-1"></i> Need {{ number_format($product->points_cost - $points) }} more points
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- New Arrival Teaser - More Compact Design -->
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-xl shadow-sm text-white p-5 mb-8">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-4 md:mb-0">
                        <span class="inline-block bg-yellow-500 text-black text-xs font-bold px-3 py-1 rounded-full">NEW</span>
                        <h3 class="text-xl font-bold mt-2 mb-1">Limited Edition Rewards</h3>
                        <p class="text-gray-300 text-sm mb-3">Get exclusive rewards before they're gone!</p>
                        <a href="#" class="inline-flex items-center bg-white text-gray-900 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors">
                            Explore New Arrivals <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                    
                    <div class="flex gap-2">
                        <div class="bg-white/10 rounded px-3 py-2 text-center">
                            <span class="block text-lg font-bold">12</span>
                            <span class="text-xs text-gray-300">Days</span>
                        </div>
                        <div class="bg-white/10 rounded px-3 py-2 text-center">
                            <span class="block text-lg font-bold">06</span>
                            <span class="text-xs text-gray-300">Hrs</span>
                        </div>
                        <div class="bg-white/10 rounded px-3 py-2 text-center">
                            <span class="block text-lg font-bold">32</span>
                            <span class="text-xs text-gray-300">Min</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links Section - Modernized with better layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="bg-gradient-to-br from-purple-600 to-indigo-700 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-5 flex items-start">
                        <div class="bg-white/20 rounded-full p-3 mr-4 flex-shrink-0">
                            <i class="fas fa-trophy text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-1 text-white">Earn More Points</h3>
                            <p class="text-purple-100 mb-3 text-sm">Complete challenges and tasks to boost your balance</p>
                            <a href="#" class="inline-flex items-center bg-white text-purple-700 px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-purple-50 transition-colors shadow-sm">
                                View Challenges <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-5 flex items-start">
                        <div class="bg-white/20 rounded-full p-3 mr-4 flex-shrink-0">
                            <i class="fas fa-history text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-1 text-white">Your Reward History</h3>
                            <p class="text-blue-100 mb-3 text-sm">Check the status of your redeemed rewards</p>
                            <a href="{{ route('client.orders.index') }}" class="inline-flex items-center bg-white text-blue-700 px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-blue-50 transition-colors shadow-sm">
                                View History <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How It Works Section - Horizontal and compact design -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
                <div class="bg-gray-50 px-5 py-3 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800">How It Works</h2>
                </div>
                <div class="p-5">
                    <div class="flex flex-col md:flex-row justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-4 w-9 h-9 flex-shrink-0">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-800 text-sm">1. Browse Rewards</h3>
                                <p class="text-gray-600 text-xs">Explore our collection of exclusive rewards</p>
                            </div>
                            <div class="hidden md:block ml-5 mr-5 text-blue-200">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                        
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-4 w-9 h-9 flex-shrink-0">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-800 text-sm">2. Redeem with Points</h3>
                                <p class="text-gray-600 text-xs">Use your points to purchase rewards</p>
                            </div>
                            <div class="hidden md:block ml-5 mr-5 text-blue-200">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-4 w-9 h-9 flex-shrink-0">
                                <i class="fas fa-gift"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800 text-sm">3. Enjoy Your Reward</h3>
                                <p class="text-gray-600 text-xs">We'll deliver your reward quickly</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section - Simplified -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-100 text-center">
                <h2 class="text-xl font-bold text-gray-800 mb-2">Ready to Redeem Your Rewards?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto mb-4 text-sm">Browse our complete collection and find something perfect for you.</p>
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('client.store.all-products') }}"
                       class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-sm">
                        View All Rewards
                    </a>
                    <a href="{{ route('client.orders.index') }}"
                       class="px-5 py-2 border border-gray-300 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium shadow-sm">
                        <i class="fas fa-history mr-2"></i> Your Orders
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>

    <!-- Add animate.css for subtle animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
