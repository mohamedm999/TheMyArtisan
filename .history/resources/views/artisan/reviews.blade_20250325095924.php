@extends('layouts.artisan')

@section('title', 'My Reviews')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-amber-800 mb-6">My Reviews</h1>

                    <!-- Review Stats -->
                    <div class="bg-amber-50 rounded-lg p-4 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-4xl font-bold text-amber-600">
                                    {{ number_format($stats['average_rating'], 1) }}</div>
                                <div class="text-sm text-gray-600">Average Rating</div>
                                <div class="flex justify-center my-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($stats['average_rating']))
                                            <i class="fas fa-star text-amber-400"></i>
                                        @else
                                            <i class="far fa-star text-amber-400"></i>
                                        @endif
                                    @endfor
                                </div>
                                <div class="text-sm text-gray-600">{{ $stats['total'] }} total reviews</div>
                            </div>

                            <div class="flex flex-col justify-center">
                                <div class="flex items-center mb-1">
                                    <div class="w-24 text-sm text-gray-600">5 stars</div>
                                    <div class="flex-grow bg-gray-200 rounded-full h-2.5 mr-2">
                                        <div class="bg-amber-500 h-2.5 rounded-full"
                                            style="width: {{ $stats['total'] > 0 ? ($stats['five_stars'] / $stats['total']) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                    <div class="w-10 text-sm text-gray-600">{{ $stats['five_stars'] }}</div>
                                </div>
                                <div class="flex items-center mb-1">
                                    <div class="w-24 text-sm text-gray-600">4 stars</div>
                                    <div class="flex-grow bg-gray-200 rounded-full h-2.5 mr-2">
                                        <div class="bg-amber-500 h-2.5 rounded-full"
                                            style="width: {{ $stats['total'] > 0 ? ($stats['four_stars'] / $stats['total']) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                    <div class="w-10 text-sm text-gray-600">{{ $stats['four_stars'] }}</div>
                                </div>
                                <div class="flex items-center mb-1">
                                    <div class="w-24 text-sm text-gray-600">3 stars</div>
                                    <div class="flex-grow bg-gray-200 rounded-full h-2.5 mr-2">
                                        <div class="bg-amber-500 h-2.5 rounded-full"
                                            style="width: {{ $stats['total'] > 0 ? ($stats['three_stars'] / $stats['total']) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                    <div class="w-10 text-sm text-gray-600">{{ $stats['three_stars'] }}</div>
                                </div>
                                <div class="flex items-center mb-1">
                                    <div class="w-24 text-sm text-gray-600">2 stars</div>
                                    <div class="flex-grow bg-gray-200 rounded-full h-2.5 mr-2">
                                        <div class="bg-amber-500 h-2.5 rounded-full"
                                            style="width: {{ $stats['total'] > 0 ? ($stats['two_stars'] / $stats['total']) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                    <div class="w-10 text-sm text-gray-600">{{ $stats['two_stars'] }}</div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-24 text-sm text-gray-600">1 star</div>
                                    <div class="flex-grow bg-gray-200 rounded-full h-2.5 mr-2">
                                        <div class="bg-amber-500 h-2.5 rounded-full"
                                            style="width: {{ $stats['total'] > 0 ? ($stats['one_star'] / $stats['total']) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                    <div class="w-10 text-sm text-gray-600">{{ $stats['one_star'] }}</div>
                                </div>
                            </div>

                            <div class="flex flex-col justify-center items-center">
                                <div class="text-center mb-3">
                                    <div class="text-sm text-gray-600 mb-1">Reviews Needing Response</div>
                                    <div class="text-2xl font-bold text-amber-600">{{ $stats['pending_response'] }}</div>
                                </div>

                                @if ($stats['pending_response'] > 0)
                                    <a href="{{ route('artisan.reviews', ['filter' => 'pending']) }}"
                                        class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 active:bg-amber-800 focus:outline-none focus:border-amber-800 focus:ring ring-amber-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Respond to Reviews
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Search & Filter -->
                    <div class="mb-6">
                        <form action="{{ route('artisan.reviews') }}" method="GET"
                            class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                            <div class="flex-grow">
                                <div class="relative rounded-md shadow-sm">
                                    <input type="text" name="search" id="search" value="{{ $search ?? '' }}"
                                        class="focus:ring-amber-500 focus:border-amber-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md"
                                        placeholder="Search reviews...">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <select name="filter" id="filter"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                                    onchange="this.form.submit()">
                                    <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All Reviews</option>
                                    <option value="positive" {{ $filter == 'positive' ? 'selected' : '' }}>Positive (4-5
                                        stars)</option>
                                    <option value="neutral" {{ $filter == 'neutral' ? 'selected' : '' }}>Neutral (3 stars)
                                    </option>
                                    <option value="negative" {{ $filter == 'negative' ? 'selected' : '' }}>Negative (1-2
                                        stars)</option>
                                    <option value="pending" {{ $filter == 'pending' ? 'selected' : '' }}>Needs Response
                                    </option>
                                </select>
                            </div>
                            <div>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Filter
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Reviews List -->
                    <div class="space-y-6">
                        @forelse ($reviews as $review)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                <div class="p-4 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                @if ($review->client->avatar)
                                                    <img src="{{ asset('storage/' . $review->client->avatar) }}"
                                                        alt="{{ $review->client->firstname }}" class="h-10 w-10 rounded-full">
                                                @else
                                                    <span
                                                        class="text-gray-500 font-medium">{{ substr($review->client->firstname, 0, 1) }}{{ substr($review->client->lastname, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <h4 class="text-sm font-medium text-gray-900">
                                                    {{ $review->client->firstname }} {{ $review->client->lastname }}
                                                </h4>
                                                <p class="text-xs text-gray-500">
                                                    {{ $review->created_at->format('F d, Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="flex items-center mr-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <i class="fas fa-star text-amber-400 text-sm"></i>
                                                    @else
                                                        <i class="far fa-star text-amber-400 text-sm"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span
                                                class="text-sm font-semibold">{{ number_format($review->rating, 1) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-4">
                                    <div class="mb-3">
                                        <h5 class="text-sm font-medium text-gray-500">Service</h5>
                                        <p class="text-sm text-gray-900">{{ $review->service->name }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <h5 class="text-sm font-medium text-gray-500">Review</h5>
                                        <p class="text-sm text-gray-900">{{ $review->comment }}</p>
                                    </div>

                                    @if ($review->response)
                                        <div class="mb-3 bg-gray-50 p-3 rounded-md">
                                            <h5 class="text-sm font-medium text-gray-500">Your Response</h5>
                                            <p class="text-sm text-gray-900">{{ $review->response }}</p>
                                            <p class="text-xs text-gray-500 mt-1">Responded on
                                                {{ $review->response_date->format('F d, Y') }}</p>
                                        </div>
                                    @else
                                        <div class="mb-3">
                                            <button class="text-sm text-amber-600 hover:text-amber-800 respond-btn"
                                                data-review-id="{{ $review->id }}">
                                                <i class="fas fa-reply mr-1"></i> Respond to this review
                                            </button>
                                        </div>
                                    @endif
                                </div>

                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    @if (!$review->reported)
                                        <button class="text-xs text-gray-500 hover:text-gray-700 report-btn"
                                            data-review-id="{{ $review->id }}">
                                            <i class="fas fa-flag mr-1"></i> Report this review
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-flag mr-1"></i> Reported on
                                            {{ $review->report_date->format('F d, Y') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center p-8">
                                <i class="far fa-star text-gray-300 text-5xl mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">No Reviews Yet</h3>
                                <p class="text-gray-500">When clients leave reviews for your services, they'll appear here.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($reviews->count() > 0)
                        <div class="mt-6">
                            {{ $reviews->appends(['filter' => $filter, 'search' => $search])->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Respond Modal -->
    <div id="respondModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full"
        aria-modal="true">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Respond to Review</h3>
                <form id="respondForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="response" class="block text-sm font-medium text-gray-700 mb-1">Your Response</label>
                        <textarea id="response" name="response" rows="4"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50"
                            placeholder="Write your response to the client's review..." required></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 mt-5">
                        <button type="button" id="cancelRespond"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 focus:outline-none">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-amber-600 text-white rounded-md text-sm hover:bg-amber-700 focus:outline-none">
                            Submit Response
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Report Modal -->
    <div id="reportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full"
        aria-modal="true">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Report Review</h3>
                <form id="reportForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for
                            reporting</label>
                        <textarea id="reason" name="reason" rows="4"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50"
                            placeholder="Please explain why you're reporting this review..." required></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 mt-5">
                        <button type="button" id="cancelReport"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 focus:outline-none">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md text-sm hover:bg-red-700 focus:outline-none">
                            Report Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const respondModal = document.getElementById('respondModal');
            const reportModal = document.getElementById('reportModal');
            const respondForm = document.getElementById('respondForm');
            const reportForm = document.getElementById('reportForm');
            const cancelRespond = document.getElementById('cancelRespond');
            const cancelReport = document.getElementById('cancelReport');

            // Respond to review functionality
            document.querySelectorAll('.respond-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const reviewId = this.getAttribute('data-review-id');
                    respondForm.action = `{{ route('artisan.reviews.respond', '') }}/${reviewId}`;
                    respondModal.classList.remove('hidden');
                });
            });

            // Report review functionality
            document.querySelectorAll('.report-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const reviewId = this.getAttribute('data-review-id');
                    reportForm.action = `{{ route('artisan.reviews.report', '') }}/${reviewId}`;
                    reportModal.classList.remove('hidden');
                });
            });

            // Cancel buttons
            cancelRespond.addEventListener('click', function() {
                respondModal.classList.add('hidden');
            });

            cancelReport.addEventListener('click', function() {
                reportModal.classList.add('hidden');
            });

            // Close modals when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === respondModal) {
                    respondModal.classList.add('hidden');
                }
                if (event.target === reportModal) {
                    reportModal.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
