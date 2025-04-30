<div x-data="{
    slide: 0,
    isTransitioning: false,
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
    timer: null,
    init() {
        this.startAutoplay();
        this.$nextTick(() => {
            this.preloadImages();
        });
    },
    preloadImages() {
        // Preload all images to prevent loading issues
        [...this.backgroundImages, ...this.productImages].forEach(src => {
            const img = new Image();
            img.src = src;
        });
    },
    stopAutoplay() {
        if (this.timer) clearTimeout(this.timer);
        this.timer = null;
    },
    startAutoplay() {
        this.stopAutoplay();
        this.timer = setTimeout(() => {
            this.nextSlide();
            this.startAutoplay();
        }, 5000);
    },
    nextSlide() {
        if (this.isTransitioning) return;
        this.isTransitioning = true;
        setTimeout(() => {
            this.slide = (this.slide + 1) % this.backgroundImages.length;
            this.isTransitioning = false;
        }, 50);
    },
    prevSlide() {
        if (this.isTransitioning) return;
        this.isTransitioning = true;
        setTimeout(() => {
            this.slide = (this.slide - 1 + this.backgroundImages.length) % this.backgroundImages.length;
            this.isTransitioning = false;
        }, 50);
    },
    goToSlide(index) {
        if (this.isTransitioning || this.slide === index) return;
        this.isTransitioning = true;
        setTimeout(() => {
            this.slide = index;
            this.isTransitioning = false;
        }, 50);
    }
}" @keydown.arrow-right.window="nextSlide(); stopAutoplay(); startAutoplay()"
    @keydown.arrow-left.window="prevSlide(); stopAutoplay(); startAutoplay()"
    class="relative overflow-hidden bg-amber-900">

    <!-- Background Slideshow -->
    <div class="absolute inset-0 z-0">
        <template x-for="(image, index) in backgroundImages" :key="index">
            <div x-show="slide === index" x-cloak
                class="absolute inset-0 w-full h-full bg-cover bg-center"
                :style="`background-image: url('${image}');`"
                x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0 transform scale-105"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-700"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <!-- Light amber tint for better text contrast (much lighter than before) -->
                <div class="absolute inset-0 bg-amber-900/20"></div>
            </div>
        </template>
    </div>

    <!-- Subtle decorative elements -->
    <div class="absolute inset-0 opacity-5 z-1 pointer-events-none">
        <div class="absolute bottom-0 left-0 w-64 h-64 transform -translate-x-1/4 translate-y-1/4 bg-amber-500 rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute top-0 right-0 w-80 h-80 transform translate-x-1/4 -translate-y-1/4 bg-amber-300 rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute top-1/2 left-1/3 w-48 h-48 bg-amber-600 rounded-full opacity-10 blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-32 relative z-10">
        <!-- Slide Indicators -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20">
            <template x-for="(_, index) in backgroundImages" :key="index">
                <button @click="goToSlide(index); stopAutoplay(); startAutoplay()"
                    :class="{ 'bg-amber-200 w-8': slide === index, 'bg-white/50 w-3': slide !== index }"
                    class="h-3 rounded-full transition-all duration-300 hover:bg-amber-100 focus:outline-none">
                </button>
            </template>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-12 items-center">
            <!-- Text content -->
            <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-5 lg:text-left">
                <div class="space-y-2">
                    <span class="inline-block px-3 py-1 text-xs font-semibold text-amber-600 bg-amber-100 rounded-full shadow-sm transform hover:scale-105 transition-transform duration-300">
                        Authentic & Handcrafted
                    </span>
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
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

                <!-- Testimonial -->
                <div class="mt-8 p-4 bg-amber-900/30 backdrop-blur-sm rounded-lg border border-amber-700/30">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full overflow-hidden bg-amber-100">
                            <img src="{{ asset('images/backgrounds/placeholder.jpg') }}" alt="Customer"
                                class="h-full w-full object-cover">
                        </div>
                        <div class="ml-4">
                            <p class="text-amber-100 italic text-sm">"These authentic pieces transformed my home with
                                the spirit of Morocco."</p>
                            <p class="text-amber-300 text-xs mt-1">— Sarah J., New York</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product showcase -->
            <div class="mt-12 lg:mt-0 lg:col-span-7">
                <div class="relative mx-auto rounded-xl shadow-2xl overflow-hidden bg-gradient-to-br from-amber-900/40 to-amber-700/40 backdrop-blur-sm"
                    @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">

                    <!-- Main product image carousel -->
                    <div class="aspect-w-16 aspect-h-10 relative group">
                        <div class="absolute inset-0">
                            <template x-for="(image, index) in productImages" :key="index">
                                <div x-show="slide === index" x-cloak
                                    class="absolute inset-0 transition-opacity duration-1000"
                                    x-transition:enter="transition ease-out duration-1000"
                                    x-transition:enter-start="opacity-0 transform scale-105"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-800"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-95">
                                    <img :src="image" class="w-full h-full object-contain"
                                        :alt="`Moroccan craft ${index + 1}`">
                                </div>
                            </template>
                        </div>

                        <!-- Arrow navigation - Left -->
                        <div class="absolute inset-y-0 left-0 flex items-center">
                            <button @click="prevSlide(); stopAutoplay(); startAutoplay()"
                                class="bg-amber-800/30 hover:bg-amber-800/50 text-white p-2 rounded-r-lg backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                        </div>

                        <!-- Arrow navigation - Right -->
                        <div class="absolute inset-y-0 right-0 flex items-center">
                            <button @click="nextSlide(); stopAutoplay(); startAutoplay()"
                                class="bg-amber-800/30 hover:bg-amber-800/50 text-white p-2 rounded-l-lg backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Thumbnails -->
                <div class="grid grid-cols-4 gap-3 mt-6">
                    <template x-for="(image, index) in productImages" :key="index">
                        <div class="overflow-hidden rounded-lg border-2 hover:border-amber-300 transition cursor-pointer transform hover:scale-105 duration-300 shadow-md"
                            @click="goToSlide(index); stopAutoplay(); startAutoplay()"
                            :class="{
                                'border-amber-300 ring-2 ring-amber-500': slide === index,
                                'border-transparent': slide !== index
                            }">
                            <img :src="image"
                                class="w-full h-16 object-cover transition duration-700 hover:scale-110"
                                :alt="`Moroccan craft thumbnail ${index + 1}`">
                        </div>
                    </template>
                </div>

                <!-- Feature highlights -->
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
        /* Hide elements with x-cloak before Alpine initializes */
        [x-cloak] { display: none !important; }

        /* The aspect ratio classes */
        .aspect-w-16 {
            position: relative;
            padding-bottom: calc(var(--tw-aspect-h) / var(--tw-aspect-w) * 100%);
            --tw-aspect-w: 16;
        }

        .aspect-h-10 {
            --tw-aspect-h: 10;
        }

        .aspect-w-16 > * {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        /* Animation utilities */
        .transition-opacity {
            transition-property: opacity;
        }

        .duration-300 {
            transition-duration: 300ms;
        }

        .duration-700 {
            transition-duration: 700ms;
        }

        .duration-1000 {
            transition-duration: 1000ms;
        }

        /* Background utility */
        .bg-cover {
            background-size: cover;
        }

        .bg-center {
            background-position: center;
        }

        /* Blur effects */
        .blur-3xl {
            --tw-blur: blur(64px);
            filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);
        }

        .backdrop-blur-sm {
            --tw-backdrop-blur: blur(4px);
            -webkit-backdrop-filter: var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);
            backdrop-filter: var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);
        }
    </style>
</div>
