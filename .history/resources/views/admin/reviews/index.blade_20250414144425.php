@extends('layouts.admin')

@section('title', 'Manage Reviews')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manage Reviews</h1>
        <p class="text-gray-500">View and manage customer reviews for artisans</p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h3 class="text-lg font-medium text-gray-700">All Reviews</h3>
                <div class="mt-2 md:mt-0">
                    <form action="{{ route('admin.reviews.index') }}" method="GET" class="flex items-center">
                        <select name="filter" class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 mr-2">
                            <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All Reviews</option>
                            <option value="published" {{ request('filter') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="hidden" {{ request('filter') == 'hidden' ? 'selected' : '' }}>Hidden</option>
                            <option value="reported" {{ request('filter') == 'reported' ? 'selected' : '' }}>Reported</option>
                        </select>
                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-md">
                            Filter
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Artisan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rating
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($reviews as $review)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $review->id }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($review->client)
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $review->client->firstname }} {{ $review->client->lastname }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $review->client->email }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-500">Unknown Client</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($review->artisanProfile)
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $review->artisanProfile->user->firstname ?? '' }} {{ $review->artisanProfile->user->lastname ?? '' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $review->artisanProfile->profession ?? 'No profession listed' }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-500">Unknown Artisan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-yellow-500 mr-1">
                                        <i class="fas fa-star"></i>
                                    </span>
                                    <span class="text-sm text-gray-900">{{ $review->rating }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($review->status === 'published')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Published
                                    </span>
                                @elseif ($review->status === 'hidden')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Hidden
                                    </span>
                                @elseif ($review->status === 'reported')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Reported
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $review->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.reviews.show', $review->id) }}" class="text-primary-600 hover:text-primary-900">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No reviews found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $reviews->links() }}
        </div>
    </div>
@endsection