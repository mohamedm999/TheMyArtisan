@extends('layouts.app')

@section('title', 'Contact Us - MyArtisan')
@section('description', 'Get in touch with MyArtisan for questions about our platform, artisan services, or partnership
    opportunities.')

@section('content')
    <div class="bg-amber-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Hero section -->
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl font-bold text-amber-800 mb-6">Contact Us</h1>
            <p class="text-lg text-gray-700 max-w-3xl mx-auto">
                Have questions about MyArtisan? We're here to help you connect with incredible Moroccan artisans.
            </p>
        </div>
    </div>

    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h2>

                    @if (session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First
                                    Name</label>
                                <input type="text" id="first_name" name="first_name"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                    required>
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last
                                    Name</label>
                                <input type="text" id="last_name" name="last_name"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                    required>
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" id="email" name="email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <select id="subject" name="subject"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                required>
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="artisan">Becoming an Artisan</option>
                                <option value="booking">Booking Help</option>
                                <option value="partnership">Partnership Opportunities</option>
                                <option value="feedback">Feedback</option>
                                <option value="other">Other</option>
                            </select>
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Your Message</label>
                            <textarea id="message" name="message" rows="5"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                                required></textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-start">
                            <input id="privacy" name="privacy" type="checkbox"
                                class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded" required>
                            <label for="privacy" class="ml-2 text-sm text-gray-600">
                                I agree to the processing of my data as per the <a href="{{ route('privacy') }}"
                                    class="text-amber-600 hover:text-amber-500">Privacy Policy</a>.
                            </label>
                        </div>

                        <div>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Contact Information -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Information</h2>

                    <div class="bg-amber-50 rounded-lg p-6 mb-8">
                        <div class="flex items-start mb-6">
                            <div class="flex-shrink-0 mt-1">
                                <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-amber-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Our Location</h3>
                                <p class="mt-1 text-gray-600">
                                    123 Place de l'Artisanat<br>
                                    Marrakech, 40000<br>
                                    Morocco
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start mb-6">
                            <div class="flex-shrink-0 mt-1">
                                <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center">
                                    <i class="fas fa-envelope text-amber-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Email Us</h3>
                                <p class="mt-1 text-gray-600">
                                    General Inquiries: <a href="mailto:info@myartisan.ma"
                                        class="text-amber-600 hover:text-amber-500">info@myartisan.ma</a><br>
                                    Support: <a href="mailto:support@myartisan.ma"
                                        class="text-amber-600 hover:text-amber-500">support@myartisan.ma</a><br>
                                    Artisan Relations: <a href="mailto:artisans@myartisan.ma"
                                        class="text-amber-600 hover:text-amber-500">artisans@myartisan.ma</a>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center">
                                    <i class="fas fa-phone-alt text-amber-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Call Us</h3>
                                <p class="mt-1 text-gray-600">
                                    Main Office: +212 5XX-XXXXX<br>
                                    Customer Support: +212 6XX-XXXXX
                                </p>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Business Hours</h3>
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Monday - Friday:</span>
                                <span class="font-medium">9:00 AM - 6:00 PM</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Saturday:</span>
                                <span class="font-medium">10:00 AM - 4:00 PM</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sunday:</span>
                                <span class="font-medium">Closed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Find Us</h2>

            <div class="h-96 rounded-lg overflow-hidden shadow-md">
                <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=-8.017120361328125%2C31.60218361617291%2C-7.973690032958986%2C31.627468431213958&amp;layer=mapnik"
                    style="border: 1px solid #ddd">
                </iframe>
            </div>
        </div>
    </div>
@endsection
