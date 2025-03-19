@extends('layouts.app')

@section('title', 'About MyArtisan - Our Mission & Vision')
@section('description', 'Learn about MyArtisan\'s mission to preserve Moroccan craft traditions and empower local
    artisans through sustainable digital infrastructure.')

@section('content')
    <div class="bg-amber-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Hero section -->
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl font-bold text-amber-800 mb-6">About MyArtisan</h1>
            <p class="text-lg text-gray-700 max-w-3xl mx-auto">
                Connecting skilled artisans with appreciative customers, preserving heritage crafts for future generations.
            </p>
        </div>
    </div>

    <!-- Our Story Section -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
                    <p class="text-gray-600 mb-4">
                        Founded in {{ date('Y') - 2 }}, MyArtisan was born from a deep appreciation for Morocco's rich
                        cultural heritage
                        and concern over the declining traditional craft sector. Our founder, after traveling throughout
                        Morocco's historic cities, witnessed firsthand the challenges faced by talented artisans
                        struggling to connect with modern markets.
                    </p>
                    <p class="text-gray-600 mb-4">
                        We set out to build a bridge between these master craftspeople and global customers who value
                        authenticity, quality, and cultural significance in the products they purchase.
                    </p>
                    <p class="text-gray-600">
                        Today, MyArtisan serves as both a marketplace and a cultural preservation initiative,
                        documenting techniques and supporting the next generation of Moroccan artisans.
                    </p>
                </div>
                <div class="relative h-96 rounded-lg overflow-hidden shadow-xl">
                    <img src="{{ asset('images/about/workshop.jpg') }}" alt="Moroccan Artisan Workshop"
                        class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>

    <!-- Mission & Values Section -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-amber-50">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Our Mission & Values</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-handshake text-amber-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Preserve & Promote</h3>
                    <p class="text-gray-600">
                        We are committed to documenting and preserving traditional Moroccan craftsmanship techniques
                        while promoting their cultural and artistic value to global audiences.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-users text-amber-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Empower Artisans</h3>
                    <p class="text-gray-600">
                        We provide artisans with digital tools, business training, and direct market access
                        to ensure fair compensation for their skills and knowledge.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-leaf text-amber-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Sustainable Practices</h3>
                    <p class="text-gray-600">
                        We encourage environmentally responsible production methods that honor traditional
                        techniques while adapting to modern sustainability standards.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Our Team</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Team Member 1 -->
                <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md text-center">
                    <div class="h-64 bg-gray-200">
                        <img src="{{ asset('images/team/team-1.jpg') }}" alt="Team Member"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Hassan El Mansouri</h3>
                        <p class="text-amber-600 mb-3">Founder & CEO</p>
                        <p class="text-gray-600 mb-4">
                            With deep roots in Fes, Hassan bridges traditional craftsmanship with modern business
                            approaches.
                        </p>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md text-center">
                    <div class="h-64 bg-gray-200">
                        <img src="{{ asset('images/team/team-2.jpg') }}" alt="Team Member"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Amina Berrada</h3>
                        <p class="text-amber-600 mb-3">Creative Director</p>
                        <p class="text-gray-600 mb-4">
                            A textile designer by training, Amina ensures authentic representation of Moroccan aesthetics.
                        </p>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md text-center">
                    <div class="h-64 bg-gray-200">
                        <img src="{{ asset('images/team/team-3.jpg') }}" alt="Team Member"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Youssef El Alami</h3>
                        <p class="text-amber-600 mb-3">Artisan Relations</p>
                        <p class="text-gray-600 mb-4">
                            Former master craftsman who now helps onboard and train artisans across Morocco.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-amber-600">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Join Our Mission</h2>
            <p class="text-lg text-amber-100 mb-8">
                Whether you're an artisan looking to share your craft, or a customer seeking authentic Moroccan
                craftsmanship,
                we invite you to be part of our community.
            </p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 justify-center">
                <a href="{{ route('register') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-amber-700 bg-white hover:bg-amber-50 shadow-md">
                    Join as Artisan
                </a>
                <a href="{{ route('client.artisans.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-amber-700 shadow-md">
                    Browse Artisans
                </a>
            </div>
        </div>
    </div>
@endsection
