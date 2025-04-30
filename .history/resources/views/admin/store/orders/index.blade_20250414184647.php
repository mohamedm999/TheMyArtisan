@extends('layouts.admin')

@section('title', 'Manage Store Orders')

@section('content')
    <?php
    // Fallback values in case the controller doesn't provide these variables
    $totalOrders = $totalOrders ?? App\Models\ProductOrder::count();
    $pendingOrders = $pendingOrders ?? App\Models\ProductOrder::where('status', 'pending')->count();
    $completedOrders = $completedOrders ?? App\Models\ProductOrder::where('status', 'completed')->count();
    $totalPointsSpent = $totalPointsSpent ?? App\Models\ProductOrder::sum('points_spent');
    ?>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Store Orders</h1>
            <div>
                <a href="{{ route('admin.store.products.index') }}"
                    class="d-none d-sm-inline-block btn btn-secondary shadow-sm">
                    <i class="fas fa-box fa-sm text-white-50 mr-1"></i> Manage Products
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingOrders }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed Orders
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedOrders }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Points Spent</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPointsSpent) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-coins fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Filter Orders</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.store.orders.index') }}" class="form-inline">
                    <div class="form-group mb-2 mr-2">
                        <label for="status" class="mr-2">Status:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing
                            </option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>

                    <div class="form-group mb-2 mr-2">
                        <label for="product" class="mr-2">Product:</label>
                        <select name="product" id="product" class="form-control">
                            <option value="">All Products</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ request('product') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2 mr-2">
                        <label for="date_from" class="mr-2">From:</label>
                        <input type="date" name="date_from" id="date_from" class="form-control"
                            value="{{ request('date_from') }}">
                    </div>

                    <div class="form-group mb-2 mr-2">
                        <label for="date_to" class="mr-2">To:</label>
                        <input type="date" name="date_to" id="date_to" class="form-control"
                            value="{{ request('date_to') }}">
                    </div>

                    <button type="submit" class="btn btn-primary mb-2 mr-2">Apply Filters</button>
                    <a href="{{ route('admin.store.orders.index') }}" class="btn btn-secondary mb-2">Reset</a>
                </form>
            </div>
        </div>

        <!-- Orders Table Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="ordersTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Client</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Points</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td><a
                                            href="{{ route('admin.store.orders.show', $order->id) }}">#{{ $order->id }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.clients.show', $order->user_id) }}">
                                            {{ $order->user->firstname }} {{ $order->user->lastname }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($order->product)
                                            <a href="{{ route('admin.store.products.show', $order->store_product_id) }}">
                                                {{ $order->product->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">Product Deleted</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>{{ number_format($order->points_spent) }}</td>
                                    <td>
                                        @if ($order->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge badge-info">Processing</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge badge-primary">Shipped</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge badge-danger">Cancelled</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.store.orders.show', $order->id) }}"
                                                class="btn btn-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <div class="dropdown d-inline">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    id="statusDropdown{{ $order->id }}" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-exchange-alt"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="statusDropdown{{ $order->id }}">
                                                    @foreach (['pending', 'processing', 'shipped', 'completed', 'cancelled'] as $status)
                                                        @if ($status != $order->status)
                                                            <form
                                                                action="{{ route('admin.store.orders.update-status', $order->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="status"
                                                                    value="{{ $status }}">
                                                                <button type="submit" class="dropdown-item">
                                                                    Mark as {{ ucfirst($status) }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No orders found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $orders->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#ordersTable').DataTable({
                "paging": false,
                "searching": true,
                "ordering": true,
                "info": false,
            });
        });
    </script>
@endsection
