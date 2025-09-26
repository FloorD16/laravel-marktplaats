<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdRequest;
use App\Models\Ad;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $ads = Ad::All();

        return view('ads.index', compact('ads'));
    }
    
    public function create()
    {
        return view('ads.create');
    }

    public function store(StoreAdRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        Ad::create($validated);

        return redirect()->route('dashboard');
    }

    public function edit(Ad $ad)
    {
        $this->authorize('update', $ad);

        return view('ads.edit', compact('ad'));
    }

    public function update(StoreAdRequest $request, Ad $ad)
    {
        $this->authorize('update', $ad);
        
        $validated = $request->validated();

        $validated['price'] = str_replace(',', '.', $validated['price']);
        
        $ad->update($validated);

        return redirect()->route('dashboard');
    }

    public function destroy(Ad $ad)
    {
        $this->authorize('delete', $ad);
        
        $ad->delete();
        
        return redirect()->route('dashboard');
    }
}
