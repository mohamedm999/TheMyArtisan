@extends('layouts.client')

@section('title', $artisan->name . ' - Profile')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Artisan Header -->
        <div class="flex flex-col md:flex-row gap-8 mb-8">
            <div class="md:w-1/4 flex justify-center">
                <div class="mb-4">
                    @if ($artisan->profile_photo)
                        <img src="{{ asset('storage/' . $artisan->profile_photo) }}" alt="{{ $artisan->name }}"
                            class="w-48 h-48 rounded-full object-cover">
                    @else
                        <div class="w-48 h-48 bg-gray-400 rounded-full flex justify-center items-center mx-auto">
                            <span class="text-4xl font-bold text-white">{{ substr($artisan->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="md:w-3/4">
                <h1 class="text-3xl font-bold mb-2">{{ $artisan->user->firstname }}</h1>
                <div class="flex items-center mb-3">
                    <div class="flex mr-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $artisan->average_rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-gray-600">({{ $artisan->reviews_count }} reviews)</span>
                </div>
                <p class="mb-2 flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    {{ $artisan->location }}
                </p>
                <p class="mb-2 flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    {{ $artisan->speciality }}
                </p>
                <p class="mb-4 flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Member since {{ $artisan->created_at->format('M Y') }}
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#contact"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Contact
                        Artisan</a>
                    <a href="#services"
                        class="px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition">View
                        Services</a>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">About {{ $artisan->user- }}</h2>
                </div>
                <div class="px-6 py-4">
                    <p class="text-gray-700">{{ $artisan->bio }}</p>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div class="mb-8" id="services">
            <h2 class="text-2xl font-bold mb-4">Services Offered</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($artisan->services ?? [] as $service)
                    <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col h-full">
                        @if ($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" class="w-full h-48 object-cover"
                                alt="{{ $service->name }}">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                        <div class="p-4 flex-grow">
                            <h3 class="text-xl font-semibold mb-2">{{ $service->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($service->description, 100) }}</p>
                            <p class="text-green-600 font-bold text-lg mb-4">{{ number_format($service->price, 2) }} DH</p>
                            <a href="{{ route('client.services.show', $service->id) }}"
                                class="inline-block px-4 py-2 border border-green-600 text-green-600 rounded hover:bg-green-50 transition">View
                                Details</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3">
                        <p class="text-gray-500">This artisan has not listed any services yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Portfolio Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Portfolio</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($artisan->portfolioItems ?? [] as $item)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-48 object-cover"
                            alt="{{ $item->title }}">
                        <div class="p-4">
                            <h3 class="text-xl font-semibold mb-2">{{ $item->title }}</h3>
                            <p class="text-gray-600">{{ Str::limit($item->description, 100) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3">
                        <p class="text-gray-500">No portfolio items available.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Reviews</h2>
            @forelse($artisan->reviews ?? [] as $review)
                <div class="bg-white rounded-lg shadow mb-4 overflow-hidden">
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-semibold">{{ $review->user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-700">{{ $review->comment }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No reviews yet. Be the first to leave a review!</p>
            @endforelse
        </div>

        <!-- Contact Section -->
        <div id="contact">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Contact {{ $artisan->name }}</h2>
                </div>
                <div class="px-6 py-4">
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('client.contact') }}" method="POST">
                        @csrf
                        <input type="hidden" name="artisan_id" value="{{ $artisan->id }}">

                        <div class="mb-4">
                            <label for="subject" class="block text-gray-700 font-medium mb-2">Subject</label>
                            <input type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('subject') border-red-500 @enderror"
                                id="subject" name="subject" required>
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number
                                    (optional)</label>
                                <input type="tel"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                                    id="phone" name="phone">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="preferred_contact" class="block text-gray-700 font-medium mb-2">Preferred
                                    Contact Method</label>
                                <select
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('preferred_contact') border-red-500 @enderror"
                                    id="preferred_contact" name="preferred_contact">
                                    <option value="email">Email</option>
                                    <option value="phone">Phone</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
                            <textarea
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('message') border-red-500 @enderror"
                                id="message" name="message" rows="5" required></textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="schedule_date" class="block text-gray-700 font-medium mb-2">Schedule a Meeting
                                (optional)</label>
                            <input type="datetime-local"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('schedule_date') border-red-500 @enderror"
                                id="schedule_date" name="schedule_date">
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox"
                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded @error('terms') border-red-500 @enderror"
                                    id="terms" name="terms" required>
                                <label for="terms" class="ml-2 block text-sm text-gray-700">I agree to the terms and
                                    conditions</label>
                            </div>
                            @error('terms')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Send Message
                            </button>
                            <a href="{{ route('client.artisans.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Artisans
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
