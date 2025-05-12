@extends('layouts.client')

@section('title', 'Rewards Store')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-lg mb-8 overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between p-6 md:p-8">
                <div class="text-white mb-6 md:mb-0">
                    <h1 class="text-3xl font-bold mb-2">Rewards Store</h1>
                    <p class="text-blue-100 text-lg">Redeem your points for exclusive rewards and experiences</p>
                    <a href="{{ route('client.store.all-products') }}"
                       class="mt-4 inline-flex items-center px-5 py-2.5 bg-white text-blue-700 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                        Browse All Rewards
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <div class="bg-white/15 backdrop-blur-sm rounded-xl border border-white/20 p-6 text-center">
                    <p class="text-blue-100 mb-1">Your Balance</p>
                    <div class="flex items-center justify-center">
                        <i class="fas fa-coins text-yellow-300 text-2xl mr-2"></i>
                        <span class="text-white text-3xl font-bold">{{ number_format($points) }}</span>
                    </div>
                    <p class="text-blue-100 mt-2 text-sm">Available Points</p>
                </div>
            </div>
            <!-- Wave Divider -->
            <div class="text-white/10">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" fill="currentColor">
                    <path d="M0,96L80,101.3C160,107,320,117,480,112C640,107,800,85,960,74.7C1120,64,1280,64,1360,64L1440,64L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
                </svg>
            </div>
        </div>

        <!-- Featured Products Section -->
        @if ($featuredProducts->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-star mr-2"></i> Featured Rewards
                        </h2>
                        <a href="{{ route('client.store.featured') }}" class="text-blue-100 hover:text-white text-sm font-medium">
                            View all featured <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($featuredProducts as $product)
                            <div class="group">
                                <div class="h-full bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md hover:border-blue-200">
                                    <div class="relative">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-48 object-cover transition-transform group-hover:scale-105"
                                                alt="{{ $product->name }}">
                                        @else
                                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 text-center py-16">
                                                <i class="fas fa-gift text-4xl text-blue-300"></i>
                                            </div>
                                        @endif
                                        <!-- Featured badge -->
                                        <div class="absolute top-3 left-3">
                                            <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full flex items-center">
                                                <i class="fas fa-star mr-1 text-yellow-200"></i> Featured
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">{{ $product->name }}</h3>
                                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ \Str::limit($product->description, 80) }}</p>
                                        <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                                            <span class="font-bold text-blue-600">{{ number_format($product->points_cost) }} <span class="text-xs">points</span></span>
                                            <a href="{{ route('client.store.product', $product->id) }}"
                                                class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                                View Details
                                            </a>
                                        </div>
                                        <!-- Affordability indicator -->
                                        @if($points >= $product->points_cost)
                                            <div class="mt-2 text-green-600 text-xs font-medium">
                                                <i class="fas fa-check-circle mr-1"></i> You can afford this reward
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
            </div>
        @endif

        <!-- Categories Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-2xl font-bold text-gray-800">Browse Categories</h2>
                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View all categories <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($categories as $category)
                    <div class="group">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-md hover:border-blue-200">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-full p-4 mr-4 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 mb-1">{{ $category }}</h3>
                                        <a href="{{ route('client.store.category', $category) }}"
                                            class="text-blue-600 group-hover:text-blue-800 text-sm font-medium inline-flex items-center">
                                            Browse Products
                                            <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition-transform"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-6 rounded-lg flex items-start">
                            <i class="fas fa-info-circle mt-1 mr-3 text-blue-500"></i>
                            <div>
                                <h4 class="font-bold mb-1">No Categories Available</h4>
                                <p>Our team is working on adding new reward categories. Please check back soon!</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Links Section (New) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <div class="bg-gradient-to-br from-purple-600 to-indigo-700 rounded-xl shadow-md text-white p-6 flex items-center">
                <div class="mr-5">
                    <div class="bg-white/20 rounded-full p-4">
                        <i class="fas fa-trophy text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-xl mb-1">Earn More Points</h3>
                    <p class="text-purple-100 mb-3">Complete challenges and tasks to boost your points balance</p>
                    <a href="#" class="inline-flex items-center bg-white text-purple-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-purple-50 transition-colors">
                        View Challenges <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl shadow-md text-white p-6 flex items-center">
                <div class="mr-5">
                    <div class="bg-white/20 rounded-full p-4">
                        <i class="fas fa-history text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-xl mb-1">Your Reward History</h3>
                    <p class="text-blue-100 mb-3">Check the status of your redeemed rewards and orders</p>
                    <a href="{{ route('client.orders.index') }}" class="inline-flex items-center bg-white text-blue-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-50 transition-colors">
                        View History <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- How It Works Section (Improved) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800">How It Works</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center relative">
                        <div class="rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-4 w-16 h-16">
                            <i class="fas fa-search text-xl"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2">1. Browse Rewards</h3>
                        <p class="text-gray-600">Explore our collection of exclusive rewards available for redemption.</p>

                        <!-- Connector (visible on md screens and up) -->
                        <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-blue-100 transform -translate-x-4">
                            <div class="absolute right-0 top-1/2 transform -translate-y-1/2 -translate-x-1/2 w-3 h-3 rotate-45 bg-blue-100"></div>
                        </div>
                    </div>
                    <div class="text-center relative">
                        <div class="rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-4 w-16 h-16">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2">2. Redeem with Points</h3>
                        <p class="text-gray-600">Use your earned points to purchase rewards you love.</p>

                        <!-- Connector (visible on md screens and up) -->
                        <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-blue-100 transform -translate-x-4">
                            <div class="absolute right-0 top-1/2 transform -translate-y-1/2 -translate-x-1/2 w-3 h-3 rotate-45 bg-blue-100"></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-4 w-16 h-16">
                            <i class="fas fa-gift text-xl"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2">3. Enjoy Your Reward</h3>
                        <p class="text-gray-600">We'll process your order and deliver your reward quickly.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Arrival Teaser (New) -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-xl shadow-md text-white p-6 mb-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <span class="inline-block bg-yellow-500 text-black text-xs font-bold px-3 py-1 rounded-full mb-3">NEW ARRIVALS</span>
                    <h3 class="text-2xl font-bold mb-2">Just Added: Limited Edition Rewards</h3>
                    <p class="text-gray-300 mb-4">Check out our newest exclusive rewards before they're gone!</p>
                    <a href="#" class="inline-flex items-center bg-white text-gray-900 px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors">
                        Explore New Arrivals <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20 text-center">
                    <span class="text-xs text-gray-300 block mb-1">LIMITED TIME</span>
                    <div class="grid grid-cols-4 gap-2 text-center">
                        <div class="bg-white/10 rounded px-2 py-1">
                            <span class="block text-xl font-bold">12</span>
                            <span class="text-xs text-gray-300">Days</span>
                        </div>
                        <div class="bg-white/10 rounded px-2 py-1">
                            <span class="block text-xl font-bold">06</span>
                            <span class="text-xs text-gray-300">Hours</span>
                        </div>
                        <div class="bg-white/10 rounded px-2 py-1">
                            <span class="block text-xl font-bold">32</span>
                            <span class="text-xs text-gray-300">Mins</span>
                        </div>
                        <div class="bg-white/10 rounded px-2 py-1">
                            <span class="block text-xl font-bold">45</span>
                            <span class="text-xs text-gray-300">Secs</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section (New) -->
        <div class="text-center bg-blue-50 rounded-xl p-8 border border-blue-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-3">Ready to Redeem Your Rewards?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-6">Browse our complete collection of rewards and find something perfect for you.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('client.store.all-products') }}"
                   class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    View All Rewards
                </a>
                <a href="{{ route('client.orders.index') }}"
                   class="px-6 py-3 border border-gray-300 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    <i class="fas fa-history mr-2"></i> Your Orders
                </a>
            </div>
        </div>
    </div>
@endsection
