<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ably\AblyRest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        $messages = Chat::where('user_id', $user->id)->latest()->take(50)->get()->reverse();

        // dd($messages);

        return view('landingpage.chat', compact('user', 'messages'));
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
        'message' => $message->message,
        'file_url' => $message->file_url,
        'timestamp' => $message->sent_at->toISOString(),
    ]);

    return response()->json(['status' => 'Message sent']);
}


}
