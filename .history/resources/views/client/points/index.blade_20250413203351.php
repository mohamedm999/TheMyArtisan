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
                            <ul class="list-none">
                                <li class="mb-2"><i class="fas fa-check-circle text-green-600 mr-2"></i> Booking
                                    services with artisans</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-green-600 mr-2"></i> Writing reviews
                                    after completed services</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-green-600 mr-2"></i> Referring
                                    friends to MyArtisan</li>
                                <li><i class="fas fa-check-circle text-green-600 mr-2"></i> Special promotions and events
                                </li>
                            </ul>
                        </div>

                        <div class="text-center mb-4">
                            <a href="{{ route('client.store.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded inline-block">
                                <i class="fas fa-shopping-cart mr-1"></i> Visit Store to Spend Points
                            </a>
                            <a href="{{ route('client.points.transactions') }}" class="border border-gray-400 text-gray-600 hover:bg-gray-100 font-medium py-2 px-4 rounded ml-2 inline-block">
                                <i class="fas fa-history mr-1"></i> View Transaction History
                            </a>
                        </div>
                    </div>
                </div>

                @if ($transactions->count() > 0)
                    <div class="bg-white rounded-lg shadow mt-4 overflow-hidden">
                        <div class="bg-gray-100 px-6 py-4">
                            <h5 class="text-lg font-medium m-0">Recent Transactions</h5>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->created_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4">{{ $transaction->description }}</td>
                                            <td class="px-6 py-4 text-right {{ $transaction->points > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $transaction->points > 0 ? '+' : '' }}{{ $transaction->points }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-3 text-center">
                            <a href="{{ route('client.points.transactions') }}" class="text-blue-600 hover:text-blue-800">
                                View All Transactions <i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
