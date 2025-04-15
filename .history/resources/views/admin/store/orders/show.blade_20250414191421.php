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
                            <div class="col-md-6">
                                <h5>Client Information</h5>
                                <div class="client-details">
                                    <div class="media">
                                        <div class="mr-3">
                                            @if ($order->user->avatar)
                                                <img src="{{ asset('storage/' . $order->user->avatar) }}"
                                                    alt="{{ $order->user->firstname }}"
                                                    class="img-thumbnail rounded-circle"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-primary text-white text-center rounded-circle"
                                                    style="width: 60px; height: 60px; line-height: 60px;">
                                                    {{ substr($order->user->firstname, 0, 1) }}{{ substr($order->user->lastname, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="media-body">
                                            <h5 class="mt-0">
                                                <a href="{{ route('admin.users.show', $order->user_id) }}">
                                                    {{ $order->user->firstname }} {{ $order->user->lastname }}
                                                </a>
                                            </h5>
                                            <p class="text-muted mb-1">{{ $order->user->email }}</p>
                                            <p class="text-muted mb-1">{{ $order->user->phone ?? 'No phone provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th style="width: 200px;">Order ID</th>
                                                <td>#{{ $order->id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Date Ordered</th>
                                                <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Last Updated</th>
                                                <td>{{ $order->updated_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <div class="status-badges">
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
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Quantity</th>
                                                <td>{{ $order->quantity }}</td>
                                            </tr>
                                            <tr>
                                                <th>Points Spent</th>
                                                <td><strong
                                                        class="text-primary">{{ number_format($order->points_spent) }}</strong>
                                                    points</td>
                                            </tr>
                                            @if ($order->shipping_address)
                                                <tr>
                                                    <th>Shipping Address</th>
                                                    <td>{{ $order->shipping_address }}</td>
                                                </tr>
                                            @endif
                                            @if ($order->notes)
                                                <tr>
                                                    <th>Notes</th>
                                                    <td>{{ $order->notes }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                @if ($order->notes_admin)
                                    <div class="mt-4">
                                        <h5>Admin Notes</h5>
                                        <div class="border p-3 bg-light">
                                            {{ $order->notes_admin }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Order History</h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @if ($orderHistory->count() > 0)
                                <ul class="list-group">
                                    @foreach ($orderHistory as $history)
                                        <li class="list-group-item border-0 d-flex">
                                            <div class="timeline-bullet mr-3">
                                                @if ($history->status == 'pending')
                                                    <div class="bg-warning rounded-circle"
                                                        style="width: 12px; height: 12px;"></div>
                                                @elseif($history->status == 'processing')
                                                    <div class="bg-info rounded-circle" style="width: 12px; height: 12px;">
                                                    </div>
                                                @elseif($history->status == 'shipped')
                                                    <div class="bg-primary rounded-circle"
                                                        style="width: 12px; height: 12px;"></div>
                                                @elseif($history->status == 'completed')
                                                    <div class="bg-success rounded-circle"
                                                        style="width: 12px; height: 12px;"></div>
                                                @elseif($history->status == 'cancelled')
                                                    <div class="bg-danger rounded-circle"
                                                        style="width: 12px; height: 12px;"></div>
                                                @else
                                                    <div class="bg-secondary rounded-circle"
                                                        style="width: 12px; height: 12px;"></div>
                                                @endif
                                            </div>
                                            <div class="timeline-content">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="font-weight-bold">Status changed to <span
                                                            class="text-capitalize">{{ $history->status }}</span></span>
                                                    <small
                                                        class="text-muted">{{ $history->created_at->format('M d, Y h:i A') }}</small>
                                                </div>
                                                @if ($history->comment)
                                                    <p class="mt-1 mb-0 text-muted">{{ $history->comment }}</p>
                                                @endif
                                                @if ($history->user)
                                                    <small class="text-info">By: {{ $history->user->firstname }}
                                                        {{ $history->user->lastname }}</small>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No history recorded for this order.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Sidebar -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Order Actions</h6>
                    </div>
                    <div class="card-body">
                        <!-- Status Update Form -->
                        <form action="{{ route('admin.store.orders.update-status', $order->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="status">Change Order Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                        Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped
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
