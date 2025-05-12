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

                            @if(count($conversations ?? []) === 0)
                                <!-- Empty state -->
                                <div class="flex flex-col items-center justify-center h-64 p-4 text-center">
                                    <div class="text-gray-400 mb-3">
                                        <i class="fas fa-comments fa-3x"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-600 mb-1">No messages yet</h3>
                                    <p class="text-sm text-gray-500">Start a conversation with an artisan</p>
                                </div>
                            @else
                                <!-- Conversation list -->
                                @foreach($conversations as $conv)
                                    @php
                                        $otherUser = $conv->artisan;
                                        $latestMessage = $conv->latestMessage;
                                        $unreadCount = $conv->unreadMessages(auth()->id());
                                        $isActive = isset($conversation) && $conversation->id === $conv->id;
                                        $timeAgo = $latestMessage ? $latestMessage->created_at->diffForHumans() : '';
                                        $initials = strtoupper(substr($otherUser->firstname, 0, 1) . substr($otherUser->lastname, 0, 1));
                                    @endphp
                                    <a href="{{ route('messages.show', $conv->id) }}"
                                        class="block px-4 py-3 border-b border-gray-200 hover:bg-gray-50 {{ $isActive ? 'bg-green-50' : '' }}">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold mr-3 relative">
                                                {{ $initials }}
                                                @if($unreadCount > 0)
                                                    <span class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-red-500"></span>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex justify-between items-baseline">
                                                    <h3 class="font-medium text-gray-800 truncate">{{ $otherUser->firstname }} {{ $otherUser->lastname }}</h3>
                                                    <span class="text-xs text-gray-500">{{ $timeAgo }}</span>
                                                </div>
                                                @if($latestMessage)
                                                    <p class="text-sm {{ $unreadCount > 0 ? 'font-medium text-gray-800' : 'text-gray-500' }} truncate">
                                                        {{ $latestMessage->content }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>

                        <!-- Message area -->
                        <div class="flex-1 flex flex-col">
                            @if(!isset($conversation))
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
                            @else
                                <!-- Active conversation -->
                                <div class="flex-1 flex flex-col">
                                    <!-- Header -->
                                    @php
                                        $otherUser = $conversation->artisan;
                                        $initials = strtoupper(substr($otherUser->firstname, 0, 1) . substr($otherUser->lastname, 0, 1));
                                        $artisanProfile = $otherUser->artisanProfile;
                                        $serviceType = $artisanProfile->categories->first()->name ?? 'Artisan';
                                    @endphp
                                    <div class="p-4 border-b border-gray-200 flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold mr-3">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-gray-800">{{ $otherUser->firstname }} {{ $otherUser->lastname }}</h3>
                                            <p class="text-xs text-gray-500">{{ $serviceType }}</p>
                                        </div>
                                        <button class="ml-auto p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
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
                                                <div class="flex justify-center my-4">
                                                    <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded">
                                                        {{ $message->created_at->format('F j, Y') }}
                                                    </span>
                                                </div>
                                            @endif

                                            @if($isMine)
                                                <!-- My message -->
                                                <div class="flex items-end justify-end mb-4">
                                                    <span class="text-xs text-gray-500 mr-2">{{ $message->created_at->format('g:i A') }}</span>
                                                    <div class="bg-green-100 rounded-lg py-2 px-4 max-w-[80%]">
                                                        <p class="text-sm">{{ $message->content }}</p>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Their message -->
                                                <div class="flex items-end mb-4">
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

                                    <!-- Message input -->
                                    <div class="p-4 border-t border-gray-200">
                                        <form action="{{ route('messages.send', $conversation->id) }}" method="POST" class="flex items-center">
                                            @csrf
                                            <input type="text" name="message" placeholder="Type a message..." required
                                                class="flex-1 border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-green-500">
                                            <button type="submit" class="ml-2 p-2 bg-green-600 text-white rounded-full hover:bg-green-700">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </form>
                                    </div>
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
