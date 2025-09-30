<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(StoreMessageRequest $request)
    {
        $validated = $request->validated();

        $validated['sender_id'] = Auth::id();

        Message::create($validated);

        return redirect()->back();
    }
}
