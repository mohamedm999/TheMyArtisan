@extends('layouts.admin')

@section('title', 'Manage Store Orders')

@section('content')
    <?php
    // Fallback values in case the controller doesn't provide these variables
    $totalOrders = $totalOrders ?? App\Models\ProductOrder::count();
    $pendingOrders = $pendingOrders ?? App\Models\ProductOrder::where('status', 'pending')->count();
    $completedOrders = $completedOrders ?? App\Models\ProductOrder::where('status', 'completed')->count();
    $totalPointsSpent = $totalPointsSpent ?? App\Models\ProductOrder::sum('points_spent');
    $products = $products ?? App\Models\StoreProduct::orderBy('name')->get();
    ?>
    <div class="container mx-auto px-4">
        <!-- Page Heading -->
        <div class="sm:flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Store Orders</h1>
            <div>
                <a href="{{ route('admin.store.products.index') }}"
                    class="hidden sm:inline-flex bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded shadow">
                    <i class="fas fa-box text-white mr-1"></i> Manage Products
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded relative" role="alert">
                {{ session('success') }}
                <button type="button" class="absolute top-0 right-0 mt-2 mr-2" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-4">
            <!-- Total Orders Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden border-l-4 border-blue-500">
                <div class="px-4 py-5">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <div class="text-xs font-bold text-blue-600 uppercase mb-1">Total Orders</div>
                            <div class="text-xl font-bold text-gray-800">{{ $totalOrders }}</div>
                        </div>
                        <div>
                            <i class="fas fa-shopping-cart text-2xl text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Orders Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden border-l-4 border-yellow-500">
                <div class="px-4 py-5">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <div class="text-xs font-bold text-yellow-600 uppercase mb-1">Pending Orders</div>
                            <div class="text-xl font-bold text-gray-800">{{ $pendingOrders }}</div>
                        </div>
                        <div>
                            <i class="fas fa-clock text-2xl text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed Orders Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden border-l-4 border-green-500">
                <div class="px-4 py-5">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <div class="text-xs font-bold text-green-600 uppercase mb-1">Completed Orders</div>
                            <div class="text-xl font-bold text-gray-800">{{ $completedOrders }}</div>
                        </div>
                        <div>
                            <i class="fas fa-check-circle text-2xl text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Points Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden border-l-4 border-indigo-500">
                <div class="px-4 py-5">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <div class="text-xs font-bold text-indigo-600 uppercase mb-1">Total Points Spent</div>
                            <div class="text-xl font-bold text-gray-800">{{ number_format($totalPointsSpent) }}</div>
                        </div>
                        <div>
                            <i class="fas fa-coins text-2xl text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-4 py-3 border-b">
                <h6 class="font-bold text-blue-600">Filter Orders</h6>
            </div>
            <div class="p-4">
                <form method="GET" action="{{ route('admin.store.orders.index') }}" class="flex flex-wrap items-end gap-4">
                    <div class="mb-2">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status:</label>
                        <select name="status" id="status" class="w-full rounded border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="product" class="block text-sm font-medium text-gray-700 mb-1">Product:</label>
                        <select name="product" id="product" class="w-full rounded border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            <option value="">All Products</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ request('product') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From:</label>
                        <input type="date" name="date_from" id="date_from" class="rounded border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                            value="{{ request('date_from') }}">
                    </div>

                    <div class="mb-2">
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To:</label>
                        <input type="date" name="date_to" id="date_to" class="rounded border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                            value="{{ request('date_to') }}">
                    </div>

                    <div class="mb-2 flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Apply Filters</button>
                        <a href="{{ route('admin.store.orders.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Table Card -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="bg-gray-50 px-4 py-3 border-b">
                <h6 class="font-bold text-blue-600">All Orders</h6>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="ordersTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.store.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900">#{{ $order->id }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if (isset($order->user))
                                            <a href="{{ route('admin.users.show', $order->user_id) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ $order->user->firstname }} {{ $order->user->lastname }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">User not found</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($order->product)
                                            <a href="{{ route('admin.store.products.show', $order->store_product_id) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ $order->product->name }}
                                            </a>
                                        @else
                                        @endif
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
