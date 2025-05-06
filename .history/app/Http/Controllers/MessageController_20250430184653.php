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
    public function %3CmxGraphModel%3E%3Croot%3E%3CmxCell%20id%3D%220%22%2F%3E%3CmxCell%20id%3D%221%22%20parent%3D%220%22%2F%3E%3CmxCell%20id%3D%222%22%20value%3D%22Role%26amp%3Bnbsp%3B%22%20style%3D%22swimlane%3BfontStyle%3D1%3Balign%3Dcenter%3BverticalAlign%3Dtop%3BchildLayout%3DstackLayout%3Bhorizontal%3D1%3BstartSize%3D26%3BhorizontalStack%3D0%3BresizeParent%3D1%3BresizeParentMax%3D0%3BresizeLast%3D0%3Bcollapsible%3D1%3BmarginBottom%3D0%3BwhiteSpace%3Dwrap%3Bhtml%3D1%3BstrokeWidth%3D3%3B%22%20vertex%3D%221%22%20parent%3D%221%22%3E%3CmxGeometry%20x%3D%22-920%22%20y%3D%22-2040%22%20width%3D%22160%22%20height%3D%22120%22%20as%3D%22geometry%22%3E%3CmxRectangle%20x%3D%22-920%22%20y%3D%22-2040%22%20width%3D%22100%22%20height%3D%2230%22%20as%3D%22alternateBounds%22%2F%3E%3C%2FmxGeometry%3E%3C%2FmxCell%3E%3CmxCell%20id%3D%223%22%20value%3D%22%2Bid%26amp%3Bnbsp%3B%26lt%3Bdiv%26gt%3B%2Bname%26amp%3Bnbsp%3B%26lt%3Bspan%20style%3D%26quot%3Bbackground-color%3A%20transparent%3B%20color%3A%20light-dark(rgb(0%2C%200%2C%200)%2C%20rgb(255%2C%20255%2C%20255))%3B%26quot%3B%26gt%3B%26amp%3Bnbsp%3B%26lt%3B%2Fspan%26gt%3B%26lt%3B%2Fdiv%26gt%3B%22%20style%3D%22text%3BstrokeColor%3Dnone%3BfillColor%3Dnone%3Balign%3Dleft%3BverticalAlign%3Dtop%3BspacingLeft%3D4%3BspacingRight%3D4%3Boverflow%3Dhidden%3Brotatable%3D0%3Bpoints%3D%5B%5B0%2C0.5%5D%2C%5B1%2C0.5%5D%5D%3BportConstraint%3Deastwest%3BwhiteSpace%3Dwrap%3Bhtml%3D1%3B%22%20vertex%3D%221%22%20parent%3D%222%22%3E%3CmxGeometry%20y%3D%2226%22%20width%3D%22160%22%20height%3D%2244%22%20as%3D%22geometry%22%2F%3E%3C%2FmxCell%3E%3CmxCell%20id%3D%224%22%20value%3D%22%22%20style%3D%22line%3BstrokeWidth%3D1%3BfillColor%3Dnone%3Balign%3Dleft%3BverticalAlign%3Dmiddle%3BspacingTop%3D-1%3BspacingLeft%3D3%3BspacingRight%3D3%3Brotatable%3D0%3BlabelPosition%3Dright%3Bpoints%3D%5B%5D%3BportConstraint%3Deastwest%3BstrokeColor%3Dinherit%3B%22%20vertex%3D%221%22%20parent%3D%222%22%3E%3CmxGeometry%20y%3D%2270%22%20width%3D%22160%22%20height%3D%228%22%20as%3D%22geometry%22%2F%3E%3C%2FmxCell%3E%3CmxCell%20id%3D%225%22%20value%3D%22%2BassignRole()%26lt%3Bdiv%26gt%3B%2BremoveRole()%26lt%3B%2Fdiv%26gt%3B%22%20style%3D%22text%3BstrokeColor%3Dnone%3BfillColor%3Dnone%3Balign%3Dleft%3BverticalAlign%3Dtop%3BspacingLeft%3D4%3BspacingRight%3D4%3Boverflow%3Dhidden%3Brotatable%3D0%3Bpoints%3D%5B%5B0%2C0.5%5D%2C%5B1%2C0.5%5D%5D%3BportConstraint%3Deastwest%3BwhiteSpace%3Dwrap%3Bhtml%3D1%3B%22%20vertex%3D%221%22%20parent%3D%222%22%3E%3CmxGeometry%20y%3D%2278%22%20width%3D%22160%22%20height%3D%2242%22%20as%3D%22geometry%22%2F%3E%3C%2FmxCell%3E%3C%2Froot%3E%3C%2FmxGraphModel%3E
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
