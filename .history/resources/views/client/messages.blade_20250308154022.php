<!-- filepath: c:\github\MyArtisan-platform\projet-myartisan\resources\views\client\messages.blade.php -->
@extends('layouts.client')

@section('title', 'Messages')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Messages</h1>

                    <div class="flex flex-col md:flex-row h-[600px] border border-gray-200 rounded-lg overflow-hidden">
                        <!-- Conversations list -->
                        <div class="w-full md:w-1/3 border-r border-gray-200 overflow-y-auto">
                            <div class="p-4 border-b border-gray-200">
                                <div class="relative">
                                    <input type="text" placeholder="Search conversations..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <div class="absolute left-3 top-2.5 text-gray-400">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Empty state -->
                            <div class="flex flex-col items-center justify-center h-64 p-4 text-center">
                                <div class="text-gray-400 mb-3">
                                    <i class="fas fa-comments fa-3x"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-600 mb-1">No messages yet</h3>
                                <p class="text-sm text-gray-500">Start a conversation with an artisan</p>
                            </div>

                            <!-- Example conversation items (hidden initially) -->
                            <div class="hidden">
                                <div class="px-4 py-3 border-b border-gray-200 hover:bg-gray-50 cursor-pointer">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold mr-3">
                                            JD
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-baseline">
                                                <h3 class="font-medium text-gray-800 truncate">John Doe</h3>
                                                <span class="text-xs text-gray-500">2h ago</span>
                                            </div>
                                            <p class="text-sm text-gray-500 truncate">I'll be available tomorrow at 2pm for the repair work.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Message area -->
                        <div class="flex-1 flex flex-col">
                            <!-- Empty state message -->
                            <div class="flex-1 flex flex-col items-center justify-center p-4 text-center">
                                <div class="text-gray-300 mb-4">
                                    <i class="fas fa-paper-plane fa-4x"></i>
                                </div>
                                <h3 class="text-xl font-medium text-gray-600 mb-2">Your messages</h3>
                                <p class="text-gray-500 max-w-sm mb-4">Select a conversation or start a new one with an artisan</p>
                                <a href="{{ route('client.find-artisans') }}" class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                                    Find Artisans
                                </a>
                            </div>

                            <!-- Active conversation (hidden initially) -->
                            <div class="flex-1 flex flex-col hidden">
                                <!-- Header -->
                                <div class="p-4 border-b border-gray-200 flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold mr-3">
                                        JD
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-800">John Doe</h3>
                                        <p class="text-xs text-gray-500">Plumber • Online</p>
                                    </div>
                                    <button class="ml-auto p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>

                                <!-- Messages -->
                                <div class="flex-1 p-4 overflow-y-auto">
                                    <!-- Messages would go here -->
                                </div>

                                <!-- Message input -->
                                <div class="p-4 border-t border-gray-200">
                                    <div class="flex items-center">
                                        <input type="text" placeholder="Type a message..."
                                            class="flex-1 border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        <button class="ml-2 p-2 bg-green-600 text-white rounded-full hover:bg-green-700">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
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
