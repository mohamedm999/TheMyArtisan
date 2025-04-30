@extends('layouts.admin')

@section('title', 'Points Analytics')
@section('description', 'Client reward points analytics and statistics')

@section('styles')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Points Analytics</h1>
                    <p class="mt-1 text-sm text-gray-500">View statistics and metrics for the client rewards program</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.points.index') }}"
                        class="border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg shadow-sm text-sm font-medium transition-all focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Points
                    </a>
                </div>
            </div>
        </div>

        <div class="p-4">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <div class="bg-primary-50 rounded-lg p-4 border border-primary-100">
                    <h3 class="text-lg font-semibold text-primary-700">Total Points in Circulation</h3>
                    <div class="mt-2 flex items-center">
                        <i class="fas fa-coins text-primary-500 text-2xl mr-3"></i>
                        <span class="text-3xl font-bold text-primary-800">{{ number_format($totalPoints) }}</span>
                    </div>
                </div>

                <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                    <h3 class="text-lg font-semibold text-green-700">Total Points Awarded</h3>
                    <div class="mt-2 flex items-center">
                        <i class="fas fa-trophy text-green-500 text-2xl mr-3"></i>
                        <span class="text-3xl font-bold text-green-800">{{ number_format($totalPointsAwarded) }}</span>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                    <h3 class="text-lg font-semibold text-blue-700">Points Redeemed</h3>
                    <div class="mt-2 flex items-center">
                        <i class="fas fa-shopping-cart text-blue-500 text-2xl mr-3"></i>
                        <span
                            class="text-3xl font-bold text-blue-800">{{ number_format($totalPointsAwarded - $totalPoints) }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Monthly Points Chart -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Points Activity (Last 6 Months)</h3>
                    </div>
                    <div class="p-4">
                        <canvas id="pointsChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Top Clients -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Top Clients by Lifetime Points</h3>
                    </div>
                    <div class="p-4">
                        <ul class="divide-y divide-gray-200">
                            @foreach ($topClients as $index => $clientPoint)
                                <li class="py-3 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 flex items-center justify-center {{ $index < 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }} rounded-full">
                                            <span class="font-bold text-sm">{{ $index + 1 }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $clientPoint->user->firstname }}
                                                {{ $clientPoint->user->lastname }}</p>
                                            <p class="text-xs text-gray-500">{{ $clientPoint->user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-primary-100 text-primary-800">
                                            {{ number_format($clientPoint->lifetime_points) }} points
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 shadow-sm mb-6">
                <div class="px-4 py-3 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Clients with Highest Point Balance</h3>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rank</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Client</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Current Balance</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Lifetime Points</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($richestClients as $index => $clientPoint)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <span
                                                class="inline-flex items-center justify-center h-6 w-6 rounded-full {{ $index < 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $index + 1 }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700">
                                                    <span
                                                        class="font-medium">{{ substr($clientPoint->user->firstname, 0, 1) }}{{ substr($clientPoint->user->lastname, 0, 1) }}</span>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $clientPoint->user->firstname }}
                                                        {{ $clientPoint->user->lastname }}</div>
                                                    <div class="text-xs text-gray-500">{{ $clientPoint->user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            <span
                                                class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-primary-100 text-primary-800">
                                                {{ number_format($clientPoint->points_balance) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            {{ number_format($clientPoint->lifetime_points) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.points.show', $clientPoint->user_id) }}"
                                                class="text-primary-600 hover:text-primary-900">
                                                Manage Points
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('pointsChart').getContext('2d');

            // Prepare data for chart
            const labels = [];
            const earnedData = [];
            const spentData = [];

            // Last 6 months
            const months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            // Create a map of earned points by month
            const earnedByMonth = {};
            @foreach ($pointsEarnedByMonth as $point)
                earnedByMonth['{{ $point->year }}-{{ $point->month }}'] = {{ $point->total }};
            @endforeach

            // Create a map of spent points by month
            const spentByMonth = {};
            @foreach ($pointsSpentByMonth as $point)
                spentByMonth['{{ $point->year }}-{{ $point->month }}'] = {{ $point->total }};
            @endforeach

            // Generate labels for the last 6 months
            const today = new Date();
            for (let i = 5; i >= 0; i--) {
                const d = new Date(today);
                d.setMonth(d.getMonth() - i);
                const year = d.getFullYear();
                const month = d.getMonth() + 1;

                const label = months[d.getMonth()] + ' ' + year;
                labels.push(label);

                const key = `${year}-${month}`;
                earnedData.push(earnedByMonth[key] || 0);
                spentData.push(spentByMonth[key] || 0);
            }

            // Create chart
            const pointsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Points Earned',
                            data: earnedData,
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Points Spent',
                            data: spentData,
                            borderColor: '#F59E0B',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
