<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Models\ArtisanProfile;
use App\Models\ClientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the conversations.
     */
    public function index()
    {
        $user = Auth::user();
        $conversations = $user->getAllConversations()
            ->with(['client', 'artisan', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        $view = $user->role === 'client' ? 'client.messages' : 'artisan.messages';

        return view($view, compact('conversations'));
    }

    /**
     * Display a specific conversation.
     */
    public function show(Conversation $conversation)
    {
        $user = Auth::user();

        // Check if user is part of this conversation
        if ($conversation->client_id !== $user->id && $conversation->artisan_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        // Mark messages as read
        $conversation->messages()
            ->where('is_read', false)
            ->where('sender_id', '!=', $user->id)
            ->update(['is_read' => true]);

        $conversation->load(['messages.sender', 'client', 'artisan']);

        $conversations = $user->getAllConversations()
            ->with(['client', 'artisan', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        $view = $user->role === 'client' ? 'client.messages' : 'artisan.messages';

        return view($view, compact('conversation', 'conversations'));
    }

    /**
     * Start a new conversation with an artisan.
     */
    public function start(Request $request)
    {
        $request->validate([
            'artisan_id' => 'required|exists:users,id',
            'message' => 'required|string|max:500'
        ]);

        $client = Auth::user();

        // Check if client is trying to message themselves
        if ($client->id == $request->artisan_id) {
            return back()->with('error', 'You cannot send messages to yourself.');
        }

        $artisan = User::findOrFail($request->artisan_id);

        // Verify the recipient is an artisan
        if ($artisan->role !== 'artisan') {
            return back()->with('error', 'You can only send messages to artisans.');
        }

        // Check if conversation already exists
        $conversation = Conversation::where('client_id', $client->id)
            ->where('artisan_id', $artisan->id)
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'client_id' => $client->id,
                'artisan_id' => $artisan->id,
                'last_message_at' => now()
            ]);
        }

        // Create message
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $client->id,
            'content' => $request->message,
        ]);

        $conversation->update(['last_message_at' => now()]);

        return redirect()->route('messages.show', $conversation->id)
            ->with('success', 'Message sent successfully!');
    }

    /**
     * Send a message in an existing conversation.
     */
    public function sendMessage(Request $request, Conversation $conversation)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $user = Auth::user();

        // Check if user is part of this conversation
        if ($conversation->client_id !== $user->id && $conversation->artisan_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        // Create message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'content' => $request->message,
        ]);

        $conversation->update(['last_message_at' => now()]);

        return back();
    }
}
