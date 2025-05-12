@extends('layouts.admin')

@section('title', 'Review Details')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Review Details</h1>
            <p class="text-gray-500">View and manage review information</p>
        </div>
        <div>
            <a href="{{ route('admin.reviews.index') }}"
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md">
                <i class="fas fa-arrow-left mr-1"></i> Back to Reviews
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-700">Review Content</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 mr-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>

                    <p class="text-gray-700 mb-6">{{ $review->comment }}</p>

                    @if ($review->response)
                        <div class="bg-blue-50 p-4 rounded-lg mb-4">
                            <h4 class="text-sm font-semibold text-blue-600 mb-2">Artisan Response:</h4>
                            <p class="text-gray-700">{{ $review->response }}</p>
                            <div class="text-xs text-gray-500 mt-2">
                                {{ $review->response_date ? $review->response_date->format('M d, Y') : '' }}
                            </div>
                        </div>
                    @endif

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-medium text-gray-700 mb-3">Update Status</h4>
                        <form action="{{ route('admin.reviews.status', $review->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="flex flex-wrap gap-3">
                                <button type="submit" name="status" value="published"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                                    <i class="fas fa-eye mr-1"></i> Publish
                                </button>
                                <button type="submit" name="status" value="hidden"
                                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                                    <i class="fas fa-eye-slash mr-1"></i> Hide
                                </button>
                                <button type="submit" name="status" value="reported"
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                                    <i class="fas fa-flag mr-1"></i> Mark Reported
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-700">Client Information</h3>
                </div>
                <div class="p-6">
                    @if ($review->client)
                        <div class="flex items-center mb-4">
                            <div
                                class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 mr-3">
                                @if ($review->client->profile_photo_path)
                                    <img src="{{ asset('storage/' . $review->client->profile_photo_path) }}"
                                        class="h-12 w-12 rounded-full object-cover" alt="{{ $review->client->firstname }}">
                                @else
                                    <i class="fas fa-user text-lg"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $review->client->firstname }}
                                    {{ $review->client->lastname }}</h4>
                                <p class="text-sm text-gray-500">{{ $review->client->email }}</p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="block text-xs uppercase tracking-wide text-gray-500 mb-1">Member Since</label>
                            <p>{{ $review->client->created_at->format('M d, Y') }}</p>
                        </div>
                        <a href="{{ route('admin.users.show', $review->client->id) }}"
                            class="text-primary-600 hover:underline text-sm">
                            View Full Profile
                        </a>
                    @else
                        <p class="text-gray-500">Client information not available</p>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-700">Artisan Information</h3>
                </div>
                <div class="p-6">
                    @if ($review->artisanProfile && $review->artisanProfile->user)
                        <div class="flex items-center mb-4">
                            <div
                                class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 mr-3">
                                @if ($review->artisanProfile->user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $review->artisanProfile->user->profile_photo_path) }}"
                                        class="h-12 w-12 rounded-full object-cover"
                                        alt="{{ $review->artisanProfile->user->firstname }}">
                                @else
                                    <i class="fas fa-user-tie text-lg"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $review->artisanProfile->user->firstname }}
                                    {{ $review->artisanProfile->user->lastname }}</h4>
                                <p class="text-sm text-gray-500">
                                    {{ $review->artisanProfile->profession ?? 'No profession listed' }}</p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="block text-xs uppercase tracking-wide text-gray-500 mb-1">Average Rating</label>
                            <div class="flex items-center">
                                <div class="flex text-yellow-400 mr-1">
                                    <i class="fas fa-star"></i>
                                </div>
                                <span>{{ number_format($review->artisanProfile->rating ?? 0, 1) }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.artisans.show', $review->artisanProfile->user_id) }}"
                            class="text-primary-600 hover:underline text-sm">
                            View Full Profile
                        </a>
                    @else
                        <p class="text-gray-500">Artisan information not available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
