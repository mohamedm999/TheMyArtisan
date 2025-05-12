@extends('layouts.client')

@section('title', 'Points Transaction History')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3">Points Transaction History</h1>
                    <a href="{{ route('client.points.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Points Dashboard
                    </a>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">All Transactions</h5>
                            </div>
                            <div class="col-auto">
                                <span class="badge badge-primary">Current Balance:
                                    {{ number_format($user->points->points_balance) }} points</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if ($transactions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th class="text-right">Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->created_at->format('M d, Y h:i A') }}</td>
                                                <td>{{ $transaction->description }}</td>
                                                <td>
                                                    @if ($transaction->type == 'earned')
                                                        <span class="badge badge-success">Earned</span>
                                                    @elseif($transaction->type == 'spent')
                                                        <span class="badge badge-info">Spent</span>
                                                    @elseif($transaction->type == 'expired')
                                                        <span class="badge badge-warning">Expired</span>
                                                    @elseif($transaction->type == 'refunded')
                                                        <span class="badge badge-secondary">Refunded</span>
                                                    @else
                                                        <span class="badge badge-dark">Adjusted</span>
                                                    @endif
                                                </td>
                                                <td
                                                    class="text-right {{ $transaction->points > 0 ? 'text-success' : 'text-danger' }} font-weight-bold">
                                                    {{ $transaction->points > 0 ? '+' : '' }}{{ $transaction->points }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <img src="{{ asset('images/no-transactions.svg') }}" alt="No Transactions"
                                    class="img-fluid mb-3" style="max-width: 150px;">
                                <h5>No Transactions Yet</h5>
                                <p class="text-muted">Start earning points by booking services or writing reviews!</p>
                            </div>
                        @endif
                    </div>

                    @if ($transactions->hasPages())
                        <div class="card-footer">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
