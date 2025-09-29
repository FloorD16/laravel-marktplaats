<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBidRequest;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function store(StoreBidRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        Bid::create($validated);

        return redirect()->back();
    }
}
