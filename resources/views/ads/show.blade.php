@extends('layouts.app')

@section('title', 'Advertentie')

@section('content')
    <div style="max-width: 800px; margin: 40px auto; font-family: Arial, sans-serif;">
        <h2 style="text-align: center; margin-bottom: 30px; color: #007bff;">{{ $ad->title }}</h2>

        <div style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; background-color: #fefefe; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
            <p style="margin-bottom: 12px; color: #555; font-size: 16px; line-height: 1.5;">
                {{ $ad->description }}
            </p>
            <p style="font-weight: bold; color: #28a745; font-size: 18px;">
                Prijs: €{{ number_format($ad->price, 2, ',', '.') }}
            </p>
        </div>

        <h3 style="margin-top: 40px; color: #333;">Biedingen</h3>
        @forelse($ad->bids as $bid)
            <div style="border-bottom: 1px solid #eee; padding: 10px 0;">
                <strong>{{ $bid->user->name }}</strong> bood <span style="color: #007bff;">€{{ number_format($bid->bid, 2, ',', '.') }}</span>
                <br>
                <small style="color: #999;">Geplaatst op {{ $bid->created_at->format('d-m-Y H:i') }}</small>
            </div>
        @empty
            <p style="color: #999;">Er zijn nog geen biedingen geplaatst.</p>
        @endforelse

        @auth
        <form method="POST" action="{{ route('bid.store') }}" style="margin-top: 30px;">
            @csrf
            <input type="hidden" name="ad_id" value="{{ $ad->id }}">

            <label for="bid" style="display: block; margin-bottom: 8px; font-weight: bold;">Jouw bod (€):</label>
            <input type="number" name="bid" id="bid" step="0.01" min="0" required
                style="padding: 8px; width: 200px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 12px;">

            <button type="submit"
                    style="background-color: #007bff; color: white; border: none; padding: 8px 16px; border-radius: 4px; font-weight: bold; cursor: pointer;">
                Plaats bod
            </button>
        </form>
        @endauth

    </div>
@endsection