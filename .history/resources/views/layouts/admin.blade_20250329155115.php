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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @yield('styles')
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-blue-800 text-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                            <span class="text-xl font-bold">MyArtisan Admin</span>
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
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                <a href="{{ route('admin.settings.index') }}"
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
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100' : 'hover:bg-gray-100' }}">
                                    <i
                                        class="fas fa-tachometer-alt w-6 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : '' }}"></i>
                                    <span
                                        class="{{ request()->routeIs('admin.dashboard') ? 'text-blue-600 font-medium' : '' }}">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.users.index') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-blue-100' : 'hover:bg-gray-100' }}">
                                    <i
                                        class="fas fa-users w-6 {{ request()->routeIs('admin.users.*') ? 'text-blue-600' : '' }}"></i>
                                    <span
                                        class="{{ request()->routeIs('admin.users.*') ? 'text-blue-600 font-medium' : '' }}">Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.artisans.index') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg {{ request()->routeIs('admin.artisans.*') ? 'bg-blue-100' : 'hover:bg-gray-100' }}">
                                    <i
                                        class="fas fa-hammer w-6 {{ request()->routeIs('admin.artisans.*') ? 'text-blue-600' : '' }}"></i>
                                    <span
                                        class="{{ request()->routeIs('admin.artisans.*') ? 'text-blue-600 font-medium' : '' }}">Artisans</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.categories.index') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-blue-100' : 'hover:bg-gray-100' }}">
                                    <i
                                        class="fas fa-tags w-6 {{ request()->routeIs('admin.categories.*') ? 'text-blue-600' : '' }}"></i>
                                    <span
                                        class="{{ request()->routeIs('admin.categories.*') ? 'text-blue-600 font-medium' : '' }}">Categories</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.services.index') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg {{ request()->routeIs('admin.services.*') ? 'bg-blue-100' : 'hover:bg-gray-100' }}">
                                    <i
                                        class="fas fa-briefcase w-6 {{ request()->routeIs('admin.services.*') ? 'text-blue-600' : '' }}"></i>
                                    <span
                                        class="{{ request()->routeIs('admin.services.*') ? 'text-blue-600 font-medium' : '' }}">Services</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.bookings.index') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-100' : 'hover:bg-gray-100' }}">
                                    <i
                                        class="fas fa-calendar w-6 {{ request()->routeIs('admin.bookings.*') ? 'text-blue-600' : '' }}"></i>
                                    <span
                                        class="{{ request()->routeIs('admin.bookings.*') ? 'text-blue-600 font-medium' : '' }}">Bookings</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.settings.index') }}"
                                    class="flex items-center p-2 text-gray-700 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-blue-100' : 'hover:bg-gray-100' }}">
                                    <i
                                        class="fas fa-cog w-6 {{ request()->routeIs('admin.settings.*') ? 'text-blue-600' : '' }}"></i>
                                    <span
                                        class="{{ request()->routeIs('admin.settings.*') ? 'text-blue-600 font-medium' : '' }}">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-auto p-4 border-t border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt w-6"></i>
                                <span>Logout</span>
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
