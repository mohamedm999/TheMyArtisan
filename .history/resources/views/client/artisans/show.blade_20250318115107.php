@extends('layouts.client')

@section('title', $artisan->name . ' - Artisan Profile')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('client.artisans.index') }}" class="inline-flex items-center text-amber-600 hover:text-amber-800">
                <i class="fas fa-arrow-left mr-2"></i> Back to All Artisans
            </a>
        </div>

        <!-- Profile Header -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="md:flex">
                <div class="md:w-1/3 h-64 md:h-auto bg-amber-50">
                    @if($artisan->artisanProfile->profile_photo)
                        <img src="{{ asset('storage/' . $artisan->artisanProfile->profile_photo) }}"
                             alt="{{ $artisan->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-amber-700">
                            <i class="fas fa-user-circle text-8xl"></i>
                        </div>
                    @endif
                </div>

                <div class="p-6 md:w-2/3">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $artisan->name }}</h1>
                            @if($artisan->artisanProfile->business_name)
                                <p class="text-lg text-gray-600 mb-2">{{ $artisan->artisanProfile->business_name }}</p>
                            @endif

                            <div class="flex items-center mt-2">
                                <div class="flex items-center text-amber-400 mr-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($averageRating))
                                            <i class="fas fa-star"></i>
                                        @elseif($i - 0.5 <= $averageRating)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-gray-600">
                                    {{ number_format($averageRating, 1) }} ({{ $reviewsCount }} reviews)
                                </span>
                            </div>
                        </div>

                        @if($artisan->artisanProfile->is_verified)
                            <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full flex items-center">
                                <i class="fas fa-check-circle mr-1"></i> Verified
                            </span>
                        @endif
                    </div>

                    <div class="grid md:grid-cols-2 gap-4 mt-6">
                        @if($artisan->artisanProfile->profession)
                            <div>
                                <p class="text-gray-700"><i class="fas fa-tools mr-2 text-amber-600"></i> {{ $artisan->artisanProfile->profession }}</p>
                            </div>
                        @endif

                        @if($artisan->artisanProfile->experience_years)
                            <div>
                                <p class="text-gray-700"><i class="fas fa-briefcase mr-2 text-amber-600"></i> {{ $artisan->artisanProfile->experience_years }} years of experience</p>
                            </div>
                        @endif

                        @if($artisan->artisanProfile->city)
                            <div>
                                <p class="text-gray-700"><i class="fas fa-map-marker-alt mr-2 text-amber-600"></i> {{ $artisan->artisanProfile->city }}</p>
                            </div>
                        @endif

                        @if($artisan->artisanProfile->hourly_rate)
                            <div>
                                <p class="text-gray-700"><i class="fas fa-euro-sign mr-2 text-amber-600"></i> Starting at €{{ $artisan->artisanProfile->hourly_rate }}/hour</p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-8">
                        <a href="#book-service" class="inline-block px-6 py-3 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition-colors mr-4">
                            Book a Service
                        </a>
                        <a href="#contact" class="inline-block px-6 py-3 bg-white border border-amber-600 text-amber-600 rounded-md hover:bg-amber-50 transition-colors">
                            Contact
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="mb-6 border-b border-gray-200">
            <div class="flex overflow-x-auto">
                <button class="tab-button active px-4 py-2 font-medium text-amber-600 border-b-2 border-amber-600"
                        onclick="switchTab('about')">About</button>
                <button class="tab-button px-4 py-2 font-medium text-gray-500 hover:text-amber-600"
                        onclick="switchTab('services')">Services</button>
                <button class="tab-button px-4 py-2 font-medium text-gray-500 hover:text-amber-600"
                        onclick="switchTab('experience')">Experience & Certifications</button>
                <button class="tab-button px-4 py-2 font-medium text-gray-500 hover:text-amber-600"
                        onclick="switchTab('reviews')">Reviews</button>
            </div>
        </div>

        <!-- About Tab -->
        <div id="about" class="tab-content bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">About {{ $artisan->name }}</h2>

            @if($artisan->artisanProfile->about_me)
                <div class="prose max-w-none">
                    <p>{{ $artisan->artisanProfile->about_me }}</p>
                </div>
            @else
                <p class="text-gray-500 italic">No information provided.</p>
            @endif

            <div class="mt-8 grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Skills</h3>
                    @if($artisan->artisanProfile->skills && is_array($artisan->artisanProfile->skills))
                        <div class="flex flex-wrap gap-2">
                            @foreach($artisan->artisanProfile->skills as $skill)
                                <span class="bg-amber-100 text-amber-800 text-xs px-3 py-1 rounded-full">{{ $skill }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">No skills listed.</p>
                    @endif
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Contact Information</h3>
                    <div class="space-y-2">
                        @if($artisan->email)
                            <p class="text-gray-700"><i class="fas fa-envelope mr-2 text-amber-600"></i> {{ $artisan->email }}</p>
                        @endif

                        @if($artisan->artisanProfile->phone)
                            <p class="text-gray-700"><i class="fas fa-phone mr-2 text-amber-600"></i> {{ $artisan->artisanProfile->phone }}</p>
                        @endif

                        @if($artisan->artisanProfile->fullAddress)
                            <p class="text-gray-700"><i class="fas fa-map-marker-alt mr-2 text-amber-600"></i> {{ $artisan->artisanProfile->fullAddress }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Tab -->
        <div id="services" class="tab-content bg-white rounded-lg shadow-md p-6 mb-8 hidden">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Services</h2>

            @if($services->count() > 0)
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($services as $service)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="h-48 bg-gray-200">
                                @if($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}"
                                         alt="{{ $service->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-amber-600">
                                        <i class="fas fa-tools text-5xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $service->name }}</h3>
                                    <span class="bg-amber-100 text-amber-800 text-sm px-3 py-1 rounded-full">
                                        €{{ number_format($service->price, 2) }}
                                    </span>
                                </div>
                                <p class="text-gray-600 mb-4">{{ Str::limit($service->description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">
                                        <i class="far fa-clock mr-1"></i> {{ $service->duration }} minutes
                                    </span>
                                    <button class="px-4 py-2 bg-amber-600 text-white text-sm rounded hover:bg-amber-700 transition-colors book-service-btn"
                                            data-service-id="{{ $service->id }}"
                                            data-service-name="{{ $service->name }}">
                                        Book Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">This artisan has no services listed yet.</p>
            @endif
        </div>

        <!-- Experience & Certifications Tab -->
        <div id="experience" class="tab-content bg-white rounded-lg shadow-md p-6 mb-8 hidden">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Experience & Qualifications</h2>

            <div class="mb-8">
                <h3 class="text-xl font-medium text-gray-900 mb-4">Work Experience</h3>
                @if($workExperiences->count() > 0)
                    <div class="space-y-6 relative">
                        @foreach($work as $work)
                            <div class="relative pl-8 pb-6 border-l-2 border-amber-200 last:border-0 last:pb-0">
                                <div class="absolute top-0 -left-2 w-4 h-4 rounded-full bg-amber-500"></div>
                                <div class="mb-1">
                                    <h4 class="text-lg font-medium text-gray-900">{{ $work->position }}</h4>
                                    <p class="text-amber-600">{{ $work->company }}</p>
                                </div>
                                <div class="text-sm text-gray-600 mb-3">
                                    {{ $work->start_date->format('M Y') }} -
                                    {{ $work->end_date ? $work->end_date->format('M Y') : 'Present' }}
                                    ({{ $work->start_date->diffInYears($work->end_date ?? now()) }} years)
                                </div>
                                @if($work->description)
                                    <p class="text-gray-700">{{ $work->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">No work experience listed.</p>
                @endif
            </div>

            <div>
                <h3 class="text-xl font-medium text-gray-900 mb-4">Certifications</h3>
                @if($certifications->count() > 0)
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach($certifications as $cert)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="font-medium text-gray-900">{{ $cert->name }}</h4>
                                <p class="text-gray-600">{{ $cert->issuing_organization }}</p>
                                @if($cert->issue_date)
                                    <p class="text-sm text-gray-500">Issued: {{ $cert->issue_date->format('M Y') }}</p>
                                @endif
                                @if($cert->expiration_date)
                                    <p class="text-sm text-amber-600">
                                        {{ $cert->expiration_date->isFuture() ? 'Expires' : 'Expired' }}:
                                        {{ $cert->expiration_date->format('M Y') }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">No certifications listed.</p>
                @endif
            </div>
        </div>

        <!-- Reviews Tab -->
        <div id="reviews" class="tab-content bg-white rounded-lg shadow-md p-6 mb-8 hidden">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-900">Reviews</h2>
                <div class="flex items-center">
                    <div class="flex items-center text-amber-400 mr-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($averageRating))
                                <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= $averageRating)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="font-medium">{{ number_format($averageRating, 1) }} / 5</span>
                    <span class="text-gray-500 ml-2">({{ $reviewsCount }} reviews)</span>
                </div>
            </div>

            @if($reviews->count() > 0)
                <div class="space-y-6">
                    @foreach($reviews as $review)
                        <div class="border-b border-gray-200 pb-6 last:border-0">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-start">
                                    <div class="mr-4">
                                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $review->customer->name }}</p>
                                        <div class="flex items-center mt-1">
                                            <div class="flex items-center text-amber-400 mr-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="ml-14">
                                <p class="text-gray-700">{{ $review->comment }}</p>

                                @if($review->response)
                                    <div class="mt-4 bg-gray-50 p-3 rounded-md">
                                        <p class="text-sm font-medium text-gray-900">Response from {{ $artisan->name }}</p>
                                        <p class="text-sm text-gray-700 mt-1">{{ $review->response }}</p>
                                        @if($review->response_date)
                                            <p class="text-xs text-gray-500 mt-1">{{ $review->response_date->format('M d, Y') }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $reviews->links() }}
                </div>
            @else
                <p class="text-gray-500 italic">This artisan has no reviews yet.</p>
            @endif
        </div>

        <!-- Book Service Modal -->
        <div id="bookServiceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 text-center">Book a Service</h3>
                    <form id="bookingForm" action="{{ route('client.bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" id="serviceId">
                        <input type="hidden" name="artisan_id" value="{{ $artisan->id }}">

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Service</label>
                            <div id="serviceName" class="py-2 px-3 bg-gray-100 rounded text-gray-800"></div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="booking_date">
                                Date
                            </label>
                            <input type="date" id="booking_date" name="date"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   min="{{ now()->format('Y-m-d') }}"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Available Time Slots
                            </label>
                            <div id="availableTimeSlots" class="border rounded p-3 max-h-40 overflow-y-auto">
                                <p class="text-gray-500 italic">Select a date to see available times</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="notes">
                                Notes (Optional)
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                      placeholder="Any special requirements or information"></textarea>
                        </div>

                        <div class="flex justify-end space-x-3 mt-5">
                            <button type="button" onclick="toggleBookingModal(false)"
                                    class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 focus:outline-none">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-amber-600 text-white rounded-md text-sm hover:bg-amber-700 focus:outline-none">
                                Book Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Modal -->
        <div id="contactModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 text-center">Contact {{ $artisan->name }}</h3>
                    <form id="contactForm" action="{{ route('client.messages.send') }}" method="POST">
                        @csrf
                        <input type="hidden" name="recipient_id" value="{{ $artisan->id }}">

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="subject">
                                Subject
                            </label>
                            <input type="text" id="subject" name="subject"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   placeholder="What is this about?" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="message">
                                Message
                            </label>
                            <textarea id="message" name="message" rows="5"
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                      placeholder="Your message..." required></textarea>
                        </div>

                        <div class="flex justify-end space-x-3 mt-5">
                            <button type="button" onclick="toggleContactModal(false)"
                                    class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 focus:outline-none">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-amber-600 text-white rounded-md text-sm hover:bg-amber-700 focus:outline-none">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Tab switching functionality
    function switchTab(tabId) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        // Remove active class from all tab buttons
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active', 'text-amber-600', 'border-b-2', 'border-amber-600');
            button.classList.add('text-gray-500');
        });

        // Show the selected tab
        document.getElementById(tabId).classList.remove('hidden');

        // Add active class to the clicked button
        document.querySelector(`[onclick="switchTab('${tabId}')"]`).classList.add('active', 'text-amber-600', 'border-b-2', 'border-amber-600');
    }

    // Book service modal functionality
    function toggleBookingModal(show, serviceId = null, serviceName = '') {
        const modal = document.getElementById('bookServiceModal');

        if (show) {
            document.getElementById('serviceId').value = serviceId;
            document.getElementById('serviceName').textContent = serviceName;
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    // Contact modal functionality
    function toggleContactModal(show) {
        const modal = document.getElementById('contactModal');

        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Setup service booking buttons
        document.querySelectorAll('.book-service-btn').forEach(button => {
            button.addEventListener('click', function() {
                const serviceId = this.getAttribute('data-service-id');
                const serviceName = this.getAttribute('data-service-name');
                toggleBookingModal(true, serviceId, serviceName);
            });
        });

        // Setup contact button
        const contactBtn = document.querySelector('a[href="#contact"]');
        if (contactBtn) {
            contactBtn.addEventListener('click', function(e) {
                e.preventDefault();
                toggleContactModal(true);
            });
        }

        // Date change for available time slots
        document.getElementById('booking_date').addEventListener('change', function() {
            const date = this.value;
            const serviceId = document.getElementById('serviceId').value;
            const artisanId = '{{ $artisan->id }}';

            // Show loading state
            document.getElementById('availableTimeSlots').innerHTML = '<p class="text-gray-500">Loading available times...</p>';

            // Fetch available time slots for selected date
            fetch(`/api/availability?date=${date}&service_id=${serviceId}&artisan_id=${artisanId}`)
                .then(response => response.json())
                .then(data => {
                    const slotsContainer = document.getElementById('availableTimeSlots');

                    if (data.slots && data.slots.length > 0) {
                        let html = '<div class="grid grid-cols-2 gap-2">';
                        data.slots.forEach(slot => {
                            html += `
                                <label class="flex items-center p-2 bg-amber-50 rounded border border-amber-200 hover:bg-amber-100 cursor-pointer">
                                    <input type="radio" name="time_slot_id" value="${slot.id}" required class="text-amber-600 focus:ring-amber-500">
                                    <span class="ml-2 text-sm">${slot.start_time} - ${slot.end_time}</span>
                                </label>
                            `;
                        });
                        html += '</div>';
                        slotsContainer.innerHTML = html;
                    } else {
                        slotsContainer.innerHTML = '<p class="text-gray-500 italic">No available time slots for this date</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching time slots:', error);
                    document.getElementById('availableTimeSlots').innerHTML =
                        '<p class="text-red-500">Error loading available times. Please try again.</p>';
                });
        });
    });
</script>
@endsection
