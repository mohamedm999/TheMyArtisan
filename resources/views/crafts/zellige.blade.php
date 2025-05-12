@extends('layouts.app')

@section('title', 'Zellige Tilework - Moroccan Geometric Mosaic Art | MyArtisan')
@section('description', 'Discover the ancient art of Zellige, the intricate geometric mosaic tilework that adorns
    Morocco\'s most beautiful buildings, fountains, and interiors.')

@section('content')
    <div class="relative overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('images/crafts/zellige-hero.jpg') }}" alt="Zellige Pattern Background"
                class="w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-r from-amber-700 to-amber-900 mix-blend-multiply"></div>
        </div>

        <div class="relative py-24 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto text-center">
                <h1 class="text-4xl font-extrabold text-white sm:text-5xl lg:text-6xl tracking-tight">Zellige Tilework</h1>
                <p class="mt-6 text-xl text-amber-100 max-w-3xl mx-auto">
                    The centuries-old geometric mosaic art that defines Moroccan architectural beauty
                </p>
            </div>
        </div>
    </div>

    <!-- Introduction -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="relative">
                    <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden">
                        <img src="{{ asset('images/crafts/zellige-detail.jpg') }}" alt="Detailed Zellige Pattern"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -top-4 -left-4 h-24 w-24 bg-amber-100 rounded-md -z-10"></div>
                    <div class="absolute -bottom-4 -right-4 h-24 w-24 bg-amber-200 rounded-md -z-10"></div>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">The Art of Mathematical Beauty</h2>
                    <p class="text-lg text-gray-600 mb-4">
                        Zellige is a form of Islamic decorative art that emerged in Morocco in the 10th century. This
                        extraordinary mosaic tilework consists of individually hand-cut geometric tiles set in plaster,
                        creating stunning mathematical patterns.
                    </p>
                    <p class="text-lg text-gray-600">
                        The craft blends artisanal precision with mathematical complexity, requiring years of training to
                        master. Each Zellige composition follows sacred geometric principles while allowing for infinite
                        pattern variations.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- The Process -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-amber-50">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">The Zellige Process</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mb-4">
                        <span class="text-xl font-bold text-amber-700">1</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Clay Preparation</h3>
                    <p class="text-gray-600">
                        The process begins with specially selected clay from the Fez region, known for its unique
                        properties. The clay is purified, soaked, and kneaded to achieve perfect consistency.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mb-4">
                        <span class="text-xl font-bold text-amber-700">2</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Firing & Glazing</h3>
                    <p class="text-gray-600">
                        Clay squares are kiln-fired and then hand-glazed in vibrant colors. The traditional palette includes
                        cobalt blue, turquoise, green, yellow, and white, each with historical significance.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mb-4">
                        <span class="text-xl font-bold text-amber-700">3</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Cutting & Assembly</h3>
                    <p class="text-gray-600">
                        Using specialized tools, artisans cut the glazed tiles into precise geometric shapes. These pieces
                        are then assembled face-down into complex patterns following ancient mathematical principles.
                    </p>
                </div>
            </div>

            <div class="mt-16 relative">
                <div class="rounded-xl overflow-hidden shadow-xl">
                    <img src="{{ asset('images/crafts/zellige-workshop.jpg') }}" alt="Zellige Workshop"
                        class="w-full h-96 object-cover">
                </div>
            </div>
        </div>
    </div>

    <!-- Regional Styles -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Regional Styles & Variations</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Fez Style -->
                <div class="bg-amber-50 rounded-lg overflow-hidden">
                    <div class="aspect-w-4 aspect-h-3">
                        <img src="{{ asset('images/crafts/zellige-fez.jpg') }}" alt="Fez Style Zellige"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Fez Style</h3>
                        <p class="text-gray-700">
                            Known for smaller, more intricate pieces and a traditional blue and white color palette. Fez is
                            the oldest and most prestigious center of Zellige production in Morocco.
                        </p>
                    </div>
                </div>

                <!-- Marrakech Style -->
                <div class="bg-amber-50 rounded-lg overflow-hidden">
                    <div class="aspect-w-4 aspect-h-3">
                        <img src="{{ asset('images/crafts/zellige-marrakech.jpg') }}" alt="Marrakech Style Zellige"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Marrakech Style</h3>
                        <p class="text-gray-700">
                            Features bolder patterns and a wider color palette. Marrakech zellige often incorporates larger
                            pieces with earthy reds and greens inspired by the surrounding landscape.
                        </p>
                    </div>
                </div>

                <!-- Contemporary Adaptations -->
                <div class="bg-amber-50 rounded-lg overflow-hidden">
                    <div class="aspect-w-4 aspect-h-3">
                        <img src="{{ asset('images/crafts/zellige-contemporary.jpg') }}" alt="Contemporary Zellige"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Contemporary Adaptations</h3>
                        <p class="text-gray-700">
                            Modern zellige artisans experiment with new color combinations and applications while
                            maintaining traditional techniques, bringing this ancient craft into contemporary spaces.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Artisans -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-amber-50">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Featured Zellige Masters</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Featured Artisan 1 -->
                <div class="flex bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="w-1/3">
                        <img src="{{ asset('images/featured-artisans/artisan-month.jpg') }}"
                            alt="Mohammed Ziani - Master Zellige Craftsman" class="w-full h-full object-cover">
                    </div>
                    <div class="w-2/3 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Mohammed Ziani</h3>
                        <div class="flex items-center mb-2">
                            <div class="text-amber-400 flex">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="ml-2 text-sm text-gray-600">5.0 (47 reviews)</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Third-generation master from Fez with over 30 years of experience. Specializes in traditional
                            blue and white geometric patterns with exceptional precision.
                        </p>
                        <a href="{{ route('client.artisans.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-amber-600 rounded-md text-white hover:bg-amber-700">
                            View Profile
                        </a>
                    </div>
                </div>

                <!-- Featured Artisan 2 -->
                <div class="flex bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="w-1/3">
                        <img src="{{ asset('images/featured-artisans/zellige-artisan-2.jpg') }}"
                            alt="Amina Tazi - Zellige Designer" class="w-full h-full object-cover">
                    </div>
                    <div class="w-2/3 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Amina Tazi</h3>
                        <div class="flex items-center mb-2">
                            <div class="text-amber-400 flex">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="ml-2 text-sm text-gray-600">4.7 (32 reviews)</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Innovative designer combining traditional techniques with contemporary aesthetics. Known for her
                            unique color combinations and custom residential installations.
                        </p>
                        <a href="{{ route('client.artisans.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-amber-600 rounded-md text-white hover:bg-amber-700">
                            View Profile
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('client.artisans.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-amber-600 rounded-md text-amber-600 hover:bg-amber-50">
                    Find Zellige Craftsmen <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Care Instructions -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="bg-amber-50 rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Care & Maintenance</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Preserving Your Zellige</h3>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start">
                                <i class="fas fa-check text-amber-600 mt-1 mr-2"></i>
                                <span>Clean with gentle, pH-neutral soap and warm water</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-amber-600 mt-1 mr-2"></i>
                                <span>Avoid harsh chemicals and acidic cleaners that can damage the glaze</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-amber-600 mt-1 mr-2"></i>
                                <span>Seal zellige installations every 1-2 years in wet areas like bathrooms</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-amber-600 mt-1 mr-2"></i>
                                <span>Wipe spills quickly to prevent staining of grout lines</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Character of Authentic Zellige</h3>
                        <p class="text-gray-700 mb-4">
                            True handcrafted zellige has natural variations in color, texture, and size that contribute to
                            its unique character. Small imperfections and slight irregularities are hallmarks of authentic
                            artisanal work, not flaws.
                        </p>
                        <p class="text-gray-700">
                            These characteristics create a vibrant, light-reflecting surface that changes appearance
                            throughout the day - a quality that cannot be achieved with mass-produced tile.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-amber-600 py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Ready to Bring Zellige Beauty Into Your Space?</h2>
            <p class="text-lg text-amber-100 mb-8 max-w-3xl mx-auto">
                Connect with skilled zellige craftsmen who can create custom designs for your home, business, or special
                project.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('client.artisans.index') }}"
                    class="px-8 py-3 bg-white text-amber-700 font-medium rounded-md shadow-lg hover:bg-amber-50">
                    Find Zellige Artisans
                </a>
                <a href="{{ route('contact') }}"
                    class="px-8 py-3 border-2 border-white text-white font-medium rounded-md hover:bg-amber-700">
                    Request Custom Work
                </a>
            </div>
        </div>
    </div>
@endsection
