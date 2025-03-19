<div x-data="{
    slide: 0,
    autoplay: null,
    slideImages: [
        '{{ asset('images/hero/slide1.jpg') }}',
        '{{ asset('images/hero/slide2.jpg') }}',
        '{{ asset('images/hero/slide3.jpg') }}',
        '{{ asset('images/hero/slide4.jpg') }}'
    ],
    init() {
        this.autoplay = setInterval(() => {
            this.slide = (this.slide + 1) % 4;
        }, 5000);
    },
    stopAutoplay() {
        clearInterval(this.autoplay);
    },
    startAutoplay() {
        this.autoplay = setInterval(() => {
            this.slide = (this.slide + 1) % 4;
        }, 5000);
    }
}" class="relative overflow-hidden bg-amber-900">

    <!-- Background Slideshow -->
    <div class="absolute inset-0 z-0">
        <template x-for="(image, index) in slideImages" :key="index">
            <div x-show="slide === index"
                class="absolute inset-0 w-full h-full bg-cover bg-center transition-opacity duration-1000"
                :style="`background-image: url('${image}');`" x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-800"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <!-- Dark overlay for better text readability -->
                <div class="absolute inset-0 bg-amber-900/60 backdrop-filter backdrop-blur-sm"></div>
            </div>
        </template>
    </div>

    <!-- Decorative elements -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 left-0 w-full h-full"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 lg:py-32 relative z-10">
        <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-center">
            <!-- Hero text content -->
            <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                    <span class="block">Discover Authentic</span>
                    <span class="block text-amber-200">Moroccan Craftsmanship</span>
                </h1>
                <p class="mt-6 text-lg text-amber-100 sm:text-xl">
                    Connect with skilled Moroccan artisans for traditional crafts, from intricate zellige tilework
                    to handwoven Berber rugs and hammered copper treasures.
                </p>
                <div class="mt-8 sm:flex sm:justify-center lg:justify-start gap-4">
                    <div class="rounded-md shadow">
                        <a href="{{ route('client.artisans.index') }}"
                            class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-amber-800 bg-amber-200 hover:bg-amber-300 md:py-4 md:text-lg md:px-10">
                            Explore Artisans
                        </a>
                    </div>
                    <div class="mt-3 sm:mt-0">
                        <a href="{{ route('crafts.index') }}"
                            class="w-full flex items-center justify-center px-8 py-3 border border-amber-300 text-base font-medium rounded-md text-white hover:bg-amber-800/20 md:py-4 md:text-lg md:px-10">
                            Browse Crafts
                        </a>
                    </div>
                </div>
            </div>

            <!-- Hero featured image -->
            <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                <div class="relative mx-auto w-full rounded-lg shadow-lg overflow-hidden">
                    <div class="relative pb-[60%]">
                        <template x-for="(image, index) in slideImages" :key="index">
                            <img x-show="slide === index" :src="image"
                                class="absolute inset-0 w-full h-full object-cover transition duration-700"
                                x-transition:enter="transition ease-out duration-1000"
                                x-transition:enter-start="opacity-0 transform scale-105"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-800"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                alt="Moroccan craftsmanship">
                        </template>
                    </div>

                    <!-- Controls -->
                    <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
                        <template x-for="(_, index) in slideImages" :key="index">
                            <button @click="slide = index; stopAutoplay(); setTimeout(() => startAutoplay(), 10000);"
                                :class="{'bg-white': slide === index, 'bg-white/50': slide !== index}"
                                class="h-2 w-2 rounded-full focus:outline-none">
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide Indicators -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20">
            <template x-for="(_, index) in [0,1,2,3]" :key="index">
                <button @click="slide = index; stopAutoplay(); setTimeout(() => { startAutoplay() }, 10000)"
                    :class="{ 'bg-amber-200 w-8': slide === index, 'bg-white/50 w-3': slide !== index }"
                    class="h-3 rounded-full transition-all duration-500 hover:bg-amber-100">
                </button>
            </template>
        </div>
    </div>
</div>
