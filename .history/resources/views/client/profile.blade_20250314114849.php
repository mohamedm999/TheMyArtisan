@extends('layouts.client')

@section('title', 'My Profile')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
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
                                <form action="{{ route('client.profile.photo') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center">
                                    @csrf
                                    <div class="w-32 h-32 rounded-full mb-4 overflow-hidden">
                                        @if(Auth::user()->avatar)
                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->firstname }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-green-100 flex items-center justify-center text-green-600 text-4xl font-bold">
                                                {{ strtoupper(substr(Auth::user()->firstname, 0, 1) . substr(Auth::user()->lastname, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <label for="photo" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 cursor-pointer">
                                        Choose File
                                    </label>
                                    <input id="photo" name="photo" type="file" class="hidden" onchange="this.form.submit()">
                                    <p class="text-xs text-gray-500 mt-2">Recommended: Square JPG or PNG, at least 300x300 pixels</p>
                                </form>
                            </div>
                        </div>

                        <!-- Profile Information Section -->
                        <div class="md:col-span-2">
                            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                                <form action="{{ route('client.profile.update') }}" method="POST">
                                    @csrf
                                    <h2 class="text-lg font-medium text-gray-800 mb-4">Personal Information</h2>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                        <div>
                                            <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                            <input type="text" id="firstname" name="firstname" value="{{ old('firstname', Auth::user()->firstname) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                        </div>
                                        <div>
                                            <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                            <input type="text" id="lastname" name="lastname" value="{{ old('lastname', Auth::user()->lastname) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                        <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    </div>

                                    <div class="mb-6">
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" value="{{ old('phone', Auth::user()->clientProfile->phone ?? '') }}" placeholder="Enter your phone number" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    </div>

                                    <h2 class="text-lg font-medium text-gray-800 mb-4 border-t border-gray-200 pt-6">Location</h2>

                                    <div class="mb-6">
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                        <input type="text" id="address" name="address" value="{{ old('address', Auth::user()->clientProfile->address ?? '') }}" placeholder="Enter your address" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                            <input type="text" id="city" name="city" value="{{ old('city', Auth::user()->clientProfile->city ?? '') }}" placeholder="City" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                        </div>
                                        <div>
                                            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                            <input type="text" id="state" name="state" value="{{ old('state', Auth::user()->clientProfile->state ?? '') }}" placeholder="State/Province" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                        </div>
                                        <div>
                                            <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">Zip Code</label>
                                            <input type="text" id="zip" name="zip" value="{{ old('zip', Auth::user()->clientProfile->zip ?? '') }}" placeholder="Zip Code" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                        </div>
                                    </div>

                                    <div class="flex justify-end mt-6">
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                            Save Changes
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
