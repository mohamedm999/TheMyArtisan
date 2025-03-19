@extends('layouts.app')

@section('title', 'Traditional Moroccan Crafts - MyArtisan')
@section('description', 'Explore the rich diversity of traditional Moroccan crafts including zellige tilework, carpet
    weaving, leather crafting, metalwork, pottery, and woodwork.')

@section('content')
    <div class="bg-amber-50 py-12 px-4 sm:px-6 lg:px-8">
        <!-- Hero section -->
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl font-bold text-amber-800 mb-6">Traditional Moroccan Crafts</h1>
            <p class="text-lg text-gray-700 max-w-3xl mx-auto">
                Morocco's artistic heritage spans centuries of cultural exchange and refined techniques. Discover the
                diverse crafts that define Moroccan artistry.
            </p>
        </div>
    </div>

    <!-- Crafts Categories Overview -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                <!-- Zellige Tilework -->
                <div class="group">
                    <a href="{{ route('crafts.zellige') }}" class="block relative rounded-lg overflow-hidden">
                        <img src="{{ asset('images/crafts/zellige.jpg') }}" alt="Zellige Tilework"
                            class="w-full h-64 object-cover transform group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-1">Zellige Tilework</h3>
                                <p class="text-sm text-amber-200">Geometric mosaic artistry</p>
                            </div>
                        </div>
                    </a>
                    <div class="mt-4">
                        <p class="text-gray-600">
                            Intricate geometric mosaics crafted from individually chiseled tiles, Zellige is one of
                            Morocco's most distinctive art forms, adorning fountains, walls, and floors.
                        </p>
                        <a href="{{ route('crafts.zellige') }}"
                            class="inline-flex items-center mt-3 text-amber-600 hover:text-amber-700">
                            Learn more <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Carpet Weaving -->
                <div class="group">
                    <a href="{{ route('crafts.carpets') }}" class="block relative rounded-lg overflow-hidden">
                        <img src="{{ asset('images/crafts/carpet.jpg') }}" alt="Moroccan Carpet Weaving"
                            class="w-full h-64 object-cover transform group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-1">Carpet Weaving</h3>
                                <p class="text-sm text-amber-200">Berber textile traditions</p>
                            </div>
                        </div>
                    </a>
                    <div class="mt-4">
                        <p class="text-gray-600">
                            From the vibrant tribal rugs of the Atlas Mountains to the sophisticated city productions,
                            Moroccan carpets tell stories through symbols and patterns.
                        </p>
                        <a href="{{ route('crafts.carpets') }}"
                            class="inline-flex items-center mt-3 text-amber-600 hover:text-amber-700">
                            Learn more <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Leather Crafting -->
                <div class="group">
                    <a href="{{ route('crafts.leather') }}" class="block relative rounded-lg overflow-hidden">
                        <img src="{{ asset('images/crafts/leather.jpg') }}" alt="Moroccan Leather Crafting"
                            class="w-full h-64 object-cover transform group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-1">Leather Crafting</h3>
                                <p class="text-sm text-amber-200">Traditional tanning and leatherwork</p>
                            </div>
                        </div>
                    </a>
                    <div class="mt-4">
                        <p class="text-gray-600">
                            Centered in Fez's historic tanneries, Morocco's leather tradition produces vibrant, supple
                            materials crafted into bags, poufs, footwear, and accessories.
                        </p>
                        <a href="{{ route('crafts.leather') }}"
                            class="inline-flex items-center mt-3 text-amber-600 hover:text-amber-700">
                            Learn more <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Metalwork -->
                <div class="group">
                    <a href="{{ route('crafts.metalwork') }}" class="block relative rounded-lg overflow-hidden">
                        <img src="{{ asset('images/crafts/metalwork.jpg') }}" alt="Moroccan Metalwork"
                            class="w-full h-64 object-cover transform group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-1">Metalwork</h3>
                                <p class="text-sm text-amber-200">Ornate brass, copper, and silver craft</p>
                            </div>
                        </div>
                    </a>
                    <div class="mt-4">
                        <p class="text-gray-600">
                            From elaborately pierced lamps to teapots and decorative items, Moroccan metalsmiths create
                            pieces that play with light and shadow through detailed patterns.
                        </p>
                        <a href="{{ route('crafts.metalwork') }}"
                            class="inline-flex items-center mt-3 text-amber-600 hover:text-amber-700">
                            Learn more <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Pottery & Ceramics -->
                <div class="group">
                    <a href="{{ route('crafts.pottery') }}" class="block relative rounded-lg overflow-hidden">
                        <img src="{{ asset('images/crafts/pottery.jpg') }}" alt="Moroccan Pottery"
                            class="w-full h-64 object-cover transform group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-1">Pottery & Ceramics</h3>
                                <p class="text-sm text-amber-200">Handcrafted clay traditions</p>
                            </div>
                        </div>
                    </a>
                    <div class="mt-4">
                        <p class="text-gray-600">
                            Each region of Morocco has its distinctive pottery style, from Safi's colorful ceramics to Fez's
                            refined blue and white designs to Tamegroute's unique green glaze.
                        </p>
                        <a href="{{ route('crafts.pottery') }}"
                            class="inline-flex items-center mt-3 text-amber-600 hover:text-amber-700">
                            Learn more <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Woodwork -->
                <div class="group">
                    <a href="{{ route('crafts.woodwork') }}" class="block relative rounded-lg overflow-hidden">
                        <img src="{{ asset('images/crafts/woodwork.jpg') }}" alt="Moroccan Woodwork"
                            class="w-full h-64 object-cover transform group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-1">Woodwork</h3>
                                <p class="text-sm text-amber-200">Carved cedar and thuya artistry</p>
                            </div>
                        </div>
                    </a>
                    <div class="mt-4">
                        <p class="text-gray-600">
                            From intricately carved doors and furniture to delicate inlay work using cedar, thuya, and other
                            woods, Moroccan woodworkers create pieces that blend beauty and function.
                        </p>
                        <a href="{{ route('crafts.woodwork') }}"
                            class="inline-flex items-center mt-3 text-amber-600 hover:text-amber-700">
                            Learn more <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Craft Preservation -->
    <div class="bg-amber-50 py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-amber-800 mb-6">Preserving Morocco's Craft Heritage</h2>
                    <p class="text-gray-700 mb-4">
                        These traditional crafts represent centuries of knowledge passed down through generations, each with
                        techniques unique to specific regions and communities across Morocco.
                    </p>
                    <p class="text-gray-700 mb-4">
                        At MyArtisan, we're dedicated to supporting the artisans who maintain these traditions and helping
                        them connect with appreciative customers worldwide. By supporting these craftspeople, you help
                        preserve cultural knowledge that might otherwise be lost.
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('client.artisans.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-amber-600 text-white rounded-md shadow-md hover:bg-amber-700">
                            Find Artisans <i class="fas fa-search ml-2"></i>
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-w-16 aspect-h-12 rounded-lg overflow-hidden shadow-xl">
                        <img src="{{ asset('images/crafts/workshop.jpg') }}" alt="Artisan Workshop"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-amber-100 rounded-lg -z-10"></div>
                    <div class="absolute -top-4 -left-4 w-32 h-32 bg-amber-200 rounded-lg -z-10"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
