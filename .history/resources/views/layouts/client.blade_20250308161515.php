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
        <nav class="bg-green-700 text-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('client.dashboard') }}" class="flex items-center">
                            <span class="text-xl font-bold">MyArtisan Client</span>
                        </a>
                    </div>

                    <div class="flex items-center">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-white focus:outline-none">
                                <span class="mr-2">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <a href="{{ route('client.profile') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My
                                    Profile</a>
                                <a href="{{ route('client.settings') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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
            <div class="hidden md:block w-64 bg-white shadow-md">
                <div class="flex flex-col h-full">
                    <div class="p-4">
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('client.dashboard') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('client.dashboard') ? 'bg-gray-100 font-medium' : '' }}">
                                    <i class="fas fa-tachometer-alt w-6"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.profile') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('client.profile') ? 'bg-gray-100 font-medium' : '' }}">
                                    <i class="fas fa-user w-6"></i>
                                    <span>My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.find-artisans') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('client.find-artisans') ? 'bg-gray-100 font-medium' : '' }}">
                                    <i class="fas fa-search w-6"></i>
                                    <span>Find Artisans</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.bookings') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('client.bookings') ? 'bg-gray-100 font-medium' : '' }}">
                                    <i class="fas fa-calendar w-6"></i>
                                    <span>My Bookings</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.saved-artisans') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('client.saved-artisans') ? 'bg-gray-100 font-medium' : '' }}">
                                    <i class="fas fa-heart w-6"></i>
                                    <span>Saved Artisans</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.messages') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('client.messages') ? 'bg-gray-100 font-medium' : '' }}">
                                    <i class="fas fa-comments w-6"></i>
                                    <span>Messages</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.settings') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('client.settings') ? 'bg-gray-100 font-medium' : '' }}">
                                    <i class="fas fa-cog w-6"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                        </ul>
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
