@extends('layouts.artisan')

@section('title', 'Settings')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-amber-800 mb-6">Settings</h1>

                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-6">
                            <a href="#"
                                class="border-amber-500 text-amber-600 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                Account
                            </a>
                            <a href="#"
                                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                Notifications
                            </a>
                            <a href="#"
                                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                Payment Methods
                            </a>
                            <a href="#"
                                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                Privacy
                            </a>
                        </nav>
                    </div>

                    <!-- Account Settings Form -->
                    <div class="max-w-3xl">
                        <form action="#" method="POST">
                            @csrf

                            <!-- Personal Information -->
                            <div class="mb-8">
                                <h2 class="text-lg font-medium text-gray-800 mb-4">Personal Information</h2>
                                <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                                    <div class="p-6">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label for="firstname"
                                                    class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                                <input type="text" name="firstname" id="firstname"
                                                    value="{{ Auth::user()->firstname }}"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                            </div>
                                            <div>
                                                <label for="lastname"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                                <input type="text" name="lastname" id="lastname"
                                                    value="{{ Auth::user()->lastname }}"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                            </div>
                                            <div>
                                                <label for="email"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Email
                                                    Address</label>
                                                <input type="email" name="email" id="email"
                                                    value="{{ Auth::user()->email }}"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                            </div>
                                            <div>
                                                <label for="phone"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Phone
                                                    Number</label>
                                                <input type="tel" name="phone" id="phone"
                                                    value="+33 1 23 45 67 89"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                            </div>
                                        </div>
                                        <div class="mt-6">
                                            <label for="address"
                                                class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                            <input type="text" name="address" id="address"
                                                value="123 Artisan Street, Paris"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                                            <div>
                                                <label for="city"
                                                    class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                                <input type="text" name="city" id="city" value="Paris"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                            </div>
                                            <div>
                                                <label for="state"
                                                    class="block text-sm font-medium text-gray-700 mb-1">State/Region</label>
                                                <input type="text" name="state" id="state" value="Île-de-France"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                            </div>
                                            <div>
                                                <label for="postal_code"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                                <input type="text" name="postal_code" id="postal_code" value="75001"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                            </div>
                                        </div>
                                        <div class="mt-6">
                                            <label for="country"
                                                class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                            <select name="country" id="country"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                                <option value="FR" selected>France</option>
                                                <option value="BE">Belgium</option>
                                                <option value="CH">Switzerland</option>
                                                <option value="DE">Germany</option>
                                                <option value="ES">Spain</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Change -->
                            <div class="mb-8">
                                <h2 class="text-lg font-medium text-gray-800 mb-4">Change Password</h2>
                                <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                                    <div class="p-6">
                                        <div class="mb-4">
                                            <label for="current_password"
                                                class="block text-sm font-medium text-gray-700 mb-1">Current
                                                Password</label>
                                            <input type="password" name="current_password" id="current_password"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label for="password"
                                                    class="block text-sm font-medium text-gray-700 mb-1">New
                                                    Password</label>
                                                <input type="password" name="password" id="password"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                            </div>
                                            <div>
                                                <label for="password_confirmation"
                                                    class="block text-sm font-medium text-gray-700 mb-1">Confirm New
                                                    Password</label>
                                                <input type="password" name="password_confirmation"
                                                    id="password_confirmation"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Area -->
                            <div class="mb-8">
                                <h2 class="text-lg font-medium text-gray-800 mb-4">Service Area</h2>
                                <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                                    <div class="p-6">
                                        <div class="mb-4">
                                            <label for="service_radius"
                                                class="block text-sm font-medium text-gray-700 mb-1">Service Radius
                                                (km)</label>
                                            <input type="number" name="service_radius" id="service_radius"
                                                value="25"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                            <p class="mt-1 text-sm text-gray-500">Set the maximum distance you're willing
                                                to travel for jobs.</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Service
                                                Cities</label>
                                            <div class="flex flex-wrap gap-2 p-2 border border-gray-300 rounded-md">
                                                <span
                                                    class="bg-amber-100 text-amber-800 px-2 py-1 rounded text-sm flex items-center">
                                                    Paris <button class="ml-1 text-amber-600 hover:text-amber-800"><i
                                                            class="fas fa-times"></i></button>
                                                </span>
                                                <span
                                                    class="bg-amber-100 text-amber-800 px-2 py-1 rounded text-sm flex items-center">
                                                    Versailles <button class="ml-1 text-amber-600 hover:text-amber-800"><i
                                                            class="fas fa-times"></i></button>
                                                </span>
                                                <span
                                                    class="bg-amber-100 text-amber-800 px-2 py-1 rounded text-sm flex items-center">
                                                    Saint-Denis <button class="ml-1 text-amber-600 hover:text-amber-800"><i
                                                            class="fas fa-times"></i></button>
                                                </span>
                                                <input type="text" placeholder="Add a city..."
                                                    class="border-0 focus:ring-0 text-sm flex-grow min-w-[150px]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Deactivate Account -->
                            <div class="mb-8">
                                <h2 class="text-lg font-medium text-gray-800 mb-4">Deactivate Account</h2>
                                <div class="bg-white rounded-lg shadow border border-red-200 overflow-hidden">
                                    <div class="p-6">
                                        <p class="text-gray-700 mb-4">Deactivating your account will make your profile and
                                            services invisible to clients. You can reactivate your account at any time by
                                            logging back in.</p>
                                        <button type="button"
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                                            Deactivate Account
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Buttons -->
                            <div class="flex justify-end">
                                <button type="button"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none mr-3">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
