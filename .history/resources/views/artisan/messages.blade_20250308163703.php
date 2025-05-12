@extends('layouts.artisan')

@section('title', 'Messages')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-amber-800 mb-6">Messages</h1>

                    <div class="flex flex-col lg:flex-row h-[600px]">
                        <!-- Conversation List -->
                        <div class="w-full lg:w-1/3 border-r border-gray-200 overflow-y-auto h-full">
                            <div class="p-4 border-b border-gray-200">
                                <div class="relative">
                                    <input type="text" placeholder="Search messages"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50 pl-10">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="divide-y divide-gray-200">
                                <!-- Active conversation -->
                                <div class="p-4 flex items-start bg-amber-50 border-l-4 border-amber-500">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-700 font-medium">JD</span>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <div class="flex justify-between items-baseline">
                                            <h3 class="text-sm font-medium">Jean Dupont</h3>
                                            <span class="text-xs text-gray-500">10:23 AM</span>
                                        </div>
                                        <p class="text-sm text-gray-600 truncate">When do you think the dining table will be
                                            ready?</p>
                                    </div>
                                </div>

                                <!-- Unread conversation -->
                                <div class="p-4 flex items-start hover:bg-gray-50 cursor-pointer">
                                    <div class="flex-shrink-0 relative">
                                        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-700 font-medium">ML</span>
                                        </div>
                                        <span class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-red-500"></span>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <div class="flex justify-between items-baseline">
                                            <h3 class="text-sm font-medium">Marie Lambert</h3>
                                            <span class="text-xs text-gray-500">Yesterday</span>
                                        </div>
                                        <p class="text-sm font-medium text-gray-800 truncate">Thank you for the quick
                                            response!</p>
                                    </div>
                                </div>

                                <!-- Read conversation -->
                                <div class="p-4 flex items-start hover:bg-gray-50 cursor-pointer">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-700 font-medium">PB</span>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <div class="flex justify-between items-baseline">
                                            <h3 class="text-sm font-medium">Pierre Blanc</h3>
                                            <span class="text-xs text-gray-500">Nov 10</span>
                                        </div>
                                        <p class="text-sm text-gray-600 truncate">Do you offer custom shelving for small
                                            spaces?</p>
                                    </div>
                                </div>

                                <div class="p-4 flex items-start hover:bg-gray-50 cursor-pointer">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-700 font-medium">SR</span>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <div class="flex justify-between items-baseline">
                                            <h3 class="text-sm font-medium">Sophie Renard</h3>
                                            <span class="text-xs text-gray-500">Nov 5</span>
                                        </div>
                                        <p class="text-sm text-gray-600 truncate">The cabinet looks beautiful, thank you so
                                            much!</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Conversation Area -->
                        <div class="w-full lg:w-2/3 flex flex-col h-full">
                            <!-- Conversation Header -->
                            <div class="p-4 border-b border-gray-200 flex items-center">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-700 font-medium">JD</span>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium">Jean Dupont</h3>
                                        <p class="text-xs text-gray-500">Last active: Today at 10:30 AM</p>
                                    </div>
                                </div>
                                <div class="ml-auto">
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <i class="fas fa-phone"></i>
                                    </button>
                                    <button class="text-gray-500 hover:text-gray-700 ml-4">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Messages -->
                            <div class="flex-1 p-4 overflow-y-auto">
                                <div class="space-y-4">
                                    <!-- Date Separator -->
                                    <div class="flex justify-center">
                                        <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded">November 15,
                                            2023</span>
                                    </div>

                                    <!-- Received Message -->
                                    <div class="flex items-end">
                                        <div class="flex-shrink-0 mr-2">
                                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-700 font-medium text-xs">JD</span>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded-lg py-2 px-4 max-w-[80%]">
                                            <p class="text-sm">Hello, I wanted to inquire about the custom dining table I
                                                ordered last week.</p>
                                        </div>
                                        <span class="text-xs text-gray-500 ml-2">9:42 AM</span>
                                    </div>

                                    <!-- Sent Message -->
                                    <div class="flex items-end justify-end">
                                        <span class="text-xs text-gray-500 mr-2">9:45 AM</span>
                                        <div class="bg-amber-100 rounded-lg py-2 px-4 max-w-[80%]">
                                            <p class="text-sm">Hi Jean, thanks for reaching out! Your table is coming along
                                                nicely. I've started working on the legs and will begin the tabletop
                                                tomorrow.</p>
                                        </div>
                                    </div>

                                    <!-- Received Message -->
                                    <div class="flex items-end">
                                        <div class="flex-shrink-0 mr-2">
                                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-700 font-medium text-xs">JD</span>
                                            </div>
                                        </div>
                                        <div class="bg-gray-100 rounded-lg py-2 px-4 max-w-[80%]">
                                            <p class="text-sm">That's great to hear! When do you think the dining table will
                                                be ready?</p>
                                        </div>
                                        <span class="text-xs text-gray-500 ml-2">10:23 AM</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Message Input -->
                            <div class="p-4 border-t border-gray-200">
                                <div class="flex items-end">
                                    <div class="flex-1 mr-4">
                                        <textarea placeholder="Type a message..."
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50 resize-none"
                                            rows="2"></textarea>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="p-2 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200">
                                            <i class="fas fa-paperclip"></i>
                                        </button>
                                        <button class="p-2 rounded-full bg-amber-600 text-white hover:bg-amber-700">
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
