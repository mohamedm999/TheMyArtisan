@extends('layouts.client')

@section('title', $category)

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light">
            <li class="breadcrumb-item"><a href="{{ route('client.store.index') }}">Store</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category }}</li>
        </ol>
    </nav>

    <div class="row align-items-center mb-4">
        <div class="col">
            <h1 class="h2 mb-0">{{ $category }}</h1>
            <p class="text-muted">Browse rewards in this category</p>
        </div>
        <div class="col-auto">
            <div class="badge badge-primary p-2 font-weight-bold">
                <i class="fas fa-coins mr-1"></i> Your Points: {{ number_format($points) }}
            </div>
        </div>
    </div>

    @if($products->count() > 0)
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card h-100 shadow-sm">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
                @else
                <div class="bg-light text-center py-5">
                    <i class="fas fa-gift fa-3x text-muted"></i>
                </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted mb-4">{{ \Str::limit($product->description, 100) }}</p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold text-primary">{{ number_format($product->points_cost) }} points</span>
                            <a href="{{ route('client.store.product', $product->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($products->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
    @endif

    @else
    <div class="alert alert-info">
        <i class="fas fa-info-circle mr-2"></i> No products available in this category yet. Check back soon!
    </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('client.store.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left mr-1"></i> Back to Store
        </a>
        <a href="{{ route('client.store.all-products') }}" class="btn btn-outline-secondary ml-2">
            <i class="fas fa-th-large mr-1"></i> View All Products
        </a>
    </div>
</div>
@endsection