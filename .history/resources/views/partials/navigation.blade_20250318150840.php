<!-- Enhanced Navigation with improved mobile support, transitions, and visual design -->
<nav class="bg-white shadow-sm" x-data="{ mobileMenuOpen: false, userDropdownOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and primary nav -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <img class="block h-12 w-auto" src="{{ asset('images/logo.png') }}" alt="MyArtisan">
                    </a>
                </div>

                <!-- Primary Navigation -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-6">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-amber-500 text-amber-700' : 'border-transparent text-gray-500 hover:border-amber-300 hover:text-amber-600' }} text-sm font-medium">
                        Home
                    </a>

                    <a href="{{ route('about') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('about') ? 'border-amber-500 text-amber-700' : 'border-transparent text-gray-500 hover:border-amber-300 hover:text-amber-600' }} text-sm font-medium">
                        About
                    </a>

                    <div class="relative inline-block" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('crafts.*') ? 'border-amber-500 text-amber-700' : 'border-transparent text-gray-500 hover:border-amber-300 hover:text-amber-600' }} text-sm font-medium">
                            Crafts
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
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
                            class="absolute z-10 mt-1 left-0 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="{{ route('crafts.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">All
                                    Crafts</a>
                                <a href="{{ route('crafts.zellige') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">Zellige
                                    Tilework</a>
                                <a href="{{ route('crafts.carpets') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">Carpet
                                    Weaving</a>
                                <a href="{{ route('crafts.leather') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">Leather
                                    Crafting</a>
                                <a href="{{ route('crafts.metalwork') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">Metalwork</a>
                                <a href="{{ route('crafts.pottery') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">Pottery
                                    & Ceramics</a>
                                <a href="{{ route('crafts.woodwork') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">Woodwork</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('featured-artisans') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('featured-artisans') ? 'border-amber-500 text-amber-700' : 'border-transparent text-gray-500 hover:border-amber-300 hover:text-amber-600' }} text-sm font-medium">
                        Artisans
                    </a>

                    <a href="{{ route('blog.index') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('blog.index') ? 'border-amber-500 text-amber-700' : 'border-transparent text-gray-500 hover:border-amber-300 hover:text-amber-600' }} text-sm font-medium">
                        Blog
                    </a>

                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('contact') ? 'border-amber-500 text-amber-700' : 'border-transparent text-gray-500 hover:border-amber-300 hover:text-amber-600' }} text-sm font-medium">
                        Contact
                    </a>
                </div>
            </div>

            <!-- User navigation -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-3">
                @guest
                    <a href="{{ route('login') }}"
                        class="text-sm px-4 py-2 border border-transparent rounded-md text-amber-600 hover:text-amber-700">Log
                        in</a>
                    <a href="{{ route('register') }}"
                        class="text-sm px-4 py-2 border border-amber-500 rounded-md bg-amber-500 text-white hover:bg-amber-600 hover:border-amber-600">Sign
                        up</a>
                @else
                    <!-- User Dropdown -->
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open"
                                class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500"
                                id="user-menu" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <div
                                    class="h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 font-semibold text-sm">
                                    {{ substr(Auth::user()->firstname, 0, 1) }}{{ substr(Auth::user()->lastname, 0, 1) }}
                                </div>
                            </button>
                        </div>

                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-200 py-1 z-50">

                            <!-- User Info section -->
                            <div class="px-4 py-3">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                                </p>
                                <p class="text-sm text-gray-500 truncate">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>

                            <!-- Dashboard Links -->
                            <div class="py-1">
                                @if (Auth::user()->hasRole('client'))
                                    <a href="{{ route('client.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                        Client Dashboard
                                    </a>
                                @endif

                                @if (Auth::user()->hasRole('artisan'))
                                    <a href="{{ route('artisan.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                        Artisan Dashboard
                                    </a>
                                @endif

                                @if (Auth::user()->hasRole('admin'))
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                        Admin Dashboard
                                    </a>
                                @endif
                            </div>

                            <!-- Settings & Logout -->
                            <div class="py-1">
                                @if (Auth::user()->hasRole('client'))
                                    <a href="{{ route('client.settings') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                        Account Settings
                                    </a>
                                @endif

                                @if (Auth::user()->hasRole('artisan'))
                                    <a href="{{ route('artisan.settings') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                        Account Settings
                                    </a>
                                @endif

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-amber-500">
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

    <!-- Mobile menu, show/hide based on menu state -->
    <div x-show="mobileMenuOpen" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}"
                class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-amber-300' }}">Home</a>
            <a href="{{ route('about') }}"
                class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('about') ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-amber-300' }}">About</a>

            <div x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex justify-between items-center pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('crafts.*') ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-amber-300' }}">
                    <span>Crafts</span>
                    <svg :class="{ 'transform rotate-180': open }" class="ml-2 h-4 w-4 transition-transform"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open" class="bg-gray-50 pl-7">
                    <a href="{{ route('crafts.index') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-amber-600">All Crafts</a>
                    <a href="{{ route('crafts.zellige') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-amber-600">Zellige Tilework</a>
                    <a href="{{ route('crafts.carpets') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-amber-600">Carpet Weaving</a>
                    <a href="{{ route('crafts.leather') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-amber-600">Leather Crafting</a>
                    <a href="{{ route('crafts.metalwork') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-amber-600">Metalwork</a>
                    <a href="{{ route('crafts.pottery') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-amber-600">Pottery & Ceramics</a>
                    <a href="{{ route('crafts.woodwork') }}"
                        class="block py-2 text-sm text-gray-600 hover:text-amber-600">Woodwork</a>
                </div>
            </div>

            <a href="{{ route('featured-artisans') }}"
                class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('featured-artisans') ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-amber-300' }}">Artisans</a>
            <a href="{{ route('blog.index') }}"
                class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('blog.index') ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-amber-300' }}">Blog</a>
            <a href="{{ route('faq') }}"
                class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('faq') ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-amber-300' }}">FAQ</a>
            <a href="{{ route('contact') }}"
                class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('contact') ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-amber-300' }}">Contact</a>
        </div>

        <!-- Mobile Authentication Links -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            @guest
                <div class="px-4 space-y-2">
                    <a href="{{ route('login') }}"
                        class="block text-center px-4 py-2 text-sm font-medium text-amber-600 hover:text-amber-700 border border-amber-300 rounded-md">Log
                        in</a>
                    <a href="{{ route('register') }}"
                        class="block text-center px-4 py-2 text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-md">Sign
                        up</a>
                </div>
            @else
                <div class="px-4 py-3 flex items-center">
                    <div class="h-10 w-10 bg-amber-100 rounded-full flex items-center justify-center">
                        <span
                            class="text-amber-700 font-medium">{{ substr(Auth::user()->firstname, 0, 1) }}{{ substr(Auth::user()->lastname, 0, 1) }}</span>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->firstname }}
                            {{ Auth::user()->lastname }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 border-t border-gray-200 pt-2">
                    @if (Auth::user()->hasRole('client'))
                        <a href="{{ route('client.dashboard') }}"
                            class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
                            Client Dashboard
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('artisan'))
                        <a href="{{ route('artisan.dashboard') }}"
                            class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
                            Artisan Dashboard
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
                            Admin Dashboard
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
                            Sign out
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</nav>
