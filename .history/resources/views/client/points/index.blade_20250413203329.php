@extends('layouts.client')

@section('title', 'Your Reward Points')

@section('content')
    <div class="container mx-auto px-4 py-4">
        <div class="flex flex-wrap">
            <div class="w-full lg:w-2/3 mx-auto">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-blue-600 text-white px-6 py-4">
                        <h5 class="text-lg font-medium m-0">Your Reward Points</h5>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-4">
                            <div class="text-5xl font-bold text-blue-600">
                                {{ number_format($points->points_balance) }}
                            </div>
                            <p class="text-gray-500">Current Points Balance</p>

                            <div class="text-green-600 mt-3">
                                <i class="fas fa-award"></i> Lifetime Points Earned:
                                {{ number_format($points->lifetime_points) }}
                            </div>
                        </div>

                        <div class="bg-gray-100 rounded-lg p-4 mb-4">
                            <h5 class="font-medium mb-2">How to Earn Points</h5>
                                <h5 class="card-title">How to Earn Points</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Booking
                                        services with artisans</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Writing reviews
                                        after completed services</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Referring
                                        friends to MyArtisan</li>
                                    <li><i class="fas fa-check-circle text-success mr-2"></i> Special promotions and events
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="text-center mb-4">
                            <a href="{{ route('client.store.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-cart mr-1"></i> Visit Store to Spend Points
                            </a>
                            <a href="{{ route('client.points.transactions') }}" class="btn btn-outline-secondary ml-2">
                                <i class="fas fa-history mr-1"></i> View Transaction History
                            </a>
                        </div>
                    </div>
                </div>

                @if ($transactions->count() > 0)
                    <div class="card shadow-sm mt-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Recent Transactions</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th class="text-right">Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                                <td>{{ $transaction->description }}</td>
                                                <td
                                                    class="text-right {{ $transaction->points > 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ $transaction->points > 0 ? '+' : '' }}{{ $transaction->points }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('client.points.transactions') }}" class="text-primary">
                                View All Transactions <i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
