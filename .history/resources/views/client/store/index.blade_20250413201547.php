@extends('layouts.client')

@section('title', 'Rewards Store')

@section('content')
<div class="container py-4">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h1 class="h2 mb-0">Rewards Store</h1>
            <p class="text-muted">Redeem your points for exclusive rewards</p>
        </div>
        <div class="col-auto">
            <div class="badge badge-primary p-2 font-weight-bold">
                <i class="fas fa-coins mr-1"></i> Your Points: {{ number_format($points) }}
            </div>
        </div>
    </div>

    <!-- Featured Products Section -->
    @if($featuredProducts->count() > 0)
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Featured Rewards</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($featuredProducts as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
                        @else
                        <div class="bg-light text-center py-5">
                            <i class="fas fa-gift fa-3x text-muted"></i>
                        </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text small text-muted mb-3">{{ \Str::limit($product->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold text-primary">{{ number_format($product->points_cost) }} points</span>
                                <a href="{{ route('client.store.product', $product->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
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
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="h4">Browse Categories</h2>
            <hr>
        </div>
        
        @forelse($categories as $category)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary text-white rounded-circle p-3 mr-3">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $category }}</h5>
                            <a href="{{ route('client.store.category', $category) }}" class="btn btn-sm btn-link p-0">
                                Browse Products <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                No categories available yet. Check back soon for more rewards!
            </div>
        </div>
        @endforelse
    </div>

    <!-- All Products Button -->
    <div class="text-center mb-5">
        <a href="{{ route('client.store.all-products') }}" class="btn btn-primary">
            View All Rewards
        </a>
    </div>

    <!-- How It Works Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">How It Works</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-search fa-lg"></i>
                    </div>
                    <h5>1. Browse Rewards</h5>
                    <p class="text-muted small">Explore our collection of exclusive rewards available for redemption.</p>
                </div>
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                    </div>
                    <h5>2. Redeem with Points</h5>
                    <p class="text-muted small">Use your earned points to purchase rewards you love.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-gift fa-lg"></i>
                    </div>
                    <h5>3. Enjoy Your Reward</h5>
                    <p class="text-muted small">We'll process your order and deliver your reward.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="text-center">
        <a href="{{ route('client.orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-history mr-1"></i> View Your Orders
        </a>
    </div>
</div>
@endsection