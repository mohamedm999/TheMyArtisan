<div x-data="{
    slide: 0,
    autoplay: null,
    backgroundImages: [
        '{{ asset('images/backgrounds/Crafts-1.png') }}',
        '{{ asset('images/backgrounds/Crafts-2.jpg') }}',
        '{{ asset('images/backgrounds/Crafts-3.jpg') }}',
        '{{ asset('images/backgrounds/Crafts-4.jpg') }}'
    ],
    productImages: [
        '{{ asset('images/backgrounds/logoArtisan.png') }}',
        '{{ asset('images/backgrounds/MyArtisanLogo.png') }}',
        '{{ asset('images/backgrounds/placeholder.jpg') }}',
        '{{ asset('images/backgrounds/placeholder.jpg') }}'
    ],
    init() {
        this.autoplay = setInterval(() => {
            this.slide = (this.slide + 1) % 4;
        }, 2000);
    },
    stopAutoplay() {
        clearInterval(this.autoplay);
    },
    startAutoplay() {
        this.autoplay = setInterval(() => {
            this.slide = (this.slide + 1) % 4;
        }, 2000);
    }
}" @keydown.arrow-right.window="slide = (slide + 1) % 4"
    @keydown.arrow-left.window="slide = (slide - 1 + 4) % 4" class="relative overflow-hidden">

    <!-- Background Slideshow - Fixed image paths -->
    <div class="absolute inset-0 z-0">
        <template x-for="(image, index) in backgroundImages" :key="index">
            <div x-show="slide === index"
                class="absolute inset-0 w-full h-full bg-cover bg-center transition-opacity duration-1500"
                :style="`background-image: url('${image}');`" x-transition:enter="transition ease-out duration-2000"
                x-transition:enter-start="opacity-0 transform scale-105"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <!-- Dark overlay for better text readability -->
                <div class="absolute inset-0 bg-amber-900/60 backdrop-filter backdrop-blur-sm"></div>
            </div>
        </template>
    </div>

    <!-- Decorative pattern overlays - keep existing with z-index adjustment -->
    <div class="absolute inset-0 opacity-5 pattern-dots-lg animate-pulse z-1"></div>
    <div
        class="absolute bottom-0 left-0 w-64 h-64 transform -translate-x-1/4 translate-y-1/4 bg-amber-500 rounded-full opacity-10 blur-3xl animate-blob z-1">
    </div>
    <div
        class="absolute top-0 right-0 w-80 h-80 transform translate-x-1/4 -translate-y-1/4 bg-amber-300 rounded-full opacity-10 blur-3xl animate-blob animation-delay-2000 z-1">
    </div>
    <div
        class="absolute top-1/2 left-1/3 w-48 h-48 bg-amber-600 rounded-full opacity-10 blur-3xl animate-blob animation-delay-4000 z-1">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-32 relative z-10">
        <!-- Background Slide Indicators - New addition -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20">
            <template x-for="(_, index) in [0,1,2,3]" :key="index">
                <button @click="slide = index; stopAutoplay(); setTimeout(() => { startAutoplay() }, 10000)"
                    :class="{ 'bg-amber-200 w-8': slide === index, 'bg-white/50 w-3': slide !== index }"
                    class="h-3 rounded-full transition-all duration-500 hover:bg-amber-100">
                </button>
            </template>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-12 items-center">
            <!-- Enhanced text content with refined typography -->
            <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-5 lg:text-left">
                <div class="space-y-2">
                    <span
                        class="inline-block px-3 py-1 text-xs font-semibold text-amber-600 bg-amber-100 rounded-full shadow-sm transform hover:scale-105 transition-transform duration-300">Authentic
                        & Handcrafted</span>
                    <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                        <span class="block">Discover Authentic</span>
                        <span class="block text-amber-200 mt-2">Moroccan Craftsmanship</span>
                    </h1>
                </div>

                <p class="mt-6 text-base text-amber-100 sm:text-xl lg:text-lg xl:text-xl leading-relaxed">
                    Connect with skilled Moroccan artisans for traditional crafts, from intricate zellige tilework
                    to handwoven Berber rugs and hammered copper treasures.
                </p>

                <div class="mt-10 flex flex-col sm:flex-row sm:justify-center lg:justify-start gap-4">
                    <a href="#explore"
                        class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg shadow-lg text-amber-800 bg-amber-200 hover:bg-amber-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-300">
                        Explore Artisans
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 animate-bounce-x"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#artisans"
                        class="inline-flex items-center justify-center px-6 py-3 border border-amber-300 text-base font-medium rounded-lg text-white hover:bg-amber-800/20 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-300">
                        Meet Our Artisans
                    </a>
                </div>

                <!-- Added testimonial element -->
                <div class="mt-8 p-4 bg-amber-900/30 backdrop-blur-sm rounded-lg border border-amber-700/30">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full overflow-hidden bg-amber-100">
                            <img src="{{ asset('images/backgrounds/placeholder.jpg') }}" alt="Customer"
                                class="h-full w-full object-cover"
                                onerror="this.src='{{ asset('images/backgrounds/placeholder.jpg') }}'; this.onerror=null;" />
                        </div>
                        <div class="ml-4">
                            <p class="text-amber-100 italic text-sm">"These authentic pieces transformed my home with
                                the spirit of Morocco."</p>
                            <p class="text-amber-300 text-xs mt-1">— Sarah J., New York</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced image carousel section -->
            <div class="mt-12 lg:mt-0 lg:col-span-7">
                <div class="relative mx-auto rounded-xl shadow-2xl overflow-hidden bg-gradient-to-br from-amber-900/40 to-amber-700/40 backdrop-blur-sm"
                    @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">
                    <!-- Main image carousel -->
                    <div class="aspect-w-16 aspect-h-10 relative group">
                        <!-- Image carousel with smooth transitions -->
                        <div class="absolute inset-0">
                            <!-- Updated with real image paths -->
                            <template x-for="(image, index) in productImages" :key="index">
                                <div x-show="slide === index" class="absolute inset-0 transition-opacity duration-1000"
                                    x-transition:enter="transition ease-out duration-1000"
                                    x-transition:enter-start="opacity-0 transform scale-105"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-800"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-95">
                                    <img :src="image" class="w-full h-full object-cover"
                                        alt="Moroccan artisan craftsmanship"
                                        onerror="this.src='{{ asset('images/backgrounds/placeholder.jpg') }}'; this.onerror=null;">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-amber-900/70 via-transparent to-transparent">
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Enhanced navigation controls -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-3">
                            <template x-for="(_, index) in [0,1,2,3]" :key="index">
                                <button
                                    @click="slide = index; stopAutoplay(); setTimeout(() => { startAutoplay() }, 10000)"
                                    :class="{ 'bg-amber-200 w-8': slide === index, 'bg-white/50 w-3': slide !== index }"
                                    class="h-3 rounded-full transition-all duration-500 hover:bg-amber-100">
                                </button>
                            </template>
                        </div>

                        <!-- Added arrow navigation -->
                        <div class="absolute inset-y-0 left-0 flex items-center">
                            <button
                                @click="slide = (slide - 1 + 4) % 4; stopAutoplay(); setTimeout(() => { startAutoplay() }, 10000)"
                                class="bg-amber-800/30 text-white p-2 rounded-r-lg backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                        </div>
                        <div class="absolute inset-y-0 right-0 flex items-center">
                            <button
                                @click="slide = (slide + 1) % 4; stopAutoplay(); setTimeout(() => { startAutoplay() }, 10000)"
                                class="bg-amber-800/30 text-white p-2 rounded-l-lg backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Enhanced decorative floating elements with subtle animations -->
                    <div
                        class="absolute -top-4 -right-4 w-32 h-32 bg-amber-500/30 rounded-full blur-xl animate-pulse-slow">
                    </div>
                    <div
                        class="absolute -bottom-4 -left-4 w-32 h-32 bg-amber-300/30 rounded-full blur-xl animate-pulse-slow animation-delay-1000">
                    </div>
                </div>

                <!-- Enhanced image thumbnails with hover effects -->
                <div class="grid grid-cols-4 gap-3 mt-6">
                    <template x-for="(image, index) in productImages" :key="index">
                        <div class="overflow-hidden rounded-lg border-2 hover:border-amber-300 transition cursor-pointer transform hover:scale-105 duration-300 shadow-md"
                            @click="slide = index; stopAutoplay(); setTimeout(() => { startAutoplay() }, 10000)"
                            :class="{
                                'border-amber-300 ring-2 ring-amber-500': slide === index,
                                'border-transparent': slide !== index
                            }">
                            <img :src="image"
                                class="w-full h-16 object-cover transition duration-700 hover:scale-110"
                                :alt="`Moroccan craft ${index + 1}`"
                                onerror="this.src='{{ asset('images/backgrounds/placeholder.jpg') }}'; this.onerror=null;">
                        </div>
                    </template>
                </div>

                <!-- Added feature highlights below the thumbnails -->
                <div class="grid grid-cols-3 gap-4 mt-6 text-center">
                    <div class="bg-amber-900/30 backdrop-blur-sm p-3 rounded-lg border border-amber-700/30">
                        <div class="text-amber-200 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <p class="text-amber-100 text-xs">Authentic Craftsmanship</p>
                    </div>
                    <div class="bg-amber-900/30 backdrop-blur-sm p-3 rounded-lg border border-amber-700/30">
                        <div class="text-amber-200 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                        </div>
                        <p class="text-amber-100 text-xs">Fair Trade</p>
                    </div>
                    <div class="bg-amber-900/30 backdrop-blur-sm p-3 rounded-lg border border-amber-700/30">
                        <div class="text-amber-200 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                        <p class="text-amber-100 text-xs">Direct From Artisans</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Style definitions -->
    <style>
  

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .animate-bounce-x {
            animation: bounceX 1.5s infinite;
        }

        .animation-delay-1000 {
            animation-delay: 1s;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -30px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 0.1;
            }

            50% {
                opacity: 0.3;
            }
        }

        @keyframes bounceX {

            0%,
            100% {
                transform: translateX(0);
                animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
            }

            50% {
                transform: translateX(5px);
                animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
            }
        }

        /* New styles for background slideshow */
        .bg-cover {
            background-size: cover;
        }

        .bg-center {
            background-position: center;
        }

        /* Adjust z-index values for proper layering */
        .z-0 {
            z-index: 0;
        }

        .z-1 {
            z-index: 1;
        }

        .z-10 {
            z-index: 10;
        }

        .z-20 {
            z-index: 20;
        }

        /* Enhanced transition duration */
        .duration-1500 {
            transition-duration: 1500ms;
        }

        .duration-2000 {
            transition-duration: 2000ms;
        }
    </style>
</div>
