@extends('layouts.client')

@section('title', 'Order #' . $order->id)

@section('content')
    <div class="container mx-auto px-4 py-4">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="flex py-2 px-4 bg-gray-100 rounded">
                <li class="mr-2"><a href="{{ route('client.orders.index') }}" class="text-blue-500 hover:text-blue-700">Your Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order #{{ $order->id }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Order Details</h5>
                            <span class="badge badge-light">
                                @if ($order->status == 'pending')
                                    Pending
                                @elseif($order->status == 'completed')
                                    Completed
                                @elseif($order->status == 'cancelled')
                                    Cancelled
                                @elseif($order->status == 'refunded')
                                    Refunded
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6>Order Information</h6>
                                <p class="mb-1"><strong>Order ID:</strong> #{{ $order->id }}</p>
                                <p class="mb-1"><strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}
                                </p>
                                <p class="mb-1"><strong>Status:</strong>
                                    @if ($order->status == 'pending')
                                        <span class="text-warning">Pending</span>
                                    @elseif($order->status == 'completed')
                                        <span class="text-success">Completed</span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="text-danger">Cancelled</span>
                                    @elseif($order->status == 'refunded')
                                        <span class="text-info">Refunded</span>
                                    @endif
                                </p>
                                <p class="mb-1"><strong>Points Spent:</strong> {{ number_format($order->points_spent) }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Delivery Information</h6>
                                <p class="mb-1"><strong>Delivery Details:</strong></p>
                                <p class="mb-3">{{ $order->delivery_details }}</p>

                                @if ($order->tracking_number)
                                    <p class="mb-1"><strong>Tracking Number:</strong> {{ $order->tracking_number }}</p>
                                @endif

                                @if ($order->redeemed_at)
                                    <p class="mb-1"><strong>Redeemed On:</strong>
                                        {{ $order->redeemed_at->format('M d, Y h:i A') }}</p>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <h6>Product Ordered</h6>
                        <div class="row">
                            <div class="col-md-2">
                                @if ($order->product->image)
                                    <img src="{{ asset('storage/' . $order->product->image) }}"
                                        alt="{{ $order->product->name }}" class="img-fluid">
                                @else
                                    <div class="bg-light text-center py-4">
                                        <i class="fas fa-gift fa-2x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-10">
                                <h5>{{ $order->product->name }}</h5>
                                <p class="text-muted">{{ \Str::limit($order->product->description, 150) }}</p>
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0"><strong>Quantity:</strong> {{ $order->quantity }}</p>
                                    <p class="mb-0"><strong>Points:</strong> {{ number_format($order->points_spent) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if ($order->status == 'pending')
                            <div class="alert alert-info mt-4">
                                <i class="fas fa-info-circle mr-1"></i> Your order is being processed. You will be notified
                                when your order is shipped.
                            </div>
                        @endif
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('client.store.product', $order->product->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart mr-1"></i> Purchase Again
                        </a>
                        <a href="{{ route('client.orders.index') }}" class="btn btn-outline-secondary ml-2">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Orders
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Product Price:</span>
                            <span>{{ number_format($order->points_spent / $order->quantity) }} points</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Quantity:</span>
                            <span>{{ $order->quantity }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between font-weight-bold">
                            <span>Total Points:</span>
                            <span>{{ number_format($order->points_spent) }} points</span>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Need Help?</h5>
                    </div>
                    <div class="card-body">
                        <p>If you have any questions about your order, please contact our support team.</p>
                        <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-block">
                            <i class="fas fa-headset mr-1"></i> Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
