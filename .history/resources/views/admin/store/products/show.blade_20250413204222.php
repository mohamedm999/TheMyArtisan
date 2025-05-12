@extends('layouts.admin')

@section('title', $product->name)

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Product Details</h1>
        <div>
            <a href="{{ route('admin.store.products.edit', $product->id) }}" class="btn btn-primary shadow-sm mr-2">
                <i class="fas fa-edit fa-sm text-white-50 mr-1"></i> Edit Product
            </a>
            <a href="{{ route('admin.store.products.index') }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Products
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <!-- Product Details Card -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $product->name }}</h6>
                    <div>
                        @if($product->is_featured)
                        <span class="badge badge-warning"><i class="fas fa-star mr-1"></i> Featured</span>
                        @endif
                        @if($product->is_available)
                        <span class="badge badge-success">Available</span>
                        @else
                        <span class="badge badge-secondary">Unavailable</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4 mb-md-0">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                            @else
                            <div class="bg-light text-center py-5 rounded">
                                <i class="fas fa-gift fa-4x text-gray-400"></i>
                                <p class="mt-3 text-muted">No image available</p>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h5>Product Details</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th style="width: 150px;">ID</th>
                                            <td>{{ $product->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $product->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <td>{{ $product->category ?? 'Uncategorized' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Points Cost</th>
                                            <td><strong class="text-primary">{{ number_format($product->points_cost) }}</strong> points</td>
                                        </tr>
                                        <tr>
                                            <th>Stock</th>
                                            <td>
                                                @if($product->stock == -1)
                                                <span class="badge badge-info">Unlimited</span>
                                                @elseif($product->stock > 10)
                                                <span class="badge badge-success">{{ $product->stock }} available</span>
                                                @elseif($product->stock > 0)
                                                <span class="badge badge-warning">{{ $product->stock }} left</span>
                                                @else
                                                <span class="badge badge-danger">Out of stock</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created</th>
                                            <td>{{ $product->created_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Last Updated</th>
                                            <td>{{ $product->updated_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <h5 class="mt-4">Description</h5>
                            <div class="border rounded p-3 bg-light">
                                {{ $product->description }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Order Statistics Card -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Orders</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orderCount }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Points Spent</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPointsSpent) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-coins fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6 class="font-weight-bold">Quick Actions</h6>
                    <div class="row mt-3">
                        <div class="col-md-6 mb-2">
                            <a href="{{ route('admin.store.products.edit', $product->id) }}" class="btn btn-primary btn-sm btn-block">
                                <i class="fas fa-edit mr-1"></i> Edit Product
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <form action="{{ route('admin.store.products.toggleAvailability', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ $product->is_available ? 'btn-warning' : 'btn-success' }} btn-sm btn-block">
                                    @if($product->is_available)
                                    <i class="fas fa-ban mr-1"></i> Make Unavailable
                                    @else
                                    <i class="fas fa-check-circle mr-1"></i> Make Available
                                    @endif
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6 mb-2">
                            <form action="{{ route('admin.store.products.toggleFeatured', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ $product->is_featured ? 'btn-secondary' : 'btn-warning' }} btn-sm btn-block">
                                    @if($product->is_featured)
                                    <i class="fas fa-star mr-1"></i> Unfeature
                                    @else
                                    <i class="fas fa-star mr-1"></i> Make Featured
                                    @endif
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6 mb-2">
                            <form action="{{ route('admin.store.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-block">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($recentOrders->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.store.orders.show', $order->id) }}">#{{ $order->id }}</a>
                                    </td>
                                    <td>{{ $order->user->firstname }} {{ $order->user->lastname }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($order->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                        @elseif($order->status == 'completed')
                                        <span class="badge badge-success">Completed</span>
                                        @elseif($order->status == 'cancelled')
                                        <span class="badge badge-danger">Cancelled</span>
                                        @else
                                        <span class="badge badge-secondary">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 border-top">
                        <a href="{{ route('admin.store.orders.index', ['product' => $product->id]) }}" class="btn btn-light btn-sm btn-block">
                            View All Orders for This Product
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection