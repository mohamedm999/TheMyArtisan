@extends('layouts.artisan')

@section('title', 'My Services')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-amber-800">My Services</h1>
                        <button
                            class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 active:bg-amber-900 focus:outline-none focus:border-amber-900 focus:ring ring-amber-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-plus mr-2"></i> Add New Service
                        </button>
                    </div>

                    <!-- Services list -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Service Card 1 -->
                        <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                            <div class="h-48 bg-gray-200 relative">
                                <img src="https://via.placeholder.com/400x200" alt="Woodworking"
                                    class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2 flex space-x-2">
                                    <button
                                        class="p-1.5 bg-amber-600 rounded-full text-white hover:bg-amber-700 focus:outline-none">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button
                                        class="p-1.5 bg-red-600 rounded-full text-white hover:bg-red-700 focus:outline-none">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <span
                                    class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded mb-2">Available</span>
                                <h3 class="text-lg font-medium text-gray-800 mb-1">Custom Furniture Creation</h3>
                                <p class="text-gray-500 text-sm mb-3">Starting at €200</p>
                                <p class="text-sm text-gray-600 mb-3">Custom designed and handcrafted furniture pieces
                                    tailored to your specific needs and space.</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-amber-600 font-medium">
                                        <i class="fas fa-clock mr-1"></i> 3-5 days
                                    </span>
                                    <span class="text-sm bg-amber-50 text-amber-800 px-2 py-1 rounded">
                                        <i class="fas fa-star mr-1"></i> 4.8 (24)
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Service Card 2 -->
                        <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                            <div class="h-48 bg-gray-200 relative">
                                <img src="https://via.placeholder.com/400x200" alt="Restoration"
                                    class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2 flex space-x-2">
                                    <button
                                        class="p-1.5 bg-amber-600 rounded-full text-white hover:bg-amber-700 focus:outline-none">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button
                                        class="p-1.5 bg-red-600 rounded-full text-white hover:bg-red-700 focus:outline-none">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <span
                                    class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded mb-2">Available</span>
                                <h3 class="text-lg font-medium text-gray-800 mb-1">Antique Restoration</h3>
                                <p class="text-gray-500 text-sm mb-3">Starting at €150</p>
                                <p class="text-sm text-gray-600 mb-3">Expert restoration of antique wooden furniture using
                                    traditional methods and materials.</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-amber-600 font-medium">
                                        <i class="fas fa-clock mr-1"></i> 5-7 days
                                    </span>
                                    <span class="text-sm bg-amber-50 text-amber-800 px-2 py-1 rounded">
                                        <i class="fas fa-star mr-1"></i> 4.9 (16)
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Service Card 3 -->
                        <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                            <div class="h-48 bg-gray-200 relative">
                                <img src="https://via.placeholder.com/400x200" alt="Home Renovation"
                                    class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2 flex space-x-2">
                                    <button
                                        class="p-1.5 bg-amber-600 rounded-full text-white hover:bg-amber-700 focus:outline-none">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button
                                        class="p-1.5 bg-red-600 rounded-full text-white hover:bg-red-700 focus:outline-none">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <span
                                    class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded mb-2">Available</span>
                                <h3 class="text-lg font-medium text-gray-800 mb-1">Wooden Interior Elements</h3>
                                <p class="text-gray-500 text-sm mb-3">Starting at €300</p>
                                <p class="text-sm text-gray-600 mb-3">Custom wooden elements for home interiors including
                                    shelving, paneling, and decorative features.</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-amber-600 font-medium">
                                        <i class="fas fa-clock mr-1"></i> 7-10 days
                                    </span>
                                    <span class="text-sm bg-amber-50 text-amber-800 px-2 py-1 rounded">
                                        <i class="fas fa-star mr-1"></i> 4.7 (11)
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Service Card - Add New (placeholder) -->
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center h-80 cursor-pointer hover:bg-gray-50 transition-colors duration-150">
                            <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-plus text-amber-600 text-xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Add New Service</p>
                        </div>
                    </div>

                    <!-- Information box -->
                    <div class="bg-amber-50 p-4 rounded-lg mt-8 border border-amber-100">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-lightbulb text-amber-600 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-amber-800">Tips for creating effective service listings
                                </h3>
                                <ul class="mt-2 list-disc list-inside text-sm text-amber-700 space-y-1">
                                    <li>Use high-quality images of your work</li>
                                    <li>Be specific about what's included in your price</li>
                                    <li>Mention your turnaround time and availability</li>
                                    <li>Highlight your unique skills and expertise</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
