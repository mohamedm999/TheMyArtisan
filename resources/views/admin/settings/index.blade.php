@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Site Settings</h2>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">General Settings</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Customize your platform settings</p>
                </div>

                <form action="{{ route('admin.settings.update') }}" method="POST" class="divide-y divide-gray-200">
                    @csrf
                    @method('PUT')

                    <!-- General Settings Section -->
                    <div class="px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="col-span-1">
                                <label for="site_name" class="block text-sm font-medium text-gray-700">Site Name</label>
                                <input type="text" name="site_name" id="site_name"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    value="{{ $settings['site_name'] ?? 'MyArtisan' }}">
                            </div>

                            <div class="col-span-1">
                                <label for="contact_email" class="block text-sm font-medium text-gray-700">Contact
                                    Email</label>
                                <input type="email" name="contact_email" id="contact_email"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    value="{{ $settings['contact_email'] ?? 'contact@myartisan.com' }}">
                            </div>

                            <div class="col-span-2">
                                <label for="site_description" class="block text-sm font-medium text-gray-700">Site
                                    Description</label>
                                <textarea name="site_description" id="site_description" rows="3"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ $settings['site_description'] ?? 'Your trusted platform for finding quality artisans and services.' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Business Settings Section -->
                    <div class="px-4 py-5 sm:p-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Business Settings</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="col-span-1">
                                <label for="commission_rate" class="block text-sm font-medium text-gray-700">Commission Rate
                                    (%)</label>
                                <input type="number" name="commission_rate" id="commission_rate" min="0"
                                    max="100" step="0.01"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    value="{{ $settings['commission_rate'] ?? '10' }}">
                            </div>

                            <div class="col-span-1">
                                <label for="tax_rate" class="block text-sm font-medium text-gray-700">Tax Rate (%)</label>
                                <input type="number" name="tax_rate" id="tax_rate" min="0" max="100"
                                    step="0.01"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    value="{{ $settings['tax_rate'] ?? '20' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Section -->
                    <div class="px-4 py-5 sm:p-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Social Media Links</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="col-span-1">
                                <label for="facebook_url" class="block text-sm font-medium text-gray-700">Facebook
                                    URL</label>
                                <input type="url" name="facebook_url" id="facebook_url"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    value="{{ $settings['facebook_url'] ?? '' }}">
                            </div>

                            <div class="col-span-1">
                                <label for="instagram_url" class="block text-sm font-medium text-gray-700">Instagram
                                    URL</label>
                                <input type="url" name="instagram_url" id="instagram_url"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    value="{{ $settings['instagram_url'] ?? '' }}">
                            </div>

                            <div class="col-span-1">
                                <label for="twitter_url" class="block text-sm font-medium text-gray-700">Twitter URL</label>
                                <input type="url" name="twitter_url" id="twitter_url"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    value="{{ $settings['twitter_url'] ?? '' }}">
                            </div>

                            <div class="col-span-1">
                                <label for="linkedin_url" class="block text-sm font-medium text-gray-700">LinkedIn
                                    URL</label>
                                <input type="url" name="linkedin_url" id="linkedin_url"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    value="{{ $settings['linkedin_url'] ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
