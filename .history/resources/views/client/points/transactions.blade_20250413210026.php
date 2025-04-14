@extends('layouts.client')

@section('title', 'Points Transaction History')

@section('content')
    <div class="container mx-auto px-4 py-4">
        <div class="flex flex-wrap">
            <div class="w-full lg:w-5/6 mx-auto">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Points Transaction History</h1>
                    <a href="{{ route('client.points.index') }}" class="px-4 py-2 rounded border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Points Dashboard
                    </a>
                </div>

                <div class="bg-white rounded-lg overflow-hidden shadow">
                    <div class="p-4 border-b bg-white">
                        <div class="flex flex-wrap items-center">
                            <div class="flex-1">
                                <h5 class="text-lg font-medium m-0">All Transactions</h5>
                            </div>
                            <div>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-500 text-white">Current Balance:
                                    {{ number_format($user->points->points_balance) }} points</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-0">
                        @if ($transactions->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 text-left">Date</th>
                                            <th class="px-4 py-2 text-left">Description</th>
                                            <th class="px-4 py-2 text-left">Type</th>
                                            <th class="px-4 py-2 text-right">Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 border-t">{{ $transaction->created_at->format('M d, Y h:i A') }}</td>
                                                <td class="px-4 py-2 border-t">{{ $transaction->description }}</td>
                                                <td class="px-4 py-2 border-t">
                                                    @if ($transaction->type == 'earned')
                                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-500 text-white">Earned</span>
                                                    @elseif($transaction->type == 'spent')
                                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-400 text-white">Spent</span>
                                                    @elseif($transaction->type == 'expired')
                                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-500 text-white">Expired</span>
                                                    @elseif($transaction->type == 'refunded')
                                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-500 text-white">Refunded</span>
                                                    @else
                                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-800 text-white">Adjusted</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2 border-t text-right {{ $transaction->points > 0 ? 'text-green-500' : 'text-red-500' }} font-bold">
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
                                    class="max-w-full h-auto mx-auto mb-3" style="max-width: 150px;">
                                <h5 class="text-lg font-medium">No Transactions Yet</h5>
                                <p class="text-gray-500">Start earning points by booking services or writing reviews!</p>
                            </div>
                        @endif
                    </div>

                    @if ($transactions->hasPages())
                        <div class="p-4 border-t">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
