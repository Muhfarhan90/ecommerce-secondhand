<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Listing;
use App\Models\Message;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * Display all conversations for authenticated user
     */
    public function index()
    {
        $conversations = Conversation::with(['listing', 'buyer', 'seller', 'messages' => function ($query) {
            $query->latest()->limit(1);
        }])
            ->where(function ($query) {
                $query->where('buyer_id', auth()->id())
                    ->orWhere('seller_id', auth()->id());
            })
            ->latest('updated_at')
            ->get();

        return view('conversations.index', compact('conversations'));
    }

    /**
     * Display a specific conversation
     */
    public function show(Conversation $conversation)
    {
        // Check authorization
        abort_if(
            $conversation->buyer_id !== auth()->id() &&
                $conversation->seller_id !== auth()->id(),
            403
        );

        // Load relationships
        $conversation->load(['listing.images', 'buyer', 'seller', 'messages.sender']);

        // Mark messages as read
        Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('conversations.show', compact('conversation'));
    }

    /**
     * Start a new conversation or redirect to existing one
     */
    public function start(Listing $listing)
    {
        // Prevent seller from contacting themselves
        if ($listing->user_id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghubungi diri sendiri!');
        }

        // Check if conversation already exists
        $conversation = Conversation::where('listing_id', $listing->id)
            ->where('buyer_id', auth()->id())
            ->where('seller_id', $listing->user_id)
            ->first();

        // Create new conversation if doesn't exist
        if (!$conversation) {
            $conversation = Conversation::create([
                'listing_id' => $listing->id,
                'buyer_id' => auth()->id(),
                'seller_id' => $listing->user_id,
            ]);
        }

        return redirect()->route('conversations.show', $conversation);
    }

    /**
     * Send a message in a conversation
     */
    public function sendMessage(Request $request, Conversation $conversation)
    {
        // Check authorization
        abort_if(
            $conversation->buyer_id !== auth()->id() &&
                $conversation->seller_id !== auth()->id(),
            403
        );

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Update conversation timestamp
        $conversation->touch();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back();
    }
}
