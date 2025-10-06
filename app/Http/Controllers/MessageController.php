<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index($conversationId = null)
    {
        $messages = Message::with('sender')
            ->where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->oldest()
            ->get();

        $conversations = collect($messages)->groupBy(function ($message) {
            $ids = [$message->sender_id, $message->receiver_id];
            sort($ids);
            return implode('-', $ids);
        });

        $partners = $conversations->mapWithKeys(function ($messages, $key) {
            $first = $messages->first();
            $otherUser = $first->sender_id === Auth::id() ? $first->receiver : $first->sender;
            return [$key => $otherUser];
        });

        $selectedMessages = $conversations->get($conversationId, collect());

        return view('messages.index', compact('partners', 'selectedMessages', 'conversationId'));
    }

    public function store(StoreMessageRequest $request)
    {
        $validated = $request->validated();

        $validated['sender_id'] = Auth::id();

        Message::create($validated);

        $receiver = User::find($validated['receiver_id']);
        if ($receiver->email_notifications) {
            $receiver->notify(new NewMessageNotification(auth()->user()));
        }

        return redirect()->back();
    }
}
