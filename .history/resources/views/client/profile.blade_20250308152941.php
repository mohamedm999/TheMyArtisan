@extends('layouts.client')

@section('title', 'My Profile')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">My Profile</h1>
                        <button type="button"
                            class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Save Changes
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Profile Photo Section -->
                        <div class="md:col-span-1">
                            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-32 h-32 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-4xl font-bold mb-4">
                                        {{ strtoupper(substr(Auth::user()->firstname, 0, 1) . substr(Auth::user()->lastname, 0, 1)) }}
                                    </div>
                                    <button type="button"
                                        class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                        Upload Photo
                                    </button>
                                    <p class="text-xs text-gray-500 mt-2">Recommended: Square JPG or PNG, at least 300x300
                                        pixels</p>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Information Section -->
                        <div class="md:col-span-2">
                            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                                <h2 class="text-lg font-medium text-gray-800 mb-4">Personal Information</h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                    <div>
                                        <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">First
                                            Name</label>
                                        <input type="text" id="firstname" name="firstname"
                                            value="{{ Auth::user()->firstname }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">Last
                                            Name</label>
                                        <input type="text" id="lastname" name="lastname"
                                            value="{{ Auth::user()->lastname }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                        Address</label>
                                    <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                </div>

                                <div class="mb-6">
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
                                        Number</label>
                                    <input type="tel" id="phone" name="phone" value=""
                                        placeholder="Enter your phone number"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                </div>

                                <h2 class="text-lg font-medium text-gray-800 mb-4 border-t border-gray-200 pt-6">Location
                                </h2>

                                <div class="mb-6">
                                    <label for="address"
                                        class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <input type="text" id="address" name="address" placeholder="Enter your address"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="city"
                                            class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                        <input type="text" id="city" name="city" placeholder="City"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="state"
                                            class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                        <input type="text" id="state" name="state" placeholder="State/Province"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">Zip
                                            Code</label>
                                        <input type="text" id="zip" name="zip" placeholder="Zip Code"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
