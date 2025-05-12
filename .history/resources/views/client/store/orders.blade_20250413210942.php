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
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($order->status == 'pending')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($order->status == 'completed')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                            @elseif($order->status == 'cancelled')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                                            @elseif($order->status == 'refunded')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Refunded</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('client.orders.detail', $order->id) }}"
                                                class="px-3 py-1 text-xs border border-blue-600 text-blue-600 rounded hover:bg-blue-600 hover:text-white">
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
                        <img src="{{ asset('images/no-orders.svg') }}" alt="No Orders" class="max-w-[150px] h-auto mx-auto mb-3">
                        <h5 class="font-medium">No Orders Yet</h5>
                        <p class="text-gray-500">You haven't made any orders yet. Head to the store to spend your points!</p>
                        <a href="{{ route('client.store.index') }}" class="inline-block px-4 py-2 mt-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            <i class="fas fa-shopping-cart mr-1"></i> Visit Store
                        </a>
                    </div>
                @endif
            </div>

            @if ($orders->hasPages())
                <div class="px-4 py-3 bg-gray-50 border-t">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

        <!-- Points balance card -->
        <div class="bg-white rounded-lg shadow-sm mt-4">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h5 class="font-medium mb-1">Current Points Balance</h5>
                        <p class="text-gray-500 mb-0">Keep earning points by booking services and writing reviews!</p>
                    </div>
                    <div>
                        <span class="text-xl text-blue-600 font-bold">{{ number_format($user->points_balance) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
