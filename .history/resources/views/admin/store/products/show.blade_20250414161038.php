@extends('layouts.admin')

@section('title', $product->name)

@section('content')
    <div class="container mx-auto px-4">
        <!-- Page Heading -->
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Product Details</h1>
            <div>
                <a href="{{ route('admin.store.products.edit', $product->id) }}" class="inline-flex items-center px-4 py-2 mr-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition">
                    <i class="fas fa-edit text-sm mr-1"></i> Edit Product
                </a>
                <a href="{{ route('admin.store.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded shadow hover:bg-gray-700 transition">
                    <i class="fas fa-arrow-left text-sm mr-1"></i> Back to Products
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 relative" role="alert">
                {{ session('success') }}
                <button type="button" class="absolute top-0 right-0 mt-2 mr-2" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="flex flex-wrap -mx-2">
            <!-- Product Details Card -->
            <div class="w-full lg:w-2/3 px-2">
                <div class="bg-white rounded-lg shadow mb-4">
                    <div class="flex items-center justify-between border-b px-4 py-3">
                        <h6 class="font-bold text-blue-600">{{ $product->name }}</h6>
                        <div>
                            @if ($product->is_featured)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 ml-1">
                                    <i class="fas fa-star mr-1"></i> Featured
                                </span>
                            @endif
                            @if ($product->is_available)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 ml-1">Available</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 ml-1">Unavailable</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/3 px-2 mb-4 md:mb-0">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-auto rounded">
                                @else
                                    <div class="bg-gray-100 text-center py-5 rounded">
                                        <i class="fas fa-gift text-4xl text-gray-400"></i>
                                        <p class="mt-3 text-gray-500">No image available</p>
                                    </div>
                                @endif
                            </div>
                            <div class="w-full md:w-2/3 px-2">
                                <h5 class="font-bold mb-2">Product Details</h5>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full border divide-y divide-gray-200">
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <th class="px-4 py-2 bg-gray-50 text-left text-sm text-gray-700 w-36">ID</th>
                                                <td class="px-4 py-2 text-sm">{{ $product->id }}</td>
                                            </tr>
                                            <tr>
                                                <th class="px-4 py-2 bg-gray-50 text-left text-sm text-gray-700">Name</th>
                                                <td class="px-4 py-2 text-sm">{{ $product->name }}</td>
                                            </tr>
                                            <tr>
                                                <th class="px-4 py-2 bg-gray-50 text-left text-sm text-gray-700">Category</th>
                                                <td class="px-4 py-2 text-sm">{{ $product->category ?? 'Uncategorized' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="px-4 py-2 bg-gray-50 text-left text-sm text-gray-700">Points Cost</th>
                                                <td class="px-4 py-2 text-sm">
                                                    <span class="font-bold text-blue-600">{{ number_format($product->points_cost) }}</span> points
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="px-4 py-2 bg-gray-50 text-left text-sm text-gray-700">Stock</th>
                                                <td class="px-4 py-2 text-sm">
                                                    @if ($product->stock == -1)
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Unlimited</span>
                                                    @elseif($product->stock > 10)
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ $product->stock }} available</span>
                                                    @elseif($product->stock > 0)
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ $product->stock }} left</span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Out of stock</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="px-4 py-2 bg-gray-50 text-left text-sm text-gray-700">Created</th>
                                                <td class="px-4 py-2 text-sm">{{ $product->created_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <th class="px-4 py-2 bg-gray-50 text-left text-sm text-gray-700">Last Updated</th>
                                                <td class="px-4 py-2 text-sm">{{ $product->updated_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <h5 class="font-bold mt-4 mb-2">Description</h5>
                                <div class="border rounded p-3 bg-gray-50">
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
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total
                                                Orders</div>
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
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Points
                                                Spent</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ number_format($totalPointsSpent) }}</div>
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
                                <a href="{{ route('admin.store.products.edit', $product->id) }}"
                                    class="btn btn-primary btn-sm btn-block">
                                    <i class="fas fa-edit mr-1"></i> Edit Product
                                </a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <form action="{{ route('admin.store.products.toggleAvailability', $product->id) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn {{ $product->is_available ? 'btn-warning' : 'btn-success' }} btn-sm btn-block">
                                        @if ($product->is_available)
                                            <i class="fas fa-ban mr-1"></i> Make Unavailable
                                        @else
                                            <i class="fas fa-check-circle mr-1"></i> Make Available
                                        @endif
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6 mb-2">
                                <form action="{{ route('admin.store.products.toggleFeatured', $product->id) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn {{ $product->is_featured ? 'btn-secondary' : 'btn-warning' }} btn-sm btn-block">
                                        @if ($product->is_featured)
                                            <i class="fas fa-star mr-1"></i> Unfeature
                                        @else
                                            <i class="fas fa-star mr-1"></i> Make Featured
                                        @endif
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6 mb-2">
                                <form action="{{ route('admin.store.products.destroy', $product->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
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

                @if ($recentOrders->count() > 0)
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
                                        @foreach ($recentOrders as $order)
                                            <tr>
                                                <td>
                                                    <a
                                                        href="{{ route('admin.store.orders.show', $order->id) }}">#{{ $order->id }}</a>
                                                </td>
                                                <td>{{ $order->user->firstname }} {{ $order->user->lastname }}</td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    @if ($order->status == 'pending')
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
                                <a href="{{ route('admin.store.orders.index', ['product' => $product->id]) }}"
                                    class="btn btn-light btn-sm btn-block">
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
