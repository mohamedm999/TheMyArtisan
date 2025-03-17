@extends('layouts.client')

@section('title', 'My Profile')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">My Profile</h1>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Profile Photo Section -->
                        <div class="md:col-span-1">
                            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                                <form action="{{ route('client.profile.update-photo') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-32 h-32 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-4xl font-bold mb-4 overflow-hidden">
                                            @if (isset($clientProfile) && $clientProfile->profile_photo)
                                                <img src="{{ asset('storage/' . $clientProfile->profile_photo) }}"
                                                    alt="Profile Photo" class="w-full h-full object-cover">
                                            @else
                                                {{ strtoupper(substr(Auth::user()->firstname, 0, 1) . substr(Auth::user()->lastname, 0, 1)) }}
                                            @endif
                                        </div>
                                        <input type="file" name="profile_photo" id="profile_photo" class="hidden"
                                            onchange="this.form.submit()">
                                        <label for="profile_photo"
                                            class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 cursor-pointer">
                                            Upload Photo
                                        </label>
                                        <p class="text-xs text-gray-500 mt-2">Recommended: Square JPG or PNG, at least
                                            300x300 pixels</p>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Profile Information Section -->
                        <div class="md:col-span-2">
                            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                                <form action="{{ route('client.profile.update-personal-info') }}" method="POST">
                                    @csrf
                                    <h2 class="text-lg font-medium text-gray-800 mb-4">Personal Information</h2>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                        <div>
                                            <label for="firstname"
                                                class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
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
                                        <input type="email" id="email" name="email"
                                            value="{{ Auth::user()->email }}"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    </div>

                                    <div class="mb-6">
                                        <label for="bio"
                                            class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                                        <textarea id="bio" name="bio" rows="4"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">{{ isset($clientProfile) ? $clientProfile->bio : '' }}</textarea>
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="submit"
                                            class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                            Save Personal Info
                                        </button>
                                    </div>
                                </form>

                                <hr class="my-6 border-t border-gray-200">

                                <form action="{{ route('client.profile.update') }}" method="POST">
                                    @csrf
                                    <h2 class="text-lg font-medium text-gray-800 mb-4">Contact Information</h2>

                                    <div class="mb-6">
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
                                            Number</label>
                                        <input type="tel" id="phone" name="phone"
                                            value="{{ isset($clientProfile) ? $clientProfile->phone : '' }}"
                                            placeholder="Enter your phone number"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    </div>

                                    <h2 class="text-lg font-medium text-gray-800 mb-4">Location</h2>

                                    <div class="mb-6">
                                        <label for="address"
                                            class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                        <input type="text" id="address" name="address"
                                            value="{{ isset($clientProfile) ? $clientProfile->address : '' }}"
                                            placeholder="Enter your address"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label for="city"
                                                class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                            <input type="text" id="city" name="city"
                                                value="{{ isset($clientProfile) ? $clientProfile->city : '' }}"
                                                placeholder="City"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                        </div>
                                        <div>
                                            <label for="state"
                                                class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                            <input type="text" id="state" name="state"
                                                value="{{ isset($clientProfile) ? $clientProfile->state : '' }}"
                                                placeholder="State/Province"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                        </div>
                                        <div>
                                            <label for="postal_code"
                                                class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                            <input type="text" id="postal_code" name="postal_code"
                                                value="{{ isset($clientProfile) ? $clientProfile->postal_code : '' }}"
                                                placeholder="Postal Code"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                        </div>
                                    </div>

                                    <div class="flex justify-end mt-6">
                                        <button type="submit"
                                            class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
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
