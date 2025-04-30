@extends('layouts.client')

@section('title', $product->name)

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="{{ route('client.store.index') }}">Store</a></li>
                @if ($product->category)
                    <li class="breadcrumb-item"><a
                            href="{{ route('client.store.category', $product->category) }}">{{ $product->category }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-9">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-md-5 border-right">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-start"
                                        alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div
                                        class="bg-light text-center py-5 h-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-gift fa-5x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <div class="p-4">
                                    <h1 class="card-title h3 mb-3">{{ $product->name }}</h1>

                                    <div class="d-flex align-items-center mb-3">
                                        <div class="badge badge-primary p-2">
                                            <i class="fas fa-coins mr-1"></i> {{ number_format($product->points_cost) }}
                                            points
                                        </div>
                                        @if ($product->stock !== -1)
                                            <div class="ml-3 {{ $product->stock > 0 ? 'text-success' : 'text-danger' }}">
                                                <i
                                                    class="fas {{ $product->stock > 0 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                                {{ $product->stock > 0 ? 'In Stock (' . $product->stock . ' left)' : 'Out of Stock' }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="card-text">
                                        <p>{{ $product->description }}</p>
                                    </div>

                                    @if ($product->is_available && $product->isInStock())
                                        <hr>

                                        @if (session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        <form action="{{ route('client.store.purchase', $product->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="quantity">Quantity</label>
                                                <input type="number" name="quantity" id="quantity" class="form-control"
                                                    value="1" min="1"
                                                    max="{{ $product->stock == -1 ? 10 : min($product->stock, 10) }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="delivery_details">Delivery Details</label>
                                                <textarea name="delivery_details" id="delivery_details" class="form-control" rows="3"
                                                    placeholder="Enter your shipping address or any special instructions" required></textarea>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <button type="submit" class="btn btn-primary"
                                                        {{ !$canAfford ? 'disabled' : '' }}>
                                                        <i class="fas fa-shopping-cart mr-1"></i> Redeem Now
                                                    </button>
                                                </div>

                                                <div class="text-right">
                                                    <p class="mb-0">Your Balance: <strong>{{ number_format($points) }}
                                                            points</strong></p>
                                                    @if (!$canAfford)
                                                        <small class="text-danger">You don't have enough points</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    @elseif(!$product->is_available || !$product->isInStock())
                                        <div class="alert alert-warning">
                                            This product is currently not available for purchase.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Your Points</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="h3 text-primary font-weight-bold mb-3">
                                {{ number_format($points) }}
                            </div>
                            <a href="{{ route('client.points.index') }}" class="btn btn-sm btn-outline-primary">View Points
                                History</a>
                        </div>
                    </div>
                </div>

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
