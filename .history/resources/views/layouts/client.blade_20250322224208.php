<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'MyArtisan Client Dashboard')">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Client Dashboard') - MyArtisan</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @yield('styles')
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-green-700 to-green-800 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('client.dashboard') }}" class="flex items-center space-x-2">
                            <i class="fas fa-home text-green-300 text-xl"></i>
                            <span
                                class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-green-200">MyArtisan
                                Client</span>
                        </a>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ notificationsOpen: false }">
                            <button @click="notificationsOpen = !notificationsOpen"
                                class="p-1 rounded-full text-white hover:bg-green-600 focus:outline-none">
                                <span class="sr-only">View notifications</span>
                                <i class="fas fa-bell"></i>
                                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                            </button>
                            <div x-show="notificationsOpen" @click.away="notificationsOpen = false"
                                class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 p-1 divide-y divide-gray-200 z-50">
                                <div class="px-4 py-2 text-sm text-gray-700 font-medium">Notifications</div>
                                <div class="py-2">
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                        <p class="font-medium">Service completed</p>
                                        <p class="text-xs text-gray-500">2 hours ago</p>
                                    </a>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                        <p class="font-medium">New message from artisan</p>
                                        <p class="text-xs text-gray-500">Yesterday</p>
                                    </a>
                                </div>
                                <div class="py-1">
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-green-600 hover:bg-gray-100 rounded-md text-center">
                                        View all notifications
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- User dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center space-x-3 text-white focus:outline-none hover:bg-green-600 p-2 rounded-lg transition-colors duration-200">
                                {{-- <div
                                    class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center border-2 border-white"> --}}
                                    <span
                                        class="text-xs font-bold">{{ substr(Auth::user()->firstname, 0, 1) }}{{ substr(Auth::user()->lastname, 0, 1) }}</span>
                                </div>
                                <div class="hidden md:flex md:flex-col md:items-start">
                                    <span class="font-semibold">{{ Auth::user()->firstname }}
                                        {{ Auth::user()->lastname }}</span>
                                    <span class="text-xs text-green-200">Client</span>
                                </div>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 divide-y divide-gray-100">
                                <div class="py-1">
                                    <a href="{{ route('client.profile') }}"
                                        class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50">
                                        <i class="fas fa-user mr-3 text-green-600"></i> My Profile
                                    </a>
                                    <a href="{{ route('client.settings') }}"
                                        class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50">
                                        <i class="fas fa-cog mr-3 text-green-600"></i> Settings
                                    </a>
                                </div>
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="group flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50">
                                            <i class="fas fa-sign-out-alt mr-3 text-green-600"></i> Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex flex-grow">
            <!-- Sidebar -->
            <div class="hidden md:block w-64 bg-white shadow-md">
                <div class="flex flex-col h-full">
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-user text-green-600 text-xl"></i>
                            </div>
                        </div>
                        <h5 class="text-center font-medium">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                        </h5>
                        <p class="text-center text-sm text-gray-500">Client</p>
                    </div>
                    <div class="p-4">
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('client.dashboard') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-green-50 transition-colors duration-200 {{ request()->routeIs('client.dashboard') ? 'bg-green-50 text-green-700 font-medium' : '' }}">
                                    <i
                                        class="fas fa-tachometer-alt w-6 {{ request()->routeIs('client.dashboard') ? 'text-green-600' : 'text-gray-500' }}"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.profile') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-green-50 transition-colors duration-200 {{ request()->routeIs('client.profile') ? 'bg-green-50 text-green-700 font-medium' : '' }}">
                                    <i
                                        class="fas fa-user w-6 {{ request()->routeIs('client.profile') ? 'text-green-600' : 'text-gray-500' }}"></i>
                                    <span>My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.artisans.index') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-green-50 transition-colors duration-200 {{ request()->routeIs('client.find-artisans') ? 'bg-green-50 text-green-700 font-medium' : '' }}">
                                    <i
                                        class="fas fa-search w-6 {{ request()->routeIs('client.find-artisans') ? 'text-green-600' : 'text-gray-500' }}"></i>
                                    <span>Find Artisans</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.bookings') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-green-50 transition-colors duration-200 {{ request()->routeIs('client.bookings') ? 'bg-green-50 text-green-700 font-medium' : '' }}">
                                    <i
                                        class="fas fa-calendar w-6 {{ request()->routeIs('client.bookings') ? 'text-green-600' : 'text-gray-500' }}"></i>
                                    <span>My Bookings</span>
                                    <span
                                        class="ml-auto bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded">3</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.saved-artisans') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-green-50 transition-colors duration-200 {{ request()->routeIs('client.saved-artisans') ? 'bg-green-50 text-green-700 font-medium' : '' }}">
                                    <i
                                        class="fas fa-heart w-6 {{ request()->routeIs('client.saved-artisans') ? 'text-green-600' : 'text-gray-500' }}"></i>
                                    <span>Saved Artisans</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.messages') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-green-50 transition-colors duration-200 {{ request()->routeIs('client.messages') ? 'bg-green-50 text-green-700 font-medium' : '' }}">
                                    <i
                                        class="fas fa-comments w-6 {{ request()->routeIs('client.messages') ? 'text-green-600' : 'text-gray-500' }}"></i>
                                    <span>Messages</span>
                                    <span
                                        class="ml-auto bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded">2</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.settings') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-green-50 transition-colors duration-200 {{ request()->routeIs('client.settings') ? 'bg-green-50 text-green-700 font-medium' : '' }}">
                                    <i
                                        class="fas fa-cog w-6 {{ request()->routeIs('client.settings') ? 'text-green-600' : 'text-gray-500' }}"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-auto p-4 border-t border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center p-2 text-gray-700 rounded-lg hover:bg-red-50 transition-colors duration-200">
                                <i class="fas fa-sign-out-alt w-6 text-gray-500"></i>
                                <span>Sign out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-grow">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    @yield('scripts')
</body>

</html>
