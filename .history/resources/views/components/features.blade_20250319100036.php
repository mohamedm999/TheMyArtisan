<section class="bg-white py-16 sm:py-24 relative z-0 mt-0 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Discover Authentic Moroccan Craftsmanship
            </h2>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                Connect directly with skilled artisans preserving centuries-old traditions
            </p>
        </div>

        <div class="mt-16">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div
                    class="bg-amber-50 rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="h-48 bg-amber-500 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-400 to-amber-600 opacity-90"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-gem text-white text-5xl"></i>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Authentic Craftsmanship</h3>
                        <p class="text-gray-600">
                            Each piece tells a story of cultural heritage and exceptional skill passed down through
                            generations of Moroccan artisans.
                        </p>
                        <a href="{{ route('crafts.index') }}"
                            class="mt-4 inline-flex items-center text-amber-600 hover:text-amber-700">
                            Explore Crafts
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div
                    class="bg-amber-50 rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="h-48 bg-amber-600 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-500 to-amber-700 opacity-90"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-handshake text-white text-5xl"></i>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Direct from Artisans</h3>
                        <p class="text-gray-600">
                            Connect directly with talented craftspeople, ensuring fair compensation while supporting
                            traditional craft communities.
                        </p>
                        <a href="{{ route('featured-artisans') }}"
                            class="mt-4 inline-flex items-center text-amber-600 hover:text-amber-700">
                            Meet Our Artisans
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div
                    class="bg-amber-50 rounded-xl overflow-hidden shadow-lg transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="h-48 bg-amber-700 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-600 to-amber-800 opacity-90"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-star text-white text-5xl"></i>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Vetted Quality</h3>
                        <p class="text-gray-600">
                            Every artisan is carefully selected based on their skill, authenticity, and commitment to
                            traditional techniques.
                        </p>
                        <a href="{{ route('faq') }}"
                            class="mt-4 inline-flex items-center text-amber-600 hover:text-amber-700">
                            Learn How We Select
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Craft Categories -->
        <div class="mt-20">
            <h3 class="text-2xl font-bold text-gray-900 text-center mb-10">
                Explore Traditional Moroccan Crafts
            </h3>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
                <!-- Category 1 -->
                <a href="{{ route('crafts.zellige') }}" class="group">
                    <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100 shadow-md">
                        <img src="{{ asset('images/crafts/zellige-thumb.jpg') }}" alt="Zellige Tilework"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    <h4 class="mt-2 text-center font-medium text-gray-900">Zellige</h4>
                </a>

                <!-- Category 2 -->
                <a href="{{ route('crafts.carpets') }}" class="group">
                    <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100 shadow-md">
                        <img src="{{ asset('images/crafts/carpet-thumb.jpg') }}" alt="Carpet Weaving"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    <h4 class="mt-2 text-center font-medium text-gray-900">Carpets</h4>
                </a>

                <!-- Category 3 -->
                <a href="{{ route('crafts.leather') }}" class="group">
                    <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100 shadow-md">
                        <img src="{{ asset('images/crafts/leather-thumb.jpg') }}" alt="Leather Crafting"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    <h4 class="mt-2 text-center font-medium text-gray-900">Leather</h4>
                </a>

                <!-- Category 4 -->
                <a href="{{ route('crafts.metalwork') }}" class="group">
                    <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100 shadow-md">
                        <img src="{{ asset('images/crafts/metalwork-thumb.jpg') }}" alt="Metalwork"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    <h4 class="mt-2 text-center font-medium text-gray-900">Metalwork</h4>
                </a>

                <!-- Category 5 -->
                <a href="{{ route('crafts.pottery') }}" class="group">
                    <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100 shadow-md">
                        <img src="{{ asset('images/crafts/pottery-thumb.jpg') }}" alt="Pottery"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    <h4 class="mt-2 text-center font-medium text-gray-900">Pottery</h4>
                </a>

                <!-- Category 6 -->
                <a href="{{ route('crafts.woodwork') }}" class="group">
                    <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100 shadow-md">
                        <img src="{{ asset('images/crafts/woodwork-thumb.jpg') }}" alt="Woodwork"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    <h4 class="mt-2 text-center font-medium text-gray-900">Woodwork</h4>
                </a>
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('crafts.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-amber-600 rounded-md text-amber-600 bg-white hover:bg-amber-50 font-medium">
                    View All Categories <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>
