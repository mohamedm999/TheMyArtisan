@extends('layouts.artisan')

@section('title', 'My Bookings')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-amber-800 mb-6">My Bookings</h1>

                    <!-- Booking Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-6">
                            <a href="#"
                                class="border-amber-500 text-amber-600 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                Pending (3)
                            </a>
                            <a href="#"
                                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                Confirmed (2)
                            </a>
                            <a href="#"
                                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                In Progress (1)
                            </a>
                            <a href="#"
                                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                Completed (12)
                            </a>
                            <a href="#"
                                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                Cancelled (2)
                            </a>
                        </nav>
                    </div>

                    <!-- Booking Items -->
                    <div class="space-y-4">
                        <!-- Booking Item 1 -->
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                            <div class="flex flex-col md:flex-row">
                                <div class="md:w-1/4 bg-gray-50 p-4 flex flex-col justify-between">
                                    <div>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                        <h3 class="text-lg font-medium text-gray-900 mt-2">Custom Dining Table</h3>
                                        <p class="text-sm text-gray-500 mt-1">Service ID: #SRV-2845</p>
                                    </div>
                                    <div class="mt-4 md:mt-0">
                                        <p class="text-sm font-medium text-gray-500">Price</p>
                                        <p class="text-lg font-semibold text-amber-600">€450</p>
                                    </div>
                                </div>

                                <div class="md:w-2/4 p-4 border-t md:border-t-0 md:border-l md:border-r border-gray-200">
                                    <div class="flex items-center mb-3">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500 font-medium">JD</span>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-sm font-medium text-gray-900">Jean Dupont</h4>
                                            <p class="text-sm text-gray-500">Paris, France</p>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-calendar text-amber-500 mr-2 w-4"></i>
                                            <span>Requested for: <strong>November 15, 2023</strong></span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-clock text-amber-500 mr-2 w-4"></i>
                                            <span>Estimated completion: <strong>7-10 days</strong></span>
                                        </div>
                                        <div class="flex items-start text-sm">
                                            <i class="fas fa-comment-alt text-amber-500 mr-2 w-4 mt-1"></i>
                                            <p class="text-gray-600">Custom dining table made from oak with natural finish,
                                                seating for 6 people.</p>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="md:w-1/4 p-4 bg-gray-50 border-t md:border-t-0 md:border-l border-gray-200 flex flex-col justify-between">
                                    <div class="text-sm text-gray-500">
                                        <p>Requested: <span class="text-gray-900">Nov 5, 2023</span></p>
                                    </div>

                                    <div class="mt-4 space-y-2">
                                        <button
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none">
                                            Accept
                                        </button>
                                        <button
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                            Decline
                                        </button>
                                        <button
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-amber-600 bg-white hover:bg-gray-50 focus:outline-none">
                                            <i class="fas fa-comment mr-2"></i> Message
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Item 2 -->
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                            <div class="flex flex-col md:flex-row">
                                <div class="md:w-1/4 bg-gray-50 p-4 flex flex-col justify-between">
                                    <div>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                        <h3 class="text-lg font-medium text-gray-900 mt-2">Antique Chair Restoration</h3>
                                        <p class="text-sm text-gray-500 mt-1">Service ID: #SRV-2857</p>
                                    </div>
                                    <div class="mt-4 md:mt-0">
                                        <p class="text-sm font-medium text-gray-500">Price</p>
                                        <p class="text-lg font-semibold text-amber-600">€180</p>
                                    </div>
                                </div>

                                <div class="md:w-2/4 p-4 border-t md:border-t-0 md:border-l md:border-r border-gray-200">
                                    <div class="flex items-center mb-3">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500 font-medium">ML</span>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-sm font-medium text-gray-900">Marie Lambert</h4>
                                            <p class="text-sm text-gray-500">Lyon, France</p>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-calendar text-amber-500 mr-2 w-4"></i>
                                            <span>Requested for: <strong>November 20, 2023</strong></span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-clock text-amber-500 mr-2 w-4"></i>
                                            <span>Estimated completion: <strong>5-7 days</strong></span>
                                        </div>
                                        <div class="flex items-start text-sm">
                                            <i class="fas fa-comment-alt text-amber-500 mr-2 w-4 mt-1"></i>
                                            <p class="text-gray-600">Restoration of 19th century dining chair, repair broken
                                                leg and refinish.</p>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="md:w-1/4 p-4 bg-gray-50 border-t md:border-t-0 md:border-l border-gray-200 flex flex-col justify-between">
                                    <div class="text-sm text-gray-500">
                                        <p>Requested: <span class="text-gray-900">Nov 7, 2023</span></p>
                                    </div>

                                    <div class="mt-4 space-y-2">
                                        <button
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none">
                                            Accept
                                        </button>
                                        <button
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                            Decline
                                        </button>
                                        <button
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-amber-600 bg-white hover:bg-gray-50 focus:outline-none">
                                            <i class="fas fa-comment mr-2"></i> Message
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        <nav class="flex items-center justify-between">
                            <div class="flex-1 flex justify-between sm:hidden">
                                <a href="#"
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Previous
                                </a>
                                <a href="#"
                                    class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Next
                                </a>
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Showing <span class="font-medium">1</span> to <span class="font-medium">2</span> of
                                        <span class="font-medium">20</span> bookings
                                    </p>
                                </div>
                                <div>
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                        aria-label="Pagination">
                                        <a href="#"
                                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                        <a href="#" aria-current="page"
                                            class="z-10 bg-amber-50 border-amber-500 text-amber-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                            1
                                        </a>
                                        <a href="#"
                                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                            2
                                        </a>
                                        <a href="#"
                                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                            3
                                        </a>
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                            ...
                                        </span>
                                        <a href="#"
                                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                            5
                                        </a>
                                        <a href="#"
                                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </nav>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
