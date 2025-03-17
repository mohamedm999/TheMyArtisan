@extends('layouts.artisan')

@section('title', 'My Reviews')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-amber-800 mb-6">My Reviews</h1>

                    <!-- Reviews Summary -->
                    <div class="bg-amber-50 rounded-lg p-6 mb-6">
                        <div class="flex flex-col md:flex-row md:items-center">
                            <div class="md:w-1/4 flex flex-col items-center mb-4 md:mb-0">
                                <div class="text-5xl font-bold text-amber-700">4.8</div>
                                <div class="flex text-amber-500 my-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <div class="text-sm text-gray-600">Based on 42 reviews</div>
                            </div>

                            <div class="md:w-3/4 md:pl-6 md:border-l border-amber-200">
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <span class="text-sm w-16">5 stars</span>
                                        <div class="flex-1 h-2 mx-2 bg-gray-200 rounded">
                                            <div class="h-2 bg-amber-500 rounded" style="width: 70%"></div>
                                        </div>
                                        <span class="text-sm w-16 text-right">70%</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-sm w-16">4 stars</span>
                                        <div class="flex-1 h-2 mx-2 bg-gray-200 rounded">
                                            <div class="h-2 bg-amber-500 rounded" style="width: 20%"></div>
                                        </div>
                                        <span class="text-sm w-16 text-right">20%</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-sm w-16">3 stars</span>
                                        <div class="flex-1 h-2 mx-2 bg-gray-200 rounded">
                                            <div class="h-2 bg-amber-500 rounded" style="width: 8%"></div>
                                        </div>
                                        <span class="text-sm w-16 text-right">8%</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-sm w-16">2 stars</span>
                                        <div class="flex-1 h-2 mx-2 bg-gray-200 rounded">
                                            <div class="h-2 bg-amber-500 rounded" style="width: 2%"></div>
                                        </div>
                                        <span class="text-sm w-16 text-right">2%</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-sm w-16">1 star</span>
                                        <div class="flex-1 h-2 mx-2 bg-gray-200 rounded">
                                            <div class="h-2 bg-amber-500 rounded" style="width: 0%"></div>
                                        </div>
                                        <span class="text-sm w-16 text-right">0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Controls -->
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-700">Filter by:</span>
                            <select
                                class="rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50 text-sm">
                                <option>All Services</option>
                                <option>Custom Furniture Creation</option>
                                <option>Antique Restoration</option>
                                <option>Wooden Interior Elements</option>
                            </select>
                            <select
                                class="rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50 text-sm">
                                <option>All Ratings</option>
                                <option>5 Stars</option>
                                <option>4 Stars</option>
                                <option>3 Stars</option>
                                <option>2 Stars</option>
                                <option>1 Star</option>
                            </select>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-700">Sort by:</span>
                            <select
                                class="rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50 text-sm">
                                <option>Most Recent</option>
                                <option>Highest Rating</option>
                                <option>Lowest Rating</option>
                                <option>Oldest First</option>
                            </select>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="space-y-6">
                        <!-- Review Item 1 -->
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                            <div class="p-6">
                                <div class="flex justify-between mb-4">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500 font-medium">JD</span>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-sm font-medium text-gray-900">Jean Dupont</h4>
                                            <div class="flex items-center">
                                                <div class="flex text-amber-500">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <span class="ml-2 text-sm text-gray-500">Nov 12, 2023</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                        Custom Dining Table
                                    </span>
                                </div>
                                <p class="text-gray-700 mb-3">
                                    Excellent work! The dining table is exactly what we wanted. The craftsmanship is superb,
                                    and the attention to detail is impressive. It was delivered on time and the installation
                                    was quick and professional.
                                </p>
                                <div class="flex justify-between items-center">
                                    <button class="inline-flex items-center text-sm text-amber-600">
                                        <i class="fas fa-reply mr-2"></i> Reply
                                    </button>
                                    <span class="text-xs text-gray-500">Order #2845</span>
                                </div>
                            </div>
                        </div>

                        <!-- Review Item 2 -->
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                            <div class="p-6">
                                <div class="flex justify-between mb-4">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500 font-medium">ML</span>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-sm font-medium text-gray-900">Marie Lambert</h4>
                                            <div class="flex items-center">
                                                <div class="flex text-amber-500">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <span class="ml-2 text-sm text-gray-500">Nov 3, 2023</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                        Antique Restoration
                                    </span>
                                </div>
                                <p class="text-gray-700 mb-3">
                                    My grandmother's chair looks amazing after restoration! It's like new but still retains
                                    its antique charm. The only reason I'm giving 4 stars instead of 5 is that it took a bit
                                    longer than expected to complete.
                                </p>
                                <div class="mt-3 bg-gray-50 p-3 rounded-md border border-gray-100">
                                    <div class="flex items-start mb-2">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center">
                                            <span class="text-amber-600 font-medium text-xs">ME</span>
                                        </div>
                                        <div class="ml-3">
                                            <h5 class="text-xs font-medium text-gray-900">Your Reply</h5>
                                            <span class="text-xs text-gray-500">Nov 4, 2023</span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-700">
                                        Thank you for your feedback, Marie! I'm glad you're happy with the restoration. I
                                        apologize for the delay and appreciate your understanding.
                                    </p>
                                </div>
                                <div class="flex justify-between items-center mt-3">
                                    <button class="inline-flex items-center text-sm text-amber-600">
                                        <i class="fas fa-edit mr-2"></i> Edit Reply
                                    </button>
                                    <span class="text-xs text-gray-500">Order #2812</span>
                                </div>
                            </div>
                        </div>

                        <!-- Add more review items as needed -->
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        <nav class="flex items-center justify-between">
                            <div class="flex-1 flex justify-between sm:hidden">
                                <a href="#"
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Previous</a>
                                <a href="#"
                                    class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Next</a>
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Showing <span class="font-medium">1</span> to <span class="font-medium">10</span>
                                        of <span class="font-medium">42</span> reviews
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
                                            class="z-10 bg-amber-50 border-amber-500 text-amber-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">1</a>
                                        <a href="#"
                                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">2</a>
                                        <a href="#"
                                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">3</a>
                                        <a href="#"
                                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">4</a>
                                        <a href="#"
                                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">5</a>
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
