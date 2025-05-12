<!-- Enhanced Navigation with glass morphism effect, improved animations and modern styling -->
<nav class="bg-white/95 backdrop-blur-sm shadow-md border-b border-gray-100/40 sticky top-0 z-30" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and primary nav -->
            <div class="flex">
                <!-- Logo with enhanced styling -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center group">
                        <div class="relative overflow-hidden rounded-lg">
                            <img class="h-10 w-auto transition-all duration-300 group-hover:scale-105"
                                src="{{ asset('images/logoartisan1.png') }}" alt="MyArtisan">
                        </div>
                        <span
                            class="ml-2 text-amber-600 font-bold text-lg hidden md:block transition-all duration-300 group-hover:text-amber-500">
                            MyArtisan
                        </span>
                    </a>
                </div>

                <!-- Enhanced Primary Navigation -->
                <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 relative group {{ request()->routeIs('home') ? 'border-amber-500 text-amber-700 font-medium' : 'border-transparent text-gray-500 hover:border-amber-300 hover:text-amber-600' }} text-sm">
                        <span
                            class="absolute inset-x-0 bottom-0 h-0 group-hover:h-1 bg-amber-200/50 transition-all duration-200 rounded-t-md {{ request()->routeIs('home') ? 'hidden' : '' }}"></span>
                        Home
                    </a>

                    <a href="{{ route('about') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 relative group {{ request()->routeIs('about') ? 'border-amber-500 text-amber-700 font-medium' : 'border-transparent text-gray-500 hover:border-amber-300 hover:text-amber-600' }} text-sm">
                        <span
                            class="absolute inset-x-0 bottom-0 h-0 group-hover:h-1 bg-amber-200/50 transition-all duration-200 rounded-t-md {{ request()->routeIs('about') ? 'hidden' : '' }}"></span>
                        About
                    </a>

                    <!-- Enhanced dropdown with better interactions -->
                    <div class="relative inline-block" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="inline-flex items-center px-1 pt-1 border-b-2 relative group {{ request()->routeIs('crafts.*') ? 'border-amber-500 text-amber-700 font-medium' : 'border-transparent text-gray-500 hover:border-amber-300 hover:text-amber-600' }} text-sm">
                            <span
                                class="absolute inset-x-0 bottom-0 h-0 group-hover:h-1 bg-amber-200/50 transition-all duration-200 rounded-t-md {{ request()->routeIs('crafts.*') ? 'hidden' : '' }}"></span>
                            Crafts
                            <svg class="ml-1 h-4 w-4 transition-transform duration-300" :class="{ 'rotate-180': open }"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute z-10 mt-3 left-0 w-64 rounded-lg shadow-xl bg-white/95 backdrop-blur-sm ring-1 ring-black/5 border border-gray-100/50 overflow-hidden"
                            x-cloak>
                            <div class="py-2" role="menu" aria-orientation="vertical">
                                <div class="px-4 py-2 bg-amber-50/50 border-l-2 border-amber-400 mb-1">
                                    <span class="text-xs font-medium text-amber-800">Browse by category</span>
                                </div>
                                <a href="{{ route('crafts.index') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50/80 hover:text-amber-600 transition duration-150 group"
                                    role="menuitem">
                                    <span
                                        class="w-1 h-4 mr-2 rounded-full bg-amber-300 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                    All Crafts
                                </a>
                                <a href="{{ route('crafts.zellige') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50/80 hover:text-amber-600 transition duration-150 group"
                                    role="menuitem">
                                    <span
                                        class="w-1 h-4 mr-2 rounded-full bg-amber-300 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                    Zellige Tilework
                                </a>
                                <a href="{{ route('crafts.carpets') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50/80 hover:text-amber-600 transition duration-150 group"
                                    role="menuitem">
                                    <span
                                        class="w-1 h-4 mr-2 rounded-full bg-amber-300 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                    Carpet Weaving
                                </a>
                                <a href="{{ route('crafts.leather') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50/80 hover:text-amber-600 transition duration-150 group"
                                    role="menuitem">
                                    <span
                                        class="w-1 h-4 mr-2 rounded-full bg-amber-300 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                    Leather Crafting
                                </a>
                                <a href="{{ route('crafts.metalwork') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50/80 hover:text-amber-600 transition duration-150 group"
                                    role="menuitem">
                                    <span
                                        class="w-1 h-4 mr-2 rounded-full bg-amber-300 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                    Metalwork
                                </a>
                                <a href="{{ route('crafts.pottery') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50/80 hover:text-amber-600 transition duration-150 group"
                                    role="menuitem">
                                    <span
                                        class="w-1 h-4 mr-2 rounded-full bg-amber-300 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                    Pottery & Ceramics
                                </a>
                                <a href="{{ route('crafts.woodwork') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50/80 hover:text-amber-600 transition duration-150 group"
                                    role="menuitem">
                                    <span
                                        class="w-1 h-4 mr-2 rounded-full bg-amber-300 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                    Woodwork
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('featured-artisans') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 relative group {{ request()->routeIs('featured-artisans') ? 'border-amber-500 text-amber-700 font-medium' : 'border-transparent text-gray-500 hover:border-amber-300 hover:text-amber-600' }} text-sm">
                        <span
                            class="absolute inset-x-0 bottom-0 h-0 group-hover:h-1 bg-amber-200/50 transition-all duration-200 rounded-t-md {{ request()->routeIs('featured-artisans') ? 'hidden' : '' }}"></span>
                        Artisans
                    </a>

                    <a href="{{ route('blog.index') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 relative group {{ request()->routeIs('blog.index') ? 'border-amber-500 text-amber-700 font-medium' : 'border-transparent text-gray-500 hover:border-amber-300 hover:text-amber-600' }} text-sm">
                        <span
                            class="absolute inset-x-0 bottom-0 h-0 group-hover:h-1 bg-amber-200/50 transition-all duration-200 rounded-t-md {{ request()->routeIs('blog.index') ? 'hidden' : '' }}"></span>
                        Blog
                    </a>

                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 relative group {{ request()->routeIs('contact') ? 'border-amber-500 text-amber-700 font-medium' : 'border-transparent text-gray-500 hover:border-amber-300 hover:text-amber-600' }} text-sm">
                        <span
                            class="absolute inset-x-0 bottom-0 h-0 group-hover:h-1 bg-amber-200/50 transition-all duration-200 rounded-t-md {{ request()->routeIs('contact') ? 'hidden' : '' }}"></span>
                        Contact
                    </a>
                </div>
            </div>

            <!-- Enhanced User navigation -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-3">
                @guest
                    <a href="{{ route('login') }}"
                        class="text-sm px-4 py-2 border border-gray-200 rounded-md text-amber-600 hover:text-amber-700 hover:border-amber-300 transition-all duration-200 group">
                        <span class="group-hover:underline underline-offset-2">Log in</span>
                    </a>
                    <a href="{{ route('register') }}"
                        class="text-sm px-4 py-2 border border-amber-500 rounded-md bg-gradient-to-br from-amber-500 to-amber-600 text-white hover:from-amber-600 hover:to-amber-700 hover:border-amber-600 transition-all duration-300 shadow-sm hover:shadow group">
                        <span class="group-hover:translate-x-0.5 transition-transform inline-block">Sign up</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-3 w-3 inline-block ml-1 group-hover:translate-x-0.5 transition-transform"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @else
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" @click.away="open = false"
                                class="flex rounded-full outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500"
                                id="user-menu" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <div
                                    class="h-9 w-9 rounded-full bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center text-white font-semibold text-sm overflow-hidden shadow-inner border-2 border-white transition-transform duration-500 hover:scale-105 hover:rotate-3">
                                    {{ substr(Auth::user()->firstname, 0, 1) }}{{ substr(Auth::user()->lastname, 0, 1) }}
                                </div>
                            </button>
                        </div>

                        <!-- Enhanced user dropdown menu -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white/95 backdrop-blur-sm ring-1 ring-black/5 divide-y divide-gray-200/80 z-50 border border-gray-100/50"
                            x-cloak>

                            <div class="py-2">
                                <div
                                    class="px-4 py-3 bg-gradient-to-r from-amber-50/50 to-white border-l-2 border-amber-400">
                                    <p class="text-xs text-gray-500">Signed in as</p>
                                    <p class="font-medium text-gray-800 text-sm truncate">{{ Auth::user()->email }}</p>
                                </div>

                                @if (Auth::user()->hasRole('client'))
                                    <a href="{{ route('client.dashboard') }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 transition duration-150">
                                        <i class="fas fa-tachometer-alt w-5 text-gray-400 mr-2"></i>
                                        Client Dashboard
                                    </a>
                                @endif

                                @if (Auth::user()->hasRole('artisan'))
                                    <a href="{{ route('artisan.dashboard') }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 transition duration-150">
                                        <i class="fas fa-palette w-5 text-gray-400 mr-2"></i>
                                        Artisan Dashboard
                                    </a>
                                @endif

                                @if (Auth::user()->hasRole('admin'))
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 transition duration-150">
                                        <i class="fas fa-user-shield w-5 text-gray-400 mr-2"></i>
                                        Admin Dashboard
                                    </a>
                                @endif

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex w-full text-left items-center px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-150 group">
                                        <span
                                            class="w-5 h-5 flex items-center justify-center mr-2 rounded-full bg-red-100 text-red-500 group-hover:bg-red-200 transition-colors">
                                            <i class="fas fa-sign-out-alt text-xs"></i>
                                        </span>
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Enhanced Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="inline-flex items-center justify-center p-2 rounded-md text-amber-500 hover:text-amber-600 hover:bg-amber-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-amber-500 transition duration-150"
                    aria-expanded="false" :aria-expanded="mobileMenuOpen.toString()">
                    <span class="sr-only">Open main menu</span>
                    <svg :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Enhanced Mobile menu -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-4"
        class="sm:hidden shadow-lg bg-white/95 backdrop-blur-sm border-b border-gray-100/50" x-cloak>
        <div class="pt-2 pb-3 space-y-1">
            <!-- Enhanced mobile menu links with visual improvements -->
            <a href="{{ route('home') }}"
                class="block pl-4 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'border-amber-500 text-amber-700 bg-amber-50/70 font-medium' : 'border-transparent text-gray-600 hover:bg-gray-50/80 hover:border-amber-300' }} transition duration-150">
                Home
            </a>
            <a href="{{ route('about') }}"
                class="block pl-4 pr-4 py-2 border-l-4 {{ request()->routeIs('about') ? 'border-amber-500 text-amber-700 bg-amber-50/70 font-medium' : 'border-transparent text-gray-600 hover:bg-gray-50/80 hover:border-amber-300' }} transition duration-150">
                About
            </a>

            <div x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex justify-between items-center pl-4 pr-4 py-2 border-l-4 {{ request()->routeIs('crafts.*') ? 'border-amber-500 text-amber-700 bg-amber-50/70 font-medium' : 'border-transparent text-gray-600 hover:bg-gray-50/80 hover:border-amber-300' }} transition duration-150">
                    <span>Crafts</span>
                    <svg :class="{ 'transform rotate-180': open }"
                        class="ml-2 h-4 w-4 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="bg-gray-50">
                    <a href="{{ route('crafts.index') }}"
                        class="block py-2 pl-10 pr-4 text-sm text-gray-600 hover:text-amber-600 transition duration-150">All
                        Crafts</a>
                    <a href="{{ route('crafts.zellige') }}"
                        class="block py-2 pl-10 pr-4 text-sm text-gray-600 hover:text-amber-600 transition duration-150">Zellige
                        Tilework</a>
                    <a href="{{ route('crafts.carpets') }}"
                        class="block py-2 pl-10 pr-4 text-sm text-gray-600 hover:text-amber-600 transition duration-150">Carpet
                        Weaving</a>
                    <a href="{{ route('crafts.leather') }}"
                        class="block py-2 pl-10 pr-4 text-sm text-gray-600 hover:text-amber-600 transition duration-150">Leather
                        Crafting</a>
                    <a href="{{ route('crafts.metalwork') }}"
                        class="block py-2 pl-10 pr-4 text-sm text-gray-600 hover:text-amber-600 transition duration-150">Metalwork</a>
                    <a href="{{ route('crafts.pottery') }}"
                        class="block py-2 pl-10 pr-4 text-sm text-gray-600 hover:text-amber-600 transition duration-150">Pottery
                        & Ceramics</a>
                    <a href="{{ route('crafts.woodwork') }}"
                        class="block py-2 pl-10 pr-4 text-sm text-gray-600 hover:text-amber-600 transition duration-150">Woodwork</a>
                </div>
            </div>

            <a href="{{ route('featured-artisans') }}"
                class="block pl-4 pr-4 py-2 border-l-4 {{ request()->routeIs('featured-artisans') ? 'border-amber-500 text-amber-700 bg-amber-50/70 font-medium' : 'border-transparent text-gray-600 hover:bg-gray-50/80 hover:border-amber-300' }} transition duration-150">Artisans</a>
            <a href="{{ route('blog.index') }}"
                class="block pl-4 pr-4 py-2 border-l-4 {{ request()->routeIs('blog.index') ? 'border-amber-500 text-amber-700 bg-amber-50/70 font-medium' : 'border-transparent text-gray-600 hover:bg-gray-50/80 hover:border-amber-300' }} transition duration-150">Blog</a>
            <a href="{{ route('contact') }}"
                class="block pl-4 pr-4 py-2 border-l-4 {{ request()->routeIs('contact') ? 'border-amber-500 text-amber-700 bg-amber-50/70 font-medium' : 'border-transparent text-gray-600 hover:bg-gray-50/80 hover:border-amber-300' }} transition duration-150">Contact</a>
        </div>

        <!-- Enhanced Mobile Authentication Links -->
        @guest
            <div class="pt-4 pb-4 border-t border-gray-200/70 bg-gray-50/90">
                <div class="px-4 space-y-3">
                    <a href="{{ route('login') }}"
                        class="block text-center px-4 py-3 text-sm font-medium text-amber-600 hover:text-amber-700 border border-amber-300 rounded-lg bg-white hover:bg-amber-50 transition-all duration-200 shadow-sm">
                        <i class="fas fa-sign-in-alt mr-2"></i> Log in to your account
                    </a>
                    <a href="{{ route('register') }}"
                        class="block text-center px-4 py-3 text-sm font-medium text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 rounded-lg shadow-sm transition-all duration-200">
                        <i class="fas fa-user-plus mr-2"></i> Create a new account
                    </a>
                </div>
            </div>
        @else
            <!-- Enhanced mobile user profile area -->
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="px-4 py-3 bg-gradient-to-r from-amber-50 to-white rounded-lg mx-2 shadow-sm">
                    <div class="flex items-center">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-full flex items-center justify-center text-white shadow-inner border-2 border-white">
                            <span
                                class="font-semibold text-base">{{ substr(Auth::user()->firstname, 0, 1) }}{{ substr(Auth::user()->lastname, 0, 1) }}</span>
                        </div>
                        <div class="ml-4 truncate">
                            <div class="text-base font-medium text-gray-800">{{ Auth::user()->firstname }}
                                {{ Auth::user()->lastname }}</div>
                            <div class="text-sm font-medium text-amber-600 truncate">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 bg-white">
                    @if (Auth::user()->hasRole('client'))
                        <a href="{{ route('client.dashboard') }}"
                            class="flex items-center px-4 py-2 text-base text-gray-600 hover:text-amber-600 hover:bg-gray-50 transition duration-150">
                            <i class="fas fa-tachometer-alt w-5 text-gray-400 mr-2"></i>
                            Client Dashboard
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('artisan'))
                        <a href="{{ route('artisan.dashboard') }}"
                            class="flex items-center px-4 py-2 text-base text-gray-600 hover:text-amber-600 hover:bg-gray-50 transition duration-150">
                            <i class="fas fa-palette w-5 text-gray-400 mr-2"></i>
                            Artisan Dashboard
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center px-4 py-2 text-base text-gray-600 hover:text-amber-600 hover:bg-gray-50 transition duration-150">
                            <i class="fas fa-user-shield w-5 text-gray-400 mr-2"></i>
                            Admin Dashboard
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left flex items-center px-4 py-2 text-base text-gray-600 hover:text-amber-600 hover:bg-gray-50 transition duration-150">
                            <i class="fas fa-sign-out-alt w-5 text-gray-400 mr-2"></i>
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        @endguest
    </div>
</nav>
