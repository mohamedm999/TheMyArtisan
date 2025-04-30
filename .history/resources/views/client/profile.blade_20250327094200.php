@extends('layouts.client')

@section('title', 'My Profile')

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm mb-6" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl">
                <div class="p-6 sm:p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-800">My Profile</h1>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Profile Photo Section -->
                        <div class="md:col-span-1">
                            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 transition hover:shadow-md">
                                <form action="{{ route('client.profile.update-photo') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="flex flex-col items-center">
                                        <div class="w-40 h-40 rounded-full bg-gradient-to-r from-green-50 to-green-100 flex items-center justify-center text-green-600 text-4xl font-bold mb-6 overflow-hidden shadow-md border-4 border-white">
                                            @if (isset($clientProfile) && $clientProfile->profile_photo)
                                                <img src="{{ asset('storage/' . $clientProfile->profile_photo) }}" alt="Profile Photo" class="w-full h-full object-cover">
                                            @else
                                                {{ strtoupper(substr(Auth::user()->firstname, 0, 1) . substr(Auth::user()->lastname, 0, 1)) }}
                                            @endif
                                        </div>
                                        <input type="file" name="profile_photo" id="profile_photo" class="hidden" onchange="this.form.submit()">
                                        <label for="profile_photo" class="px-4 py-2.5 bg-white text-green-600 text-sm font-medium rounded-lg border border-green-200 hover:bg-green-50 hover:border-green-300 focus:outline-none focus:ring-2 focus:ring-green-200 transition-all duration-200 shadow-sm cursor-pointer flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Upload Photo
                                        </label>
                                        <p class="text-xs text-gray-500 mt-3 text-center">Recommended: Square JPG or PNG, at least 300x300 pixels</p>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Profile Information Section -->
                        <div class="md:col-span-2">
                            <div class="bg-white p-6 sm:p-8 rounded-xl shadow-sm border border-gray-100 transition hover:shadow-md">
                                <form action="{{ route('client.profile.update-personal-info') }}" method="POST">
                                    @csrf
                                    <h2 class="text-lg font-semibold text-gray-800 mb-5 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Personal Information
                                    </h2>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                                        <div>
                                            <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                            <input type="text" id="firstname" name="firstname" value="{{ Auth::user()->firstname }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-colors">
                                        </div>
                                        <div>
                                            <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                            <input type="text" id="lastname" name="lastname" value="{{ Auth::user()->lastname }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-colors">
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-colors">
                                    </div>

                                    <div class="mb-6">
                                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                                        <textarea id="bio" name="bio" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-colors">{{ isset($clientProfile) ? $clientProfile->bio : '' }}</textarea>
                                        <p class="mt-1 text-xs text-gray-500">Write a short introduction about yourself</p>
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="submit" class="px-5 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200 shadow-sm flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Save Personal Info
                                        </button>
                                    </div>
                                </form>

                                <hr class="my-8 border-t border-gray-200">

                                <form action="{{ route('client.profile.update') }}" method="POST">
                                    @csrf
                                    <h2 class="text-lg font-semibold text-gray-800 mb-5 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        Contact Information
                                    </h2>

                                    <div class="mb-6">
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" value="{{ isset($clientProfile) ? $clientProfile->phone : '' }}" placeholder="Enter your phone number" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-colors">
                                    </div>

                                    <h2 class="text-lg font-semibold text-gray-800 mb-5 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Location
                                    </h2>

                                    <div class="mb-6">
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                        <input type="text" id="address" name="address" value="{{ isset($clientProfile) ? $clientProfile->address : '' }}" placeholder="Enter your address" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-colors">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                        <div>
                                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                            <input type="text" id="city" name="city" value="{{ isset($clientProfile) ? $clientProfile->city : '' }}" placeholder="City" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-colors">
                                        </div>
                                        <div>
                                            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                            <input type="text" id="state" name="state" value="{{ isset($clientProfile) ? $clientProfile->state : '' }}" placeholder="State/Province" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-colors">
                                        </div>
                                        <div>
                                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                            <input type="text" id="postal_code" name="postal_code" value="{{ isset($clientProfile) ? $clientProfile->postal_code : '' }}" placeholder="Postal Code" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-colors">
                                        </div>
                                    </div>

                                    <div class="flex justify-end mt-8">
                                        <button type="submit" class="px-5 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200 shadow-sm flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Save Contact Info
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
