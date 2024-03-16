<?php

namespace App\Http\Controllers\Doctor;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    function index()
    {
        $userId = auth()->user()->id;

        $senders = Chat::select('sender_id')
            ->where('receiver_id', $userId)
            ->where('sender_id', '!=', $userId)
            ->selectRaw('MAX(created_at) as latest_message_sent')
            ->groupBy('sender_id')
            ->orderByDesc('latest_message_sent')
            ->get();

        return view('doctor.chat.index', compact('senders'));
    }

    function getConversation(string $senderId)
    {
        $receiverId = auth()->user()->id;

        Chat::where('sender_id', $senderId)->where('receiver_id', $receiverId)->where('seen', 0)->update(['seen' => 1]);

        $messages = Chat::whereIn('sender_id', [$senderId, $receiverId])
            ->whereIn('receiver_id', [$senderId, $receiverId])
            ->with(['sender'])
            ->orderBy('created_at', 'asc')
            ->get();
        return response($messages);
    }

    function sendMessage(Request $request)
    {
        $request->validate([
            'message' => ['required', 'max:1000'],
            'receiver_id' => ['required', 'integer']
        ]);

        $chat = new Chat();
        $chat->sender_id = auth()->user()->id;
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message;
        $chat->save();

        $image = asset(auth()->user()->image);
        $senderId = auth()->user()->id;
        broadcast(new ChatEvent($request->message, $image, $request->receiver_id, $senderId))->toOthers();

        return response(['status' => 'success', 'msgId' => $request->msg_temp_id]);
    }
}
