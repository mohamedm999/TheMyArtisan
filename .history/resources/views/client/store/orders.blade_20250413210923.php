@extends('layouts.client')

@section('title', 'Your Orders')

@section('content')
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Your Orders</h1>
            <div>
                <a href="{{ route('client.store.index') }}" class="inline-flex items-center px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-600 hover:text-white">
                    <i class="fas fa-shopping-cart mr-1"></i> Continue Shopping
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-4 py-3 bg-gray-50 border-b">
                <h5 class="font-medium m-0">Order History</h5>
            </div>
            <div class="p-0">
                @if ($orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points Spent</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->product->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($order->points_spent) }}</td>
                                        <td>
                                            @if ($order->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($order->status == 'completed')
                                                <span class="badge badge-success">Completed</span>
                                            @elseif($order->status == 'cancelled')
                                                <span class="badge badge-danger">Cancelled</span>
                                            @elseif($order->status == 'refunded')
                                                <span class="badge badge-info">Refunded</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('client.orders.detail', $order->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <img src="{{ asset('images/no-orders.svg') }}" alt="No Orders" class="img-fluid mb-3"
                            style="max-width: 150px;">
                        <h5>No Orders Yet</h5>
                        <p class="text-muted">You haven't made any orders yet. Head to the store to spend your points!</p>
                        <a href="{{ route('client.store.index') }}" class="btn btn-primary mt-2">
                            <i class="fas fa-shopping-cart mr-1"></i> Visit Store
                        </a>
                    </div>
                @endif
            </div>

            @if ($orders->hasPages())
                <div class="card-footer">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

        <!-- Points balance card -->
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-1">Current Points Balance</h5>
                        <p class="text-muted mb-0">Keep earning points by booking services and writing reviews!</p>
                    </div>
                    <div>
                        <span class="h3 text-primary font-weight-bold">{{ number_format($user->points_balance) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
