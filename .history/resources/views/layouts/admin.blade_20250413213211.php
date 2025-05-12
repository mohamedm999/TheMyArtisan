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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
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
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        [x-cloak] { display: none !important; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-animation {
            animation: fadeIn 0.2s ease-out;
        }
    </style>

    @yield('styles')
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white border-b border-gray-200 sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center md:hidden">
                        <button type="button" x-data @click="document.querySelector('body').classList.toggle('sidebar-open')"
                            class="text-gray-500 hover:text-primary-600 focus:outline-none">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                    </div>

                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                            <span class="text-xl font-bold text-primary-700">MyArtisan Admin</span>
                        </a>
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }" x-cloak>
                            <button @click="open = !open" class="p-1 rounded-full text-gray-500 hover:text-primary-600 hover:bg-gray-100 focus:outline-none">
                                <span class="sr-only">View notifications</span>
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"></span>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="dropdown-animation origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <h3 class="text-sm font-medium text-gray-700">Notifications</h3>
                                </div>
                                <div class="max-h-60 overflow-y-auto">
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 bg-primary-100 rounded-full p-2">
                                                <i class="fas fa-user-plus text-primary-600 text-sm"></i>
                                            </div>
                                            <div class="ml-3 w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900">New user registered</p>
                                                <p class="text-xs text-gray-500">2 minutes ago</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition">
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
                                    <a href="#" class="text-xs font-medium text-primary-600 hover:text-primary-800">View all notifications</a>
                                </div>
                            </div>
                        </div>

                        <!-- User dropdown -->
                        <div class="relative" x-data="{ open: false }" x-cloak>
                            <button @click="open = !open" class="flex items-center gap-2 text-gray-700 hover:text-primary-600 focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700">
                                    <span class="text-sm font-medium">{{ substr(Auth::user()->firstname, 0, 1) }}{{ substr(Auth::user()->lastname, 0, 1) }}</span>
                                </div>
                                <span class="hidden md:block text-sm font-medium">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{'rotate-180': open}"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="dropdown-animation origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-xs text-gray-500">Signed in as</p>
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <i class="fas fa-tachometer-alt w-5 text-gray-400"></i>
                                    Dashboard
                                </a>
                                <a href="{{ route('admin.settings.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <i class="fas fa-cog w-5 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="border-t border-gray-100 mt-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                        <i class="fas fa-sign-out-alt w-5"></i>
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
            <div class="fixed inset-y-0 left-0 z-20 transform md:translate-x-0 -translate-x-full transition duration-300 ease-in-out md:relative md:flex md:flex-col md:justify-between md:w-64 h-full bg-white border-r border-gray-200 shadow-sm overflow-y-auto sidebar">
                <div class="flex flex-col h-full">
                    <div class="p-4 md:pt-8">
                        <div class="md:hidden flex items-center justify-between mb-6">
                            <span class="text-xl font-bold text-primary-700">MyArtisan Admin</span>
                            <button type="button" x-data @click="document.querySelector('body').classList.toggle('sidebar-open')"
                                class="text-gray-500 hover:text-primary-600 focus:outline-none">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>

                        <div class="space-y-0.5">
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg group transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-100' }}">
                                <i class="fas fa-tachometer-alt w-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}"></i>
                                <span>Dashboard</span>
                            </a>

                            <a href="{{ route('admin.users.index') }}"
                                class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg group transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-100' }}">
                                <i class="fas fa-users w-5 mr-3 {{ request()->routeIs('admin.users.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}"></i>
                                <span>Users</span>
                            </a>

                            <a href="{{ route('admin.artisans.index') }}"
                                class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg group transition-all duration-200 {{ request()->routeIs('admin.artisans.*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-100' }}">
                                <i class="fas fa-hammer w-5 mr-3 {{ request()->routeIs('admin.artisans.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}"></i>
                                <span>Artisans</span>
                            </a>

                            <a href="{{ route('admin.categories.index') }}"
                                class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg group transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-100' }}">
                                <i class="fas fa-tags w-5 mr-3 {{ request()->routeIs('admin.categories.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}"></i>
                                <span>Categories</span>
                            </a>

                            <a href="{{ route('admin.services.index') }}"
                                class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg group transition-all duration-200 {{ request()->routeIs('admin.services.*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-100' }}">
                                <i class="fas fa-briefcase w-5 mr-3 {{ request()->routeIs('admin.services.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}"></i>
                                <span>Services</span>
                            </a>

                            <a href="{{ route('admin.bookings.index') }}"
                                class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg group transition-all duration-200 {{ request()->routeIs('admin.bookings.*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-100' }}">
                                <i class="fas fa-calendar w-5 mr-3 {{ request()->routeIs('admin.bookings.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}"></i>
                                <span>Bookings</span>
                            </a>
                            
                            <a href="{{ route('admin.reviews.index') }}"
                                class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg group transition-all duration-200 {{ request()->routeIs('admin.reviews.*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-100' }}">
                                <i class="fas fa-star w-5 mr-3 {{ request()->routeIs('admin.reviews.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}"></i>
                                <span>Reviews</span>
                            </a>
                            
                            <a href="{{ route('admin.products.index') }}"
                                class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg group transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-100' }}">
                                <i class="fas fa-box w-5 mr-3 {{ request()->routeIs('admin.products.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}"></i>
                                <span>Products</span>
                            </a>
                            
                            <a href="{{ route('admin.points.index') }}"
                                class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg group transition-all duration-200 {{ request()->routeIs('admin.points.*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-100' }}">
                                <i class="fas fa-coins w-5 mr-3 {{ request()->routeIs('admin.points.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}"></i>
                                <span>Client Points</span>
                            </a>
                            
                            <a href="{{ route('admin.certifications.index') }}"
                                class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg group transition-all duration-200 {{ request()->routeIs('admin.certifications.*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-100' }}">
                                <i class="fas fa-certificate w-5 mr-3 {{ request()->routeIs('admin.certifications.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}"></i>
                                <span>Certifications</span>
                            </a>

                            <a href="{{ route('admin.settings.index') }}"
                                class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg group transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'text-primary-700 bg-primary-50' : 'text-gray-700 hover:text-primary-700 hover:bg-gray-100' }}">
                                <i class="fas fa-cog w-5 mr-3 {{ request()->routeIs('admin.settings.*') ? 'text-primary-600' : 'text-gray-400 group-hover:text-primary-600' }}"></i>
                                <span>Settings</span>
                            </a>
                        </div>
                    </div>

                    <div class="mt-auto p-4 border-t border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center px-3 py-2.5 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 transition-all duration-200">
                                <i class="fas fa-sign-out-alt w-5 mr-3 text-red-500"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 overflow-x-hidden">
                <main class="p-4 sm:p-6 md:p-8">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSidebar = () => {
                document.querySelector('body').classList.toggle('sidebar-open');
            };

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const sidebar = document.querySelector('.sidebar');
                const sidebarButton = document.querySelector('[x-data]');

                if (window.innerWidth < 768 &&
                    document.body.classList.contains('sidebar-open') &&
                    !sidebar.contains(event.target) &&
                    !sidebarButton.contains(event.target)) {
                    document.body.classList.remove('sidebar-open');
                }
            });
        });
    </script>

    <style>
        /* Mobile sidebar open state */
        @media (max-width: 767px) {
            body.sidebar-open .sidebar {
                transform: translateX(0);
            }

            body.sidebar-open::after {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 10;
            }
        }
    </style>

    @yield('scripts')
</body>

</html>
