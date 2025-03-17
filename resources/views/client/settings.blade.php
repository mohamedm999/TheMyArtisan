<!-- filepath: c:\github\MyArtisan-platform\projet-myartisan\resources\views\client\settings.blade.php -->
@extends('layouts.client')

@section('title', 'Account Settings')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Account Settings</h1>

                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Settings navigation -->
                        <div class="w-full md:w-1/4">
                            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                                <div class="p-4 bg-gray-50 border-b border-gray-200">
                                    <h2 class="font-medium text-gray-800">Settings</h2>
                                </div>
                                <div class="divide-y divide-gray-200">
                                    <a href="#account" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 active bg-green-50 border-l-4 border-green-600">
                                        Account
                                    </a>
                                    <a href="#security" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                        Security
                                    </a>
                                    <a href="#notifications" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                        Notifications
                                    </a>
                                    <a href="#privacy" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                        Privacy
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Settings content -->
                        <div class="flex-1">
                            <!-- Account settings -->
                            <div id="account" class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden mb-6">
                                <div class="p-4 bg-gray-50 border-b border-gray-200">
                                    <h2 class="font-medium text-gray-800">Account Settings</h2>
                                </div>
                                <div class="p-6">
                                    <form>
                                        <div class="mb-6">
                                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                            <input type="text" id="username" name="username" value="{{ Auth::user()->username ?? Auth::user()->email }}"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                        </div>

                                        <div class="mb-6">
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                            <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                            <p class="mt-1 text-sm text-gray-500">Used for account notifications and password resets</p>
                                        </div>

                                        <div class="mb-6">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Account Type</label>
                                            <div class="bg-gray-50 px-4 py-3 rounded-md border border-gray-200 flex justify-between items-center">
                                                <div>
                                                    <span class="text-sm text-gray-700">Client Account</span>
                                                    <p class="text-xs text-gray-500">You can book services from artisans</p>
                                                </div>
                                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">Current</span>
                                            </div>
                                        </div>

                                        <div class="border-t border-gray-200 pt-4">
                                            <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Security settings -->
                            <div id="security" class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden mb-6">
                                <div class="p-4 bg-gray-50 border-b border-gray-200">
                                    <h2 class="font-medium text-gray-800">Security Settings</h2>
                                </div>
                                <div class="p-6">
                                    <form>
                                        <div class="mb-6">
                                            <h3 class="text-base font-medium text-gray-700 mb-2">Change Password</h3>
                                            <div class="grid grid-cols-1 gap-4">
                                                <div>
                                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                                    <input type="password" id="current_password" name="current_password"
                                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                                </div>
                                                <div>
                                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                                    <input type="password" id="new_password" name="new_password"
                                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                                </div>
                                                <div>
                                                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                                    <input type="password" id="confirm_password" name="confirm_password"
                                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border-t border-gray-200 pt-4">
                                            <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                                                Update Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Account deletion -->
                            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                                <div class="p-4 bg-gray-50 border-b border-gray-200">
                                    <h2 class="font-medium text-red-600">Delete Account</h2>
                                </div>
                                <div class="p-6">
                                    <p class="text-sm text-gray-600 mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                                    <button type="button" class="px-4 py-2 bg-red-50 text-red-600 text-sm border border-red-300 rounded-md hover:bg-red-100">
                                        Delete My Account
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
