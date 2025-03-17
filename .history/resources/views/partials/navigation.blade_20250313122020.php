<!-- Enhanced Navigation with improved mobile support, transitions, and visual design -->
<nav class="bg-white shadow-md sticky top-0 z-50 transition-all duration-300" x-data="{ scrolled: false, mobileMenuOpen: false }"
    @scroll.window="scrolled = (window.pageYOffset > 20)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Brand -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="flex items-center group">
                    <img src="{{ asset('images/MyArtisanLogo.png') }}" alt="MyArtisan Logo"
                        class="h-10 w-auto mr-3 transition-transform duration-300 group-hover:scale-105">
                    <div class="flex flex-col">
                        <span class="text-xl font-bold text-amber-600 tracking-tight">MyArtisan</span>
                        <span class="arabic-font text-sm text-amber-500">المغرب</span>
                    </div>
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-amber-600 hover:bg-amber-50 focus:outline-none focus:ring-2 focus:ring-amber-500"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }"
                        xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }"
                        xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-1">
                @guest
                    <a href="{{ url('/#features') }}"
                        class="text-gray-600 hover:text-amber-600 hover:bg-amber-50 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Features
                    </a>
                    <a href="{{ url('/#about') }}"
                        class="text-gray-600 hover:text-amber-600 hover:bg-amber-50 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        About
                    </a>
                    <a href="{{ url('/#contact') }}"
                        class="text-gray-600 hover:text-amber-600 hover:bg-amber-50 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Contact
                    </a>
                @endguest
            </div>

            <!-- Authentication Links (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @guest
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-gray-600 hover:text-amber-600 transition-colors duration-200">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors duration-200">
                            Register
                        </a>
                    @endif
                @else
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" type="button"
                                class="flex items-center text-gray-700 hover:text-amber-600 px-3 py-2 rounded-md hover:bg-amber-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="mr-2 text-sm font-medium">{{ Auth::user()->firstname }}
                                    {{ Auth::user()->lastname }}</span>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown menu -->
                        <div x-cloak x-show="open" @click.away="open = false"
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            @if (Auth::user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600"
                                    role="menuitem">Admin Dashboard</a>
                            @elseif (Auth::user()->hasRole('artisan'))
                                <a href="{{ route('artisan.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600"
                                    role="menuitem">Artisan Dashboard</a>
                            @elseif (Auth::user()->hasRole('client'))
                                <a href="{{ route('client.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600"
                                    role="menuitem">Client Dashboard</a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600"
                                    role="menuitem">
                                    {{ __('Logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-cloak x-show="mobileMenuOpen" class="sm:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 border-t border-gray-200">
            @guest
                <a href="{{ url('/#features') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50">Features</a>
                <a href="{{ url('/#about') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50">About</a>
                <a href="{{ url('/#contact') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50">Contact</a>
            @endguest
        </div>

        <!-- Mobile Authentication Links -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            @guest
                <div class="px-2 space-y-1">
                    <a href="{{ route('login') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-amber-600 hover:text-amber-700 hover:bg-amber-50">
                            Register
                        </a>
                    @endif
                </div>
            @else
                <div class="px-4 py-3">
                    <p class="text-sm font-medium text-gray-600">Logged in as:</p>
                    <p class="text-base font-medium text-gray-800">{{ Auth::user()->firstname }}
                        {{ Auth::user()->lastname }}</p>
                </div>
                <div class="px-2 space-y-1">
                    @if (Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50">
                            Admin Dashboard
                        </a>
                    @elseif (Auth::user()->hasRole('artisan'))
                        <a href="{{ route('artisan.dashboard') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50">
                            Artisan Dashboard
                        </a>
                    @elseif (Auth::user()->hasRole('client'))
                        <a href="{{ route('client.dashboard') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50">
                            Client Dashboard
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50">
                            {{ __('Logout') }}
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</nav>
