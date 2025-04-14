@extends('layouts.admin')

@section('title', 'Manage Client Points')
@section('description', 'Manage client reward points and transaction history')

@section('content')
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Manage Client Points</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        View and adjust points for {{ $user->firstname }} {{ $user->lastname }}
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.points.index') }}"
                        class="border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg shadow-sm text-sm font-medium transition-all focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Client Points
                    </a>
                </div>
            </div>
        </div>

        <div class="p-4 md:p-6">
            @if(session('success'))
                <div class="bg-green-50 text-green-800 rounded-lg p-4 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 text-red-800 rounded-lg p-4 mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Client Information -->
            <div class="mb-6 bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center">
                    <div class="flex-shrink-0 h-20 w-20 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 text-2xl">
                        {{ substr($user->firstname, 0, 1) }}{{ substr($user->lastname, 0, 1) }}
                    </div>
                    <div class="mt-4 md:mt-0 md:ml-6">
                        <h2 class="text-xl font-bold text-gray-900">{{ $user->firstname }} {{ $user->lastname }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <div class="mt-3 flex flex-wrap gap-3">
                            <div class="px-3 py-1 bg-primary-50 text-primary-800 rounded-full flex items-center">
                                <i class="fas fa-coins mr-2"></i>
                                <span class="font-semibold">{{ number_format($points->points_balance) }}</span>
                                <span class="ml-1 text-sm">current points</span>
                            </div>
                            <div class="px-3 py-1 bg-green-50 text-green-800 rounded-full flex items-center">
                                <i class="fas fa-trophy mr-2"></i>
                                <span class="font-semibold">{{ number_format($points->lifetime_points) }}</span>
                                <span class="ml-1 text-sm">lifetime points</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Points Adjustment Form -->
            <div class="mb-8 border border-gray-200 rounded-lg">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="font-semibold text-lg text-gray-800">Adjust Points</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.points.adjust', $user->id) }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="points" class="block text-sm font-medium text-gray-700 mb-1">
                                    Points Adjustment
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-coins text-gray-400"></i>
                                    </div>
                                    <input type="number" name="points" id="points" required
                                        class="focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                                        placeholder="Enter positive or negative value">
                                    <div class="absolute inset-y-0 right-0 flex items-center">
                                        <label for="points-type" class="sr-only">Points Type</label>
                                        <select id="points-type" name="points_type" 
                                            class="focus:ring-primary-500 focus:border-primary-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-r-md"
                                            onchange="updatePointsValue(this.value)">
                                            <option value="add">Add Points</option>
                                            <option value="deduct">Deduct Points</option>
                                        </select>
                                    </div>
                                </div>
                                @error('points')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">
                                    Enter the number of points to add or deduct.
                                </p>
                            </div>

                            <div>
                                <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">
                                    Reason for Adjustment
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="reason" id="reason" required
                                        class="focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        placeholder="Provide a reason for this adjustment">
                                </div>
                                @error('reason')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg shadow-sm text-sm font-medium transition-all focus:outline-none focus:ring-2 focus:ring-primary-500">
                                Submit Point Adjustment
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Transaction History -->
            <div class="border border-gray-200 rounded-lg">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="font-semibold text-lg text-gray-800">Transaction History</h3>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $transaction->created_at->format('M d, Y g:i A') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="{{ $transaction->points > 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                                                {{ $transaction->points > 0 ? '+' : '' }}{{ $transaction->points }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($transaction->type === 'earned')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Earned
                                                </span>
                                            @elseif($transaction->type === 'spent')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Spent
                                                </span>
                                            @elseif($transaction->type === 'adjusted')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Adjusted
                                                </span>
                                            @elseif($transaction->type === 'refunded')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    Refunded
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $transaction->description }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            No transaction history found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function updatePointsValue(type) {
        const pointsInput = document.getElementById('points');
        const value = Math.abs(parseInt(pointsInput.value) || 0);
        
        if (type === 'add') {
            pointsInput.value = value;
        } else {
            pointsInput.value = -value;
        }
    }
</script>
@endsection