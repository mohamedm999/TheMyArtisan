@extends('layouts.artisan')

@section('title', 'Artisan Profile')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-amber-800 mb-6">My Profile</h1>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Profile Information -->
                        <div class="lg:col-span-1">
                            <div class="bg-amber-50 p-6 rounded-lg shadow">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-32 h-32 rounded-full bg-amber-200 flex items-center justify-center text-amber-600 text-3xl font-bold mb-4">
                                        {{ strtoupper(substr(Auth::user()->firstname, 0, 1) . substr(Auth::user()->lastname, 0, 1)) }}
                                    </div>
                                    <h2 class="text-xl font-medium">{{ Auth::user()->firstname }}
                                        {{ Auth::user()->lastname }}</h2>
                                    <p class="text-gray-500">Artisan</p>

                                    <button
                                        class="mt-4 inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 active:bg-amber-900 focus:outline-none focus:border-amber-900 focus:ring ring-amber-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        <i class="fas fa-camera mr-2"></i> Update Photo
                                    </button>
                                </div>

                                <div class="mt-6">
                                    <h3 class="font-medium text-gray-700 mb-2">Contact Information</h3>
                                    <div class="space-y-2 text-sm">
                                        <p class="flex items-center">
                                            <i class="fas fa-envelope text-amber-600 mr-2 w-5"></i>
                                            {{ Auth::user()->email }}
                                        </p>
                                        <p class="flex items-center">
                                            <i class="fas fa-phone text-amber-600 mr-2 w-5"></i>
                                            +33 1 23 45 67 89
                                        </p>
                                        <p class="flex items-center">
                                            <i class="fas fa-map-marker-alt text-amber-600 mr-2 w-5"></i>
                                            Paris, France
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Details -->
                        <div class="lg:col-span-2">
                            <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-800">Professional Information</h3>
                                    <button
                                        class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-600 border border-transparent rounded-md font-medium text-xs uppercase tracking-widest hover:bg-amber-200 active:bg-amber-300 focus:outline-none focus:ring ring-amber-200 transition ease-in-out duration-150">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </button>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Profession</h4>
                                        <p class="mt-1">Professional Craftsman</p>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">About Me</h4>
                                        <p class="mt-1 text-sm text-gray-600">
                                            Professional with over 10 years of experience in traditional craftsmanship.
                                            I specialize in high-quality work with attention to detail and customer
                                            satisfaction.
                                            Licensed and insured, offering reliable and affordable solutions for all your
                                            needs.
                                        </p>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Skills & Expertise</h4>
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-amber-100 text-amber-800">
                                                Craftsmanship
                                            </span>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-amber-100 text-amber-800">
                                                Woodworking
                                            </span>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-amber-100 text-amber-800">
                                                Restoration
                                            </span>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-amber-100 text-amber-800">
                                                Custom Furniture
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white p-6 rounded-lg shadow border border-gray-100 mt-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-800">Work Experience</h3>
                                    <button
                                        class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-600 border border-transparent rounded-md font-medium text-xs uppercase tracking-widest hover:bg-amber-200 active:bg-amber-300 focus:outline-none focus:ring ring-amber-200 transition ease-in-out duration-150">
                                        <i class="fas fa-plus mr-1"></i> Add
                                    </button>
                                </div>

                                <div class="space-y-6">
                                    <div class="border-l-2 border-amber-500 pl-4">
                                        <h4 class="font-medium">Self-Employed Craftsman</h4>
                                        <p class="text-sm text-gray-500">2018 - Present</p>
                                        <p class="mt-1 text-sm">Providing comprehensive crafting services to residential and
                                            commercial clients.</p>
                                    </div>

                                    <div class="border-l-2 border-amber-500 pl-4">
                                        <h4 class="font-medium">Senior Craftsman, Paris Artisans Co.</h4>
                                        <p class="text-sm text-gray-500">2013 - 2018</p>
                                        <p class="mt-1 text-sm">Led a team of junior craftsmen in creating custom pieces and
                                            renovations.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white p-6 rounded-lg shadow border border-gray-100 mt-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-800">Certifications</h3>
                                    <button
                                        class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-600 border border-transparent rounded-md font-medium text-xs uppercase tracking-widest hover:bg-amber-200 active:bg-amber-300 focus:outline-none focus:ring ring-amber-200 transition ease-in-out duration-150">
                                        <i class="fas fa-plus mr-1"></i> Add
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h4 class="font-medium">Master Craftsman License</h4>
                                        <p class="text-sm text-gray-500">Issued by: French Crafts Association</p>
                                        <p class="text-sm text-gray-500">Valid until: 2025</p>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h4 class="font-medium">Traditional Methods Certification</h4>
                                        <p class="text-sm text-gray-500">Issued by: European Craft Council</p>
                                        <p class="text-sm text-gray-500">Valid until: 2024</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
