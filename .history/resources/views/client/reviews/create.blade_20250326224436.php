@extends('layouts.client')

@section('title', 'Submit Review')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Display any session errors at the top of the page -->
        @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-900">Review Your Experience</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Please share your feedback for the service provided by
                        {{ $booking->artisanProfile->user->firstname }} {{ $booking->artisanProfile->user->lastname }}
                    </p>
                </div>

                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('client.reviews.store', ['id' => $booking->id]) }}" method="POST">
                        @csrf

                        <!-- Add a hidden debug field -->
                        <input type="hidden" name="debug_submission" value="1">

                        <div class="mb-6">
                            <h2 class="text-lg font-medium text-gray-900">{{ $booking->service->name }}</h2>
                            <p class="text-sm text-gray-600">Completed on
                                {{ \Carbon\Carbon::parse($booking->completed_at)->format('M d, Y') }}</p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                            <div class="flex items-center">
                                <div class="star-rating flex items-center">
                                    <input type="radio" id="star5" name="rating" value="5" class="hidden" {{ old('rating') == 5 ? 'checked' : '' }} />
                                    <label for="star5" class="cursor-pointer text-2xl px-1">★</label>

                                    <input type="radio" id="star4" name="rating" value="4" class="hidden" {{ old('rating') == 4 ? 'checked' : '' }} />
                                    <label for="star4" class="cursor-pointer text-2xl px-1">★</label>

                                    <input type="radio" id="star3" name="rating" value="3" class="hidden" {{ old('rating') == 3 ? 'checked' : '' }} />
                                    <label for="star3" class="cursor-pointer text-2xl px-1">★</label>

                                    <input type="radio" id="star2" name="rating" value="2" class="hidden" {{ old('rating') == 2 ? 'checked' : '' }} />
                                    <label for="star2" class="cursor-pointer text-2xl px-1">★</label>

                                    <input type="radio" id="star1" name="rating" value="1" class="hidden" {{ old('rating') == 1 ? 'checked' : '' }} />
                                    <label for="star1" class="cursor-pointer text-2xl px-1">★</label>
                                </div>
                                <span id="rating-text" class="ml-2 text-sm font-medium text-gray-700">Select a rating</span>
                            </div>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
                            <textarea id="comment" name="comment" rows="4"
                                class="shadow-sm block w-full focus:ring-green-500 focus:border-green-500 sm:text-sm border border-gray-300 rounded-md"
                                placeholder="Please share your experience with this service...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end pt-5">
                            <a href="{{ route('client.bookings.show', $booking->id) }}"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Cancel
                            </a>
                            <button type="submit"
                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ratingLabels = document.querySelectorAll('.star-rating label');
            const ratingInputs = document.querySelectorAll('.star-rating input');
            const ratingText = document.getElementById('rating-text');

            const ratingDescriptions = {
                5: 'Excellent - I\'m extremely satisfied',
                4: 'Good - I\'m satisfied',
                3: 'Average - It was okay',
                2: 'Below average - I\'m somewhat disappointed',
                1: 'Poor - I\'m very disappointed'
            };

            // Initialize labels as empty stars
            ratingLabels.forEach(label => {
                label.classList.add('text-gray-300');
            });

            // Add event listeners to stars
            ratingLabels.forEach((label, index) => {
                label.addEventListener('mouseover', function() {
                    // Reset all stars
                    ratingLabels.forEach(l => l.classList.remove('text-yellow-400',
                        'text-gray-300'));

                    // Fill stars up to current
                    for (let i = 0; i <= index; i++) {
                        ratingLabels[i].classList.add('text-yellow-400');
                    }

                    // Empty stars after current
                    for (let i = index + 1; i < ratingLabels.length; i++) {
                        ratingLabels[i].classList.add('text-gray-300');
                    }
                });

                label.addEventListener('click', function() {
                    const value = 5 - index;
                    ratingInputs[index].checked = true;
                    ratingText.textContent = ratingDescriptions[value];
                });
            });

            // Reset stars when mouse leaves the container
            document.querySelector('.star-rating').addEventListener('mouseleave', function() {
                ratingLabels.forEach((label, index) => {
                    label.classList.remove('text-yellow-400', 'text-gray-300');

                    // Check if corresponding input is checked
                    const value = 5 - index;
                    const input = document.querySelector(`.star-rating input[value="${value}"]`);

                    if (input.checked) {
                        // Fill stars up to the selected rating
                        for (let i = 0; i <= index; i++) {
                            ratingLabels[i].classList.add('text-yellow-400');
                        }

                        // Empty stars after the selected rating
                        for (let i = index + 1; i < ratingLabels.length; i++) {
                            ratingLabels[i].classList.add('text-gray-300');
                        }
                    } else {
                        label.classList.add('text-gray-300');
                    }
                });
            });
        });
    </script>
@endsection
