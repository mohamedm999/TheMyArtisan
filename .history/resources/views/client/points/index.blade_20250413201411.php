@extends('layouts.client')

@section('title', 'Your Reward Points')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Your Reward Points</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="display-4 font-weight-bold text-primary">
                            {{ number_format($points->points_balance) }}
                        </div>
                        <p class="text-muted">Current Points Balance</p>
                        
                        <div class="text-success mt-3">
                            <i class="fas fa-award"></i> Lifetime Points Earned: {{ number_format($points->lifetime_points) }}
                        </div>
                    </div>
                    
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="card-title">How to Earn Points</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Booking services with artisans</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Writing reviews after completed services</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Referring friends to MyArtisan</li>
                                <li><i class="fas fa-check-circle text-success mr-2"></i> Special promotions and events</li>
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
            
            @if($transactions->count() > 0)
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
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td class="text-right {{ $transaction->points > 0 ? 'text-success' : 'text-danger' }}">
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