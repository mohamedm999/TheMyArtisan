@extends('layouts.app')

@section('title', 'MyArtisan Blog - Moroccan Craftsmanship Stories')
@section('description', 'Discover stories of Moroccan artisans, traditional crafting techniques, and updates about the
    MyArtisan platform.')

@section('content')
    <div class="bg-amber-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Hero section -->
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl font-bold text-amber-800 mb-6">MyArtisan Blog</h1>
            <p class="text-lg text-gray-700 max-w-3xl mx-auto">
                Stories of craft, culture, and the people preserving Morocco's artistic heritage
            </p>
        </div>
    </div>

    <!-- Blog Posts -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                <!-- Featured Blog Post -->
                <div class="col-span-full mb-12">
                    <div
                        class="bg-white rounded-lg overflow-hidden shadow-lg transition-transform hover:-translate-y-1 hover:shadow-xl">
                        <div class="aspect-w-16 aspect-h-9 lg:aspect-w-2 lg:aspect-h-1">
                            <img src="{{ asset('images/blog/featured.jpg') }}" alt="The Revival of Moroccan Zellige"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="p-8">
                            <div class="flex items-center mb-4">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                    Featured
                                </span>
                                <span class="ml-2 text-sm text-gray-500">May 15, {{ date('Y') }}</span>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">The Revival of Moroccan Zellige: Ancient
                                Patterns in Modern Spaces</h2>
                            <p class="text-gray-600 mb-4">
                                How this intricate mosaic tilework is finding new appreciation in contemporary interior
                                design around the world.
                            </p>
                            <div class="flex items-center">
                                <img class="h-10 w-10 rounded-full mr-4" src="{{ asset('images/team/team-2.jpg') }}"
                                    alt="Author">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Amina Berrada</h3>
                                    <div class="text-sm text-gray-500">Creative Director</div>
                                </div>
                                <a href="#" class="ml-auto text-amber-600 hover:text-amber-500 font-medium">
                                    Read Article <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Regular Blog Post 1 -->
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-md transition-transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ asset('images/blog/post-1.jpg') }}" alt="Blog Post" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <span class="text-sm text-gray-500">April 22, {{ date('Y') }}</span>
                        <h2 class="text-xl font-bold text-gray-900 mt-2 mb-3">Artisan Spotlight: The Leather Craftsmen of
                            Fes</h2>
                        <p class="text-gray-600 mb-4">
                            Meet the families who have passed down the secrets of fine leather working for generations.
                        </p>
                        <a href="#" class="text-amber-600 hover:text-amber-500 font-medium">
                            Read More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Regular Blog Post 2 -->
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-md transition-transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ asset('images/blog/post-2.jpg') }}" alt="Blog Post" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <span class="text-sm text-gray-500">March 17, {{ date('Y') }}</span>
                        <h2 class="text-xl font-bold text-gray-900 mt-2 mb-3">Sustainable Practices in Traditional Carpet
                            Weaving</h2>
                        <p class="text-gray-600 mb-4">
                            How modern environmental concerns are being addressed within traditional craft methods.
                        </p>
                        <a href="#" class="text-amber-600 hover:text-amber-500 font-medium">
                            Read More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Regular Blog Post 3 -->
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-md transition-transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ asset('images/blog/post-3.jpg') }}" alt="Blog Post" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <span class="text-sm text-gray-500">February 28, {{ date('Y') }}</span>
                        <h2 class="text-xl font-bold text-gray-900 mt-2 mb-3">The Symbolic Language of Berber Motifs</h2>
                        <p class="text-gray-600 mb-4">
                            Decoding the meanings behind the geometric patterns found in Moroccan textiles and ceramics.
                        </p>
                        <a href="#" class="text-amber-600 hover:text-amber-500 font-medium">
                            Read More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Regular Blog Post 4 -->
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-md transition-transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ asset('images/blog/post-4.jpg') }}" alt="Blog Post" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <span class="text-sm text-gray-500">January 15, {{ date('Y') }}</span>
                        <h2 class="text-xl font-bold text-gray-900 mt-2 mb-3">From Medina to Market: How MyArtisan is
                            Helping Rural Craftsmen</h2>
                        <p class="text-gray-600 mb-4">
                            A look at how technology is connecting isolated artisan communities with international buyers.
                        </p>
                        <a href="#" class="text-amber-600 hover:text-amber-500 font-medium">
                            Read More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Regular Blog Post 5 -->
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-md transition-transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ asset('images/blog/post-5.jpg') }}" alt="Blog Post"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <span class="text-sm text-gray-500">December 10, {{ date('Y') - 1 }}</span>
                        <h2 class="text-xl font-bold text-gray-900 mt-2 mb-3">The Art of Moroccan Metalworking: Tools and
                            Techniques</h2>
                        <p class="text-gray-600 mb-4">
                            An exploration of the specialized tools and processes used in traditional Moroccan metalcraft.
                        </p>
                        <a href="#" class="text-amber-600 hover:text-amber-500 font-medium">
                            Read More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-16 flex justify-center">
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <a href="#"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Previous</span>
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a href="#" aria-current="page"
                        class="z-10 bg-amber-50 border-amber-500 text-amber-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">1</a>
                    <a href="#"
                        class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">2</a>
                    <a href="#"
                        class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">3</a>
                    <span
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
                    <a href="#"
                        class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">8</a>
                    <a href="#"
                        class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">9</a>
                    <a href="#"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Next</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Subscribe Section -->
    <div class="bg-amber-50 py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-amber-800 mb-6">Stay Updated</h2>
            <p class="text-gray-600 mb-8">
                Subscribe to our newsletter for the latest stories on Moroccan craftsmanship and artisan features.
            </p>
            <form class="sm:flex justify-center">
                <input type="email" required
                    class="w-full sm:max-w-xs px-4 py-3 border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 block rounded-md sm:rounded-r-none"
                    placeholder="Enter your email">
                <button type="submit"
                    class="mt-3 sm:mt-0 w-full sm:w-auto bg-amber-600 text-white px-6 py-3 rounded-md sm:rounded-l-none hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    Subscribe
                </button>
            </form>
        </div>
    </div>
@endsection
