<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ably\AblyRest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ChatController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $usersWithChats = User::with(['chats' => function($query) {
                $query->orderBy('sent_at', 'asc');
            }])
            ->whereHas('chats', function ($query) {
                $query->whereNotNull('message');
            })
            ->where('id', '!=', Auth::id()) 
            ->get();

        $initialMessages = new Collection(); // Or use collect() helper: collect([])
        $initialChatUser = null;

        if ($usersWithChats->isNotEmpty()) {
           $initialChatUser = $usersWithChats->first();
            $initialMessages = $initialChatUser->chats;
        }

        $messages = Chat::where('user_id', $user->id)->latest()->take(50)->get()->reverse();

        // dd($initialChatUser->id);

        return view('landingpage.chat', [
            'messages' => $messages,
            'usersWithChats' => $usersWithChats,
            'initialMessages' => $initialMessages,
            'initialChatUser' => $initialChatUser,
            'currentAuthId' => Auth::id() 
        ]);
    }


    public function sendMessage(Request $request)
{
    $messageData = [
        'user_id' => $request->input('user'),
        'message' => $request->input('message'),
        'channel' => 'chat',
        'sent_at' => now(),
    ];

    // Upload file jika ada
    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('chat_files', 'public');
        $messageData['file_url'] = asset('storage/' . $path);
    }

    // Simpan ke DB
    $message = Chat::create($messageData);

    // Kirim via Ably
    $ably = new \Ably\AblyRest(['key' => env('ABLY_KEY')]);

    $ably->channels->get('chat')->publish('message', [
        'id' => $message->id,
        'user' => $message->user_id,
        'channel' => $message->channel,
        'message' => $message->message,
        'file_url' => $message->file_url,
        'timestamp' => $message->sent_at->toISOString(),
    ]);

    return response()->json(['status' => 'Message sent']);
}

public function sendMessageAdmin(Request $request)
{
    $messageData = [
        'user_id' => $request->input('user'),
        'message' => $request->input('message'),
        'channel' => 'reply',
        'sent_at' => now(),
    ];

    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('chat_files', 'public');
        $messageData['file_url'] = asset('storage/' . $path);
    }

    $message = Chat::create($messageData);

    $ably = new \Ably\AblyRest(['key' => env('ABLY_KEY')]);

    $ably->channels->get('chat')->publish('message', [
        'id' => $message->id,
        'user' => $message->user_id,
        'channel' => $message->channel,
        'message' => $message->message,
        'file_url' => $message->file_url,
        'timestamp' => $message->sent_at->toISOString(),
    ]);

    return response()->json(['status' => 'Message sent']);
}


}
