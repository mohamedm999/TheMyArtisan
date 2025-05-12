<div class="bg-gradient-to-r from-amber-700 to-amber-600 relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full"
            style="background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'80\' viewBox=\'0 0 80 80\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath fill-rule=\'evenodd\' d=\'M0 0h40v40H0V0zm40 40h40v40H40V40zm0-40h2l-2 2V0zm0 4l4-4h2l-6 6V4zm0 4l8-8h2L40 10V8zm0 4L52 0h2L40 14v-2zm0 4L56 0h2L40 18v-2zm0 4L60 0h2L40 22v-2zm0 4L64 0h2L40 26v-2zm0 4L68 0h2L40 30v-2zm0 4L72 0h2L40 34v-2zm0 4L76 0h2L40 38v-2zm0 4L80 0v2L42 40h-2zm4 0L80 4v2L46 40h-2zm4 0L80 8v2L50 40h-2zm4 0l28-28v2L54 40h-2zm4 0l24-24v2L58 40h-2zm4 0l20-20v2L62 40h-2zm4 0l16-16v2L66 40h-2zm4 0l12-12v2L70 40h-2zm4 0l8-8v2l-6 6h-2zm4 0l4-4v2l-2 2h-2z\'/%3E%3C/g%3E%3C/svg%3E');">
        </div>
    </div>

    <!-- Glowing orbs -->
    <div class="absolute -top-20 -left-20 w-60 h-60 bg-yellow-300 rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute -bottom-20 -right-20 w-60 h-60 bg-amber-400 rounded-full opacity-20 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative z-10">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="lg:w-2/3">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white">
                    Ready to experience authentic Moroccan craftsmanship?
                </h2>
                <p class="mt-4 text-lg text-amber-100">
                    Join our platform to connect directly with skilled artisans or register as an artisan to showcase
                    your craft to customers worldwide.
                </p>

                <!-- Testimonial snippet -->
                <div class="mt-8 flex items-center">
                    <div class="flex -space-x-2">
                        <img class="h-10 w-10 rounded-full ring-2 ring-white"
                            src="{{ asset('images/testimonials/client-1.jpg') }}" alt="Customer">
                        <img class="h-10 w-10 rounded-full ring-2 ring-white"
                            src="{{ asset('images/testimonials/client-2.jpg') }}" alt="Customer">
                        <img class="h-10 w-10 rounded-full ring-2 ring-white"
                            src="{{ asset('images/testimonials/client-3.jpg') }}" alt="Customer">
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-white">Trusted by over 300 satisfied customers</p>
                        <div class="mt-1 flex">
                            <i class="fas fa-star text-amber-200"></i>
                            <i class="fas fa-star text-amber-200"></i>
                            <i class="fas fa-star text-amber-200"></i>
                            <i class="fas fa-star text-amber-200"></i>
                            <i class="fas fa-star text-amber-200"></i>
                            <span class="ml-1 text-sm text-amber-100">4.9 / 5.0</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 lg:mt-0 lg:w-1/3">
                <div class="bg-white py-6 px-6 rounded-lg shadow-lg transform transition-all hover:scale-105">
                    <div class="space-y-5">
                        <a href="{{ route('client.artisans.index') }}"
                            class="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700">
                            <i class="fas fa-search mr-2"></i> Find Artisans
                        </a>
                        <a href="{{ route('register') }}"
                            class="w-full flex items-center justify-center px-5 py-3 border border-amber-600 text-base font-medium rounded-md text-amber-600 bg-white hover:bg-amber-50">
                            <i class="fas fa-user-plus mr-2"></i> Register as Artisan
                        </a>
                    </div>

                    <!-- Benefits section -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900">Platform Benefits</h3>
                        <ul class="mt-2 space-y-2 text-sm text-gray-500">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-amber-500 mr-2"></i>
                                <span>Verified authentic artisans</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-amber-500 mr-2"></i>
                                <span>Secure payment system</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-amber-500 mr-2"></i>
                                <span>Direct communication with craftspeople</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
