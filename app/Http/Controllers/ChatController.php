<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\Message;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $chats = Chat::where('id_comprador', $user->id)
                     ->orWhere('id_vendedor', $user->id)
                     ->with(['buyer', 'seller'])
                     ->get();

        return Inertia::render('Chat/Index', [
            'chats' => $chats
        ]);
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'chat_id' => $request->chat_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return response()->json($message, 201);
    }

    public function getMessages(Chat $chat)
    {
        $messages = $chat->messages()->with('user')->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }
}