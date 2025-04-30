@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('content')
    <?php
    // Fallback values for variables that might be missing - using the correct polymorphic relationship
    $orderHistory = $orderHistory ?? App\Models\PointTransaction::where('transactionable_type', 'App\\Models\\ProductOrder')->where('transactionable_id', $order->id)->with('user')->orderBy('created_at', 'desc')->get();
    
    // Get client's current points if not set
    $pointsService = app(\App\Services\PointsService::class);
    $clientPoints = $clientPoints ?? $pointsService->getUserPoints($order->user_id);
    
    // Get recent points history for this client if not set
    $pointsHistory = $pointsHistory ?? App\Models\PointTransaction::where('user_id', $order->user_id)->orderBy('created_at', 'desc')->limit(5)->get();
    ?>
    <div class="px-4 py-6">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Order #{{ $order->id }}</h1>
            <div>
                <a href="{{ route('admin.store.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 rounded-md font-semibold text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Orders
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M6.293 6.293a1 1 0 011.414 0L10 8.586l2.293-2.293a1 1 0 111.414 1.414L11.414 10l2.293 2.293a1 1 0 01-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 10 6.293 7.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                </button>
            </div>
        @endif

        <div class="flex flex-wrap -mx-4">
            <!-- Order Details Card -->
            <div class="w-full lg:w-2/3 px-4 mb-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-b">
                        <h2 class="text-lg font-semibold text-blue-600">Order Information</h2>
                        <span class="order-status">
                            @if ($order->status == 'pending')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($order->status == 'processing')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Processing</span>
                            @elseif($order->status == 'shipped')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Shipped</span>
                            @elseif($order->status == 'completed')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                            @elseif($order->status == 'cancelled')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ $order->status }}</span>
                            @endif
                        </span>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-wrap -mx-4 mb-6">
                            <div class="w-full md:w-1/2 px-4 mb-4 md:mb-0">
                                <h3 class="text-lg font-semibold mb-4">Product Information</h3>
                                <div class="product-details">
                                    @if ($order->product)
                                        <div class="flex">
                                            <div class="mr-4 flex-shrink-0">
                                                @if ($order->product->image)
                                                    <img src="{{ asset('storage/' . $order->product->image) }}"
                                                        alt="{{ $order->product->name }}" class="w-20 h-20 object-cover border rounded-md">
                                                @else
                                                    <div class="w-20 h-20 bg-gray-100 flex items-center justify-center rounded-md">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-medium">
                                                    <a href="{{ route('admin.store.products.show', $order->store_product_id) }}" class="text-blue-600 hover:text-blue-800">
                                                        {{ $order->product->name }}
                                                    </a>
                                                </h4>
                                                <p class="text-gray-500 text-sm mb-1">
                                                    {{ $order->product->category ?? 'Uncategorized' }}</p>
                                                <div class="flex items-center">
                                                    <div class="mr-3">
                                                        <span class="font-bold text-blue-600">{{ number_format($order->product->points_cost) }}</span>
                                                        <span class="text-gray-500 text-sm">points</span>
                                                    </div>
                                                    <div>
                                                        <span class="px-2 py-1 text-xs bg-gray-200 rounded-full">x {{ $order->quantity }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                            <div class="flex">
                                                <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                                <span class="ml-3">Product no longer exists.</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 px-4">
                                <h3 class="text-lg font-semibold mb-4">Client Information</h3>
                                <div class="flex">
                                    <div class="mr-4 flex-shrink-0">
                                        @if ($order->user->avatar)
                                            <img src="{{ asset('storage/' . $order->user->avatar) }}"
                                                alt="{{ $order->user->firstname }}"
                                                class="w-14 h-14 rounded-full object-cover border">
                                        @else
                                            <div class="w-14 h-14 rounded-full bg-blue-600 text-white flex items-center justify-center">
                                                <span>{{ substr($order->user->firstname, 0, 1) }}{{ substr($order->user->lastname, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-medium">
                                            <a href="{{ route('admin.users.show', $order->user_id) }}" class="text-blue-600 hover:text-blue-800">
                                                {{ $order->user->firstname }} {{ $order->user->lastname }}
                                            </a>
                                        </h4>
                                        <p class="text-gray-500 text-sm mb-1">{{ $order->user->email }}</p>
                                        <p class="text-gray-500 text-sm">{{ $order->user->phone ?? 'No phone provided' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-6 border-gray-200">
                        <div class="w-full">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Order ID</th>
                                            <td class="px-4 py-3">#{{ $order->id }}</td>
                                        </tr>
                                        <tr>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Ordered</th>
                                            <td class="px-4 py-3">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                                            <td class="px-4 py-3">{{ $order->updated_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <td class="px-4 py-3">
                                                <div class="status-badges">
                                                    @if ($order->status == 'pending')
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                    @elseif($order->status == 'processing')
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Processing</span>
                                                    @elseif($order->status == 'shipped')
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Shipped</span>
                                                    @elseif($order->status == 'completed')
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                                    @elseif($order->status == 'cancelled')
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ $order->status }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <td class="px-4 py-3">{{ $order->quantity }}</td>
                                        </tr>
                                        <tr>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points Spent</th>
                                            <td class="px-4 py-3"><strong class="text-blue-600">{{ number_format($order->points_spent) }}</strong> points</td>
                                        </tr>
                                        @if ($order->shipping_address)
                                            <tr>
                                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shipping Address</th>
                                                <td class="px-4 py-3">{{ $order->shipping_address }}</td>
                                            </tr>
                                        @endif
                                        @if ($order->notes)
                                            <tr>
                                                <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                                <td class="px-4 py-3">{{ $order->notes }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            @if ($order->notes_admin)
                                <div class="mt-6">
                                    <h3 class="text-lg font-semibold mb-2">Admin Notes</h3>
                                    <div class="p-4 bg-gray-50 rounded-md border border-gray-200">
                                        {{ $order->notes_admin }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b">
                        <h2 class="text-lg font-semibold text-blue-600">Order History</h2>
                    </div>
                    <div class="p-6">
                        <div class="timeline">
                            @if ($orderHistory->count() > 0)
                                <ul class="space-y-4">
                                    @foreach ($orderHistory as $history)
                                        <li class="flex">
                                            <div class="mr-4 mt-1">
                                                @if ($history->status == 'pending')
                                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                                @elseif($history->status == 'processing')
                                                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                                @elseif($history->status == 'shipped')
                                                    <div class="w-3 h-3 rounded-full bg-indigo-500"></div>
                                                @elseif($history->status == 'completed')
                                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                                @elseif($history->status == 'cancelled')
                                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                                @else
                                                    <div class="w-3 h-3 rounded-full bg-gray-500"></div>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex justify-between items-center">
                                                    <span class="font-medium">Status changed to <span class="capitalize">{{ $history->status }}</span></span>
                                                    <span class="text-sm text-gray-500">{{ $history->created_at->format('M d, Y h:i A') }}</span>
                                                </div>
                                                @if ($history->comment)
                                                    <p class="mt-1 text-gray-600 text-sm">{{ $history->comment }}</p>
                                                @endif
                                                @if ($history->user)
                                                    <small class="text-blue-600 text-xs">By: {{ $history->user->firstname }} {{ $history->user->lastname }}</small>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500">No history recorded for this order.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Sidebar -->
            <div class="w-full lg:w-1/3 px-4 mb-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-gray-50 border-b">
                        <h2 class="text-lg font-semibold text-blue-600">Order Actions</h2>
                    </div>
                    <div class="p-6">
                        <!-- Status Update Form -->
                        <form action="{{ route('admin.store.orders.update-status', $order->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Change Order Status</label>
                                <select name="status" id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Comment (Optional)</label>
                                <textarea name="comment" id="comment" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" rows="2"></textarea>
                                <p class="mt-1 text-sm text-gray-500">Add a note about this status change</p>
                            </div>

                            <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="comment">Comment (Optional)</label>
                                <textarea name="comment" id="comment" class="form-control" rows="2"></textarea>
                                <small class="form-text text-muted">Add a note about this status change</small>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-sync-alt mr-1"></i> Update Status
                            </button>
                        </form>

                        <hr>

                        <!-- Admin Notes Form -->
                        <form action="{{ route('admin.store.orders.update-admin-notes', $order->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="notes_admin">Admin Notes (Internal only)</label>
                                <textarea name="notes_admin" id="notes_admin" class="form-control" rows="4">{{ $order->notes_admin }}</textarea>
                                <small class="form-text text-muted">These notes are for internal use only and not visible
                                    to clients</small>
                            </div>

                            <button type="submit" class="btn btn-secondary btn-block">
                                <i class="fas fa-save mr-1"></i> Save Admin Notes
                            </button>
                        </form>

                        <hr>

                        <div class="quick-actions">
                            <h6 class="font-weight-bold">Quick Actions</h6>
                            <div class="mt-3">
                                @if ($order->status != 'cancelled')
                                    <form action="{{ route('admin.store.orders.cancel', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to cancel this order? This will return points to the client.');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-block mb-2">
                                            <i class="fas fa-times mr-1"></i> Cancel Order & Return Points
                                        </button>
                                    </form>
                                @endif

                                @if ($order->status != 'completed')
                                    <form action="{{ route('admin.store.orders.complete', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-block mb-2">
                                            <i class="fas fa-check mr-1"></i> Mark as Completed
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('admin.store.orders.email', $order->id) }}"
                                    class="btn btn-info btn-block mb-2">
                                    <i class="fas fa-envelope mr-1"></i> Email Client
                                </a>

                                <a href="{{ route('admin.users.show', $order->user_id) }}"
                                    class="btn btn-secondary btn-block">
                                    <i class="fas fa-user mr-1"></i> View Client Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Client Points Summary</h6>
                    </div>
                    <div class="card-body">
                        <div class="client-points-summary">
                            <h4 class="text-primary mb-3">{{ number_format($clientPoints) }}</h4>
                            <p class="text-muted">Current points balance for {{ $order->user->firstname }}</p>

                            <div class="points-history">
                                <h6 class="font-weight-bold">Recent Points Activity</h6>
                                <ul class="list-group list-group-flush">
                                    @forelse($pointsHistory as $transaction)
                                        <li class="list-group-item p-2 d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="font-weight-bold">
                                                    @if ($transaction->points > 0)
                                                        <i class="fas fa-plus-circle text-success mr-1"></i>
                                                    @else
                                                        <i class="fas fa-minus-circle text-danger mr-1"></i>
                                                    @endif
                                                    {{ $transaction->points > 0 ? '+' : '' }}{{ number_format($transaction->points) }}
                                                </span>
                                                <div class="small text-muted">{{ $transaction->description }}</div>
                                            </div>
                                            <small>{{ $transaction->created_at->format('M d') }}</small>
                                        </li>
                                    @empty
                                        <li class="list-group-item">No recent activity</li>
                                    @endforelse
                                </ul>
                            </div>

                            <div class="mt-3">
                                <a href="{{ route('admin.points.show', $order->user_id) }}"
                                    class="btn btn-outline-primary btn-sm btn-block">
                                    <i class="fas fa-history mr-1"></i> Full Points History
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
