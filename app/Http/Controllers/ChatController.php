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
                     ->with(['buyer', 'seller', 'ad' => function ($query) {
                         $query->select('id', 'user_id', 'name', 'description', 'price', 'stock', 'category_id', 'image_path', 'is_active'); // Explicitly select columns, including user_id
                     }])
                     ->get();

        // Buscar a mensagem de sistema global
        $systemMessage = Message::where('system_message', true)
                                ->where('created_at', '1970-01-01 00:00:00')
                                ->first();

        return Inertia::render('Chat/Index', [
            'chats' => $chats,
            'systemMessage' => $systemMessage // Passar a mensagem de sistema para o frontend
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:users,id',
            'ad_id' => 'required|exists:ads,id'
        ]);

        $user = Auth::user();
        
        // Verificar se não é o próprio anunciante tentando criar chat consigo mesmo
        if ($user->id == $request->seller_id) {
            return response()->json(['message' => 'Você não pode iniciar uma conversa com seu próprio anúncio.'], 422);
        }

        // Verificar se já existe um chat entre esses usuários para este anúncio
        $existingChat = Chat::where('id_comprador', $user->id)
                           ->where('id_vendedor', $request->seller_id)
                           ->where('ad_id', $request->ad_id)
                           ->first();

        if ($existingChat) {
            // Anexar o ID do chat na rota para o frontend saber qual chat abrir
            return redirect()->route('chat.index', ['chat_id' => $existingChat->id])->with('success', 'Conversa já existe!');
        }

        // Criar novo chat
        $chat = Chat::create([
            'id_comprador' => $user->id,
            'id_vendedor' => $request->seller_id,
            'ad_id' => $request->ad_id,
            'finalizado' => false
        ]);

        // Anexar o ID do chat na rota para o frontend saber qual chat abrir
        return redirect()->route('chat.index', ['chat_id' => $chat->id])->with('success', 'Conversa iniciada com sucesso!');
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'content' => 'required|string',
        ]);

        $chat = Chat::find($request->chat_id);

        if (!$chat) {
            return response()->json(['message' => 'Chat not found.'], 404);
        }

        if ($chat->finalizado) {
            return response()->json(['message' => 'Chat is finalized. Cannot send messages.'], 403);
        }

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

    // Novo método para buscar a mensagem de sistema (opcional, mas útil para consistência)
    public function getGlobalSystemMessage()
    {
        $systemMessage = Message::where('system_message', true)
                                ->where('created_at', '1970-01-01 00:00:00')
                                ->first();

        return response()->json($systemMessage);
    }

    public function finalizeNegotiation(Chat $chat)
    {
        $user = Auth::user();

        // Verify if the authenticated user is either the buyer or the seller of the chat
        if ($chat->id_comprador !== $user->id && $chat->id_vendedor !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $chat->finalizado = true;
        $chat->save();

        Message::create([
            'chat_id' => $chat->id,
            'user_id' => null, // System message, no specific user
            'content' => $user->nomeCompleto . ' finalizou a negociação.',
            'system_message' => true,
        ]);

        return response()->json(['message' => 'Negotiation finalized successfully.', 'chat' => $chat]);
    }

    public function reactivateNegotiation(Chat $chat)
    {
        $user = Auth::user();

        // Verify if the authenticated user is either the buyer or the seller of the chat
        if ($chat->id_comprador !== $user->id && $chat->id_vendedor !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $chat->finalizado = false;
        $chat->save();

        Message::create([
            'chat_id' => $chat->id,
            'user_id' => null, // System message, no specific user
            'content' => $user->nomeCompleto . ' reativou a negociação.',
            'system_message' => true,
        ]);

        return response()->json(['message' => 'Negotiation reactivated successfully.', 'chat' => $chat]);
    }
}