@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Order #{{ $order->id }}</h1>
            <div>
                <a href="{{ route('admin.store.orders.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Orders
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

        <div class="row">
            <!-- Order Details Card -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Order Information</h6>
                        <span class="order-status">
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
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Product Information</h5>
                                <div class="product-details">
                                    @if ($order->product)
                                        <div class="media">
                                            <div class="mr-3">
                                                @if ($order->product->image)
                                                    <img src="{{ asset('storage/' . $order->product->image) }}"
                                                        alt="{{ $order->product->name }}" class="img-thumbnail"
                                                        style="width: 80px; height: 80px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light text-center rounded"
                                                        style="width: 80px; height: 80px; line-height: 80px;">
                                                        <i class="fas fa-gift fa-2x text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <h5 class="mt-0">
                                                    <a
                                                        href="{{ route('admin.store.products.show', $order->store_product_id) }}">
                                                        {{ $order->product->name }}
                                                    </a>
                                                </h5>
                                                <p class="text-muted mb-1">
                                                    {{ $order->product->category ?? 'Uncategorized' }}</p>
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3">
                                                        <span
                                                            class="font-weight-bold text-primary">{{ number_format($order->product->points_cost) }}</span>
                                                        <small class="text-muted">points</small>
                                                    </div>
                                                    <div>
                                                        <span class="badge badge-secondary">x {{ $order->quantity }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Product no longer exists.
                                        </div>
                                    @endif
                                </div>
                            </div>
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
                                                <a href="{{ route('admin.clients.show', $order->user_id) }}">
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

                                <a href="{{ route('admin.clients.show', $order->user_id) }}"
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
                                <a href="{{ route('admin.clients.points', $order->user_id) }}"
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
