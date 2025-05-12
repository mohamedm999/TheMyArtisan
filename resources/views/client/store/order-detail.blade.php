@extends('layouts.client')

@section('title', 'Order #' . $order->id)

@section('content')
    <div class="container mx-auto px-4 py-4">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="flex py-2 px-4 bg-gray-100 rounded">
                <li class="mr-2"><a href="{{ route('client.orders.index') }}" class="text-blue-500 hover:text-blue-700">Your Orders</a></li>
                <li class="before:content-['/'] before:mx-2 text-gray-700" aria-current="page">Order #{{ $order->id }}</li>
            </ol>
        </nav>

        <div class="flex flex-wrap -mx-4">
            <div class="w-full lg:w-2/3 px-4">
                <div class="bg-white rounded-lg shadow-sm mb-4">
                    <div class="bg-blue-600 text-white p-4 rounded-t-lg">
                        <div class="flex justify-between items-center">
                            <h5 class="m-0 font-medium">Order Details</h5>
                            <span class="px-2 py-1 bg-white text-gray-800 text-xs rounded-full">
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
                    <div class="p-4">
                        <div class="flex flex-wrap -mx-4 mb-4">
                            <div class="w-full md:w-1/2 px-4">
                                <h6 class="font-medium">Order Information</h6>
                                <p class="mb-1"><span class="font-bold">Order ID:</span> #{{ $order->id }}</p>
                                <p class="mb-1"><span class="font-bold">Date:</span> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                                <p class="mb-1"><span class="font-bold">Status:</span>
                                    @if ($order->status == 'pending')
                                        <span class="text-yellow-500">Pending</span>
                                    @elseif($order->status == 'completed')
                                        <span class="text-green-500">Completed</span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="text-red-500">Cancelled</span>
                                    @elseif($order->status == 'refunded')
                                        <span class="text-blue-500">Refunded</span>
                                    @endif
                                </p>
                                <p class="mb-1"><span class="font-bold">Points Spent:</span> {{ number_format($order->points_spent) }}</p>
                            </div>
                            <div class="w-full md:w-1/2 px-4">
                                <h6 class="font-medium">Delivery Information</h6>
                                <p class="mb-1"><span class="font-bold">Delivery Details:</span></p>
                                <p class="mb-3">{{ $order->delivery_details }}</p>

                                @if ($order->tracking_number)
                                    <p class="mb-1"><span class="font-bold">Tracking Number:</span> {{ $order->tracking_number }}</p>
                                @endif

                                @if ($order->redeemed_at)
                                    <p class="mb-1"><span class="font-bold">Redeemed On:</span>
                                        {{ $order->redeemed_at->format('M d, Y h:i A') }}</p>
                                @endif
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="font-medium">Product Ordered</h6>
                        <div class="flex flex-wrap -mx-4">
                            <div class="w-full md:w-1/6 px-4">
                                @if ($order->product->image)
                                    <img src="{{ asset('storage/' . $order->product->image) }}"
                                        alt="{{ $order->product->name }}" class="w-full">
                                @else
                                    <div class="bg-gray-100 text-center py-4">
                                        <i class="fas fa-gift text-2xl text-gray-500"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="w-full md:w-5/6 px-4">
                                <h5 class="font-medium">{{ $order->product->name }}</h5>
                                <p class="text-gray-500">{{ \Str::limit($order->product->description, 150) }}</p>
                                <div class="flex justify-between">
                                    <p class="mb-0"><span class="font-bold">Quantity:</span> {{ $order->quantity }}</p>
                                    <p class="mb-0"><span class="font-bold">Points:</span> {{ number_format($order->points_spent) }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($order->status == 'pending')
                            <div class="bg-blue-100 text-blue-700 p-4 rounded mt-4">
                                <i class="fas fa-info-circle mr-1"></i> Your order is being processed. You will be notified
                                when your order is shipped.
                            </div>
                        @endif
                    </div>
                    <div class="bg-gray-50 p-4 text-center rounded-b-lg">
                        <a href="{{ route('client.store.product', $order->product->id) }}" class="inline-block border border-blue-500 text-blue-500 px-4 py-2 rounded hover:bg-blue-500 hover:text-white transition">
                            <i class="fas fa-shopping-cart mr-1"></i> Purchase Again
                        </a>
                        <a href="{{ route('client.orders.index') }}" class="inline-block border border-gray-500 text-gray-500 px-4 py-2 rounded hover:bg-gray-500 hover:text-white transition ml-2">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Orders
                        </a>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/3 px-4">
                <div class="bg-white rounded-lg shadow-sm mb-4">
                    <div class="bg-gray-100 p-4 rounded-t-lg">
                        <h5 class="m-0 font-medium">Order Summary</h5>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between mb-2">
                            <span>Product Price:</span>
                            <span>{{ number_format($order->points_spent / $order->quantity) }} points</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Quantity:</span>
                            <span>{{ $order->quantity }}</span>
                        </div>
                        <hr class="my-4">
                        <div class="flex justify-between font-bold">
                            <span>Total Points:</span>
                            <span>{{ number_format($order->points_spent) }} points</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm">
                    <div class="bg-gray-100 p-4 rounded-t-lg">
                        <h5 class="m-0 font-medium">Need Help?</h5>
                    </div>
                    <div class="p-4">
                        <p>If you have any questions about your order, please contact our support team.</p>
                        <a href="{{ route('contact') }}" class="block w-full border border-blue-500 text-blue-500 px-4 py-2 rounded text-center hover:bg-blue-500 hover:text-white transition mt-2">
                            <i class="fas fa-headset mr-1"></i> Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
