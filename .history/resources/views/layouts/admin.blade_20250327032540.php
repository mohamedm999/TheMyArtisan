<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'MyArtisan Admin Dashboard')">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - MyArtisan</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                            950: '#082f49',
                        },
                    },
                },
            },
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @yield('styles')
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white border-b border-gray-200 sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center md:hidden">
                        <button type="button" x-data @click="$dispatch('toggle-sidebar')" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-primary-500 p-2 rounded-md">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                            <span class="text-xl font-bold text-primary-700">MyArtisan Admin</span>
                        </a>
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <i class="fas fa-bell"></i>
                                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div class="py-2">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                                    </div>
                                    <div class="max-h-60 overflow-y-auto">
                                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition duration-150 ease-in-out">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 bg-primary-100 rounded-full p-2">
                                                    <i class="fas fa-user-plus text-primary-600 text-sm"></i>
                                                </div>
                                                <div class="ml-3 w-0 flex-1">
                                                    <p class="text-sm font-medium text-gray-900">New user registered</p>
                                                    <p class="text-xs text-gray-500">5 minutes ago</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition duration-150 ease-in-out">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 bg-green-100 rounded-full p-2">
                                                    <i class="fas fa-calendar-check text-green-600 text-sm"></i>
                                                </div>
                                                <div class="ml-3 w-0 flex-1">
                                                    <p class="text-sm font-medium text-gray-900">New booking confirmed</p>
                                                    <p class="text-xs text-gray-500">1 hour ago</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="border-t border-gray-100 px-4 py-2">
                                        <a href="#" class="text-xs font-medium text-primary-600 hover:text-primary-700">View all notifications</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-full">
                                <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700">
                                    <span class="text-sm font-medium">{{ substr(Auth::user()->firstname, 0, 1) }}{{ substr(Auth::user()->lastname, 0, 1) }}</span>
                                </div>
                                <span class="hidden md:inline-block text-sm">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
                                <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Settings</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex flex-grow">
            <!-- Sidebar -->
            <div x-data="{ open: true }" @toggle-sidebar.window="open = !open" :class="{'hidden': !open}" class="fixed inset-y-0 left-0 z-20 w-64 transform transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0 bg-white border-r border-gray-200 pt-16 md:pt-0">
                <div class="flex flex-col h-full">
                    <div class="p-4 overflow-y-auto">
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-primary-600' : 'text-gray-400' }}"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <i class="fas fa-users w-5 h-5 mr-3 {{ request()->routeIs('admin.users.*') ? 'text-primary-600' : 'text-gray-400' }}"></i>
                                    <span>Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.artisans.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.artisans.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <i class="fas fa-hammer w-5 h-5 mr-3 {{ request()->routeIs('admin.artisans.*') ? 'text-primary-600' : 'text-gray-400' }}"></i>
                                    <span>Artisans</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <i class="fas fa-tags w-5 h-5 mr-3 {{ request()->routeIs('admin.categories.*') ? 'text-primary-600' : 'text-gray-400' }}"></i>
                                    <span>Categories</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.services.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.services.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <i class="fas fa-briefcase w-5 h-5 mr-3 {{ request()->routeIs('admin.services.*') ? 'text-primary-600' : 'text-gray-400' }}"></i>
                                    <span>Services</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.bookings.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.bookings.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <i class="fas fa-calendar w-5 h-5 mr-3 {{ request()->routeIs('admin.bookings.*') ? 'text-primary-600' : 'text-gray-400' }}"></i>
                                    <span>Bookings</span>
                                </a>
                            </li>

                            <li class="pt-4 mt-4 border-t border-gray-200">
                                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <i class="fas fa-cog w-5 h-5 mr-3 {{ request()->routeIs('admin.settings.*') ? 'text-primary-600' : 'text-gray-400' }}"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-auto p-4 border-t border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700">
                                    <span class="text-sm font-medium">{{ substr(Auth::user()->firstname, 0, 1) }}{{ substr(Auth::user()->lastname, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-grow w-full bg-gray-50 p-4 md:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Backdrop for mobile sidebar -->
    <div x-data="{ open: false }" @toggle-sidebar.window="open = !open" x-show="open" @click="open = false; $dispatch('toggle-sidebar')" class="fixed inset-0 z-10 bg-gray-900 bg-opacity-50 lg:hidden" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v3.12.0/dist/alpine.min.js" defer></script>
    @yield('scripts')
</body>

</html>
