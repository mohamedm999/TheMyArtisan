<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'MyArtisan Artisan Dashboard')">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Artisan Dashboard') - MyArtisan</title>

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
        <nav class="bg-amber-700 text-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('artisan.dashboard') }}" class="flex items-center">
                            <span class="text-xl font-bold">MyArtisan Workspace</span>
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
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My
                                    Profile</a>
                                <a href="#"
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
  

            <!-- Sidebar Navigation -->
            <div class="min-h-screen bg-amber-800">
                <div class="py-4 text-center">
                    <a href="{{ route('artisan.dashboard') }}" class="text-white text-xl font-bold">MyArtisan</a>
                </div>

                <nav class="mt-5 px-2">
                    <a href="{{ route('artisan.dashboard') }}"
                        class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('artisan.dashboard') ? 'bg-amber-900 text-white' : 'text-amber-100 hover:bg-amber-700' }}">
                        <i class="fas fa-tachometer-alt mr-3 text-amber-300"></i>
                        Dashboard
                    </a>

                    <a href="{{ route('artisan.profile') }}"
                        class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('artisan.profile') ? 'bg-amber-900 text-white' : 'text-amber-100 hover:bg-amber-700' }}">
                        <i class="fas fa-user mr-3 text-amber-300"></i>
                        Profile
                    </a>

                    <a href="{{ route('artisan.services') }}"
                        class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('artisan.services') ? 'bg-amber-900 text-white' : 'text-amber-100 hover:bg-amber-700' }}">
                        <i class="fas fa-tools mr-3 text-amber-300"></i>
                        Services
                    </a>

                    <a href="{{ route('artisan.bookings') }}"
                        class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('artisan.bookings') ? 'bg-amber-900 text-white' : 'text-amber-100 hover:bg-amber-700' }}">
                        <i class="fas fa-calendar-check mr-3 text-amber-300"></i>
                        Bookings
                    </a>

                    <a href="{{ route('artisan.schedule') }}"
                        class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('artisan.schedule') ? 'bg-amber-900 text-white' : 'text-amber-100 hover:bg-amber-700' }}">
                        <i class="fas fa-calendar-alt mr-3 text-amber-300"></i>
                        Schedule
                    </a>

                    <a href="{{ route('artisan.reviews') }}"
                        class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('artisan.reviews') ? 'bg-amber-900 text-white' : 'text-amber-100 hover:bg-amber-700' }}">
                        <i class="fas fa-star mr-3 text-amber-300"></i>
                        Reviews
                    </a>

                    <a href="{{ route('artisan.messages') }}"
                        class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('artisan.messages') ? 'bg-amber-900 text-white' : 'text-amber-100 hover:bg-amber-700' }}">
                        <i class="fas fa-envelope mr-3 text-amber-300"></i>
                        Messages
                        <span class="ml-auto bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">2</span>
                    </a>

                    <a href="{{ route('artisan.settings') }}"
                        class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('artisan.settings') ? 'bg-amber-900 text-white' : 'text-amber-100 hover:bg-amber-700' }}">
                        <i class="fas fa-cog mr-3 text-amber-300"></i>
                        Settings
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="mt-10">
                        @csrf
                        <button type="submit"
                            class="w-full group flex items-center px-2 py-2 text-base font-medium rounded-md text-amber-100 hover:bg-amber-700">
                            <i class="fas fa-sign-out-alt mr-3 text-amber-300"></i>
                            Logout
                        </button>
                    </form>
                </nav>
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
