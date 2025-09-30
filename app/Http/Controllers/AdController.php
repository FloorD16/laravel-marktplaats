<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdRequest;
use App\Models\Ad;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Ad::query();

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $ads = $query->paginate(5)->appends($request->query());
        $categories = Category::all();

        return view('ads.index', compact('ads', 'categories'));
    }
    
    public function create()
    {
        $categories = Category::all();

        return view('ads.create', compact('categories'));
    }

    public function store(StoreAdRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        $ad = Ad::create($validated);

        if ($request->filled('category')) {
            $ad->categories()->sync($validated['categories']);
        }

        return redirect()->route('dashboard');
    }

    public function edit(Ad $ad)
    {
        $this->authorize('update', $ad);

        $categories = Category::all();

        return view('ads.edit', compact('ad', 'categories'));
    }

    public function update(StoreAdRequest $request, Ad $ad)
    {
        $this->authorize('update', $ad);
        
        $validated = $request->validated();

        $validated['price'] = str_replace(',', '.', $validated['price']);
        
        $ad->update($validated);

        if ($request->filled('category')) {
            $ad->categories()->sync($validated['categories']);
        }

        return redirect()->route('dashboard');
    }

    public function destroy(Ad $ad)
    {
        $this->authorize('delete', $ad);
        
        $ad->delete();
        
        return redirect()->route('dashboard');
    }

    public function show(Ad $ad)
    {
        $ad->load([
            'bids' => function ($query) {
                $query->latest();
            },
            'bids.user',
            'messages' => function ($query) use ($ad) {
                $query->where(function ($q) use ($ad) {
                    $q->where('sender_id', Auth::id())
                    ->where('receiver_id', $ad->user_id);
                })->orWhere(function ($q) use ($ad) {
                    $q->where('sender_id', $ad->user_id)
                    ->where('receiver_id', Auth::id());
                });
            }
        ]);
        
        return view('ads.show', compact('ad'));
    }
}
