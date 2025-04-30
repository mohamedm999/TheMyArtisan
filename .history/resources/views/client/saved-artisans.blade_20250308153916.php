<!-- filepath: c:\github\MyArtisan-platform\projet-myartisan\resources\views\client\saved-artisans.blade.php -->
@extends('layouts.client')

@section('title', 'Saved Artisans')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">My Saved Artisans</h1>

                    <!-- Empty state -->
                    <div class="text-center py-8" id="empty-state">
                        <div class="text-gray-400 mb-4">
                            <i class="fas fa-heart fa-3x"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-600 mb-2">No saved artisans yet</h3>
                        <p class="text-gray-500 mb-4">When you find artisans you like, save them here for quick access</p>
                        <a href="{{ route('client.find-artisans') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                            <i class="fas fa-search mr-2"></i> Find Artisans
                        </a>
                    </div>

                    <!-- Artisans list - hidden initially, would be shown when there are saved artisans -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 hidden" id="artisans-list">
                        <!-- Example of a saved artisan card -->
                        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
                            <div class="p-5">
                                <div class="flex items-center mb-4">
                                    <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xl font-bold mr-3">
                                        JD
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-800">John Doe</h3>
                                        <p class="text-sm text-gray-500">Plumber</p>
                                    </div>
                                    <button class="ml-auto text-red-500 hover:text-red-700">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                                <div class="mb-4">
                                    <div class="flex items-center text-sm mb-1">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                        <span>Paris, France</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <i class="fas fa-star text-yellow-400 mr-2"></i>
                                        <span>4.8 (24 reviews)</span>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="#" class="flex-1 px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 text-center">
                                        View Profile
                                    </a>
                                    <a href="#" class="flex-1 px-4 py-2 border border-green-600 text-green-600 text-sm rounded-md hover:bg-green-50 text-center">
                                        Contact
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
