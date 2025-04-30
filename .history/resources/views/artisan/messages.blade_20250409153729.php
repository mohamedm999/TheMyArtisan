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
                                @if(count($conversations ?? []) === 0)
                                    <!-- Empty state -->
                                    <div class="flex flex-col items-center justify-center h-64 p-4 text-center">
                                        <div class="text-amber-300 mb-3">
                                            <i class="fas fa-comments fa-3x"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-amber-800 mb-1">No messages yet</h3>
                                        <p class="text-sm text-gray-500">Clients will contact you here when interested in your services</p>
                                    </div>
                                @else
                                    <!-- Conversations list -->
                                    @foreach($conversations as $conv)
                                        @php
                                            $otherUser = $conv->client;
                                            $latestMessage = $conv->latestMessage;
                                            $unreadCount = $conv->unreadMessages(auth()->id());
                                            $isActive = isset($conversation) && $conversation->id === $conv->id;
                                            $timeAgo = $latestMessage ? $latestMessage->created_at->diffForHumans() : '';
                                            $initials = strtoupper(substr($otherUser->firstname, 0, 1) . substr($otherUser->lastname, 0, 1));
                                        @endphp
                                        <a href="{{ route('messages.show', $conv->id) }}" class="block">
                                            <div class="p-4 flex items-start {{ $isActive ? 'bg-amber-50 border-l-4 border-amber-500' : 'hover:bg-gray-50 cursor-pointer' }}">
                                                <div class="flex-shrink-0 relative">
                                                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <span class="text-gray-700 font-medium">{{ $initials }}</span>
                                                    </div>
                                                    @if($unreadCount > 0)
                                                        <span class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-red-500"></span>
                                                    @endif
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <div class="flex justify-between items-baseline">
                                                        <h3 class="text-sm font-medium">{{ $otherUser->firstname }} {{ $otherUser->lastname }}</h3>
                                                        <span class="text-xs text-gray-500">{{ $timeAgo }}</span>
                                                    </div>
                                                    @if($latestMessage)
                                                        <p class="text-sm {{ $unreadCount > 0 ? 'font-medium' : 'text-gray-600' }} truncate">
                                                            {{ $latestMessage->content }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Conversation Area -->
                        <div class="w-full lg:w-2/3 flex flex-col h-full">
                            @if(!isset($conversation))
                                <!-- Empty state message -->
                                <div class="flex-1 flex flex-col items-center justify-center p-4 text-center">
                                    <div class="text-amber-300 mb-4">
                                        <i class="fas fa-inbox fa-4x"></i>
                                    </div>
                                    <h3 class="text-xl font-medium text-amber-800 mb-2">Your client messages</h3>
                                    <p class="text-gray-500 max-w-sm mb-4">Select a conversation to view messages from your clients</p>
                                </div>
                            @else
                                <!-- Conversation Header -->
                                @php
                                    $otherUser = $conversation->client;
                                    $initials = strtoupper(substr($otherUser->firstname, 0, 1) . substr($otherUser->lastname, 0, 1));
                                @endphp
                                <div class="p-4 border-b border-gray-200 flex items-center">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-700 font-medium">{{ $initials }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium">{{ $otherUser->firstname }} {{ $otherUser->lastname }}</h3>
                                            <p class="text-xs text-gray-500">Last active: {{ $otherUser->updated_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="text-gray-500 hover:text-gray-700">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Messages -->
                                <div class="flex-1 p-4 overflow-y-auto" id="messages-container">
                                    @php
                                        $currentDate = null;
                                    @endphp
                                    @foreach($conversation->messages as $message)
                                        @php
                                            $messageDate = $message->created_at->format('Y-m-d');
                                            $showDate = $currentDate !== $messageDate;
                                            if ($showDate) {
                                                $currentDate = $messageDate;
                                            }
                                            $isMine = $message->sender_id === auth()->id();
                                            $senderInitials = strtoupper(substr($message->sender->firstname, 0, 1) . substr($message->sender->lastname, 0, 1));
                                        @endphp

                                        @if($showDate)
                                            <div class="flex justify-center">
                                                <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded">{{ $message->created_at->format('F j, Y') }}</span>
                                            </div>
                                        @endif

                                        @if($isMine)
                                            <!-- Sent Message -->
                                            <div class="flex items-end justify-end my-4">
                                                <span class="text-xs text-gray-500 mr-2">{{ $message->created_at->format('g:i A') }}</span>
                                                <div class="bg-amber-100 rounded-lg py-2 px-4 max-w-[80%]">
                                                    <p class="text-sm">{{ $message->content }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Received Message -->
                                            <div class="flex items-end my-4">
                                                <div class="flex-shrink-0 mr-2">
                                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <span class="text-gray-700 font-medium text-xs">{{ $senderInitials }}</span>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-100 rounded-lg py-2 px-4 max-w-[80%]">
                                                    <p class="text-sm">{{ $message->content }}</p>
                                                </div>
                                                <span class="text-xs text-gray-500 ml-2">{{ $message->created_at->format('g:i A') }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <!-- Message Input -->
                                <div class="p-4 border-t border-gray-200">
                                    <form action="{{ route('messages.send', $conversation->id) }}" method="POST" class="flex items-end">
                                        @csrf
                                        <div class="flex-1 mr-4">
                                            <textarea name="message" placeholder="Type a message..." required
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50 resize-none"
                                                rows="2"></textarea>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="button" class="p-2 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200">
                                                <i class="fas fa-paperclip"></i>
                                            </button>
                                            <button type="submit" class="p-2 rounded-full bg-amber-600 text-white hover:bg-amber-700">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($conversation))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('messages-container');
                container.scrollTop = container.scrollHeight;
            });
        </script>
    @endif
@endsection
