@extends('layouts.app')

@section('title', 'Advertenties')

@section('content')
    <div style="max-width: 800px; margin: 40px auto; font-family: Arial, sans-serif;">
        <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Advertenties</h2>

        <form method="GET" action="{{ route('home') }}" style="margin-bottom: 30px;">
            <label for="search" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Zoek advertenties:</label>
            <input type="text" id="search" name="search" value="{{ request('search') }}"
                placeholder="Zoek op titel of beschrijving"
                style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
        
            <label for="category" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Filter op categorie:</label>
            <select id="category" name="category"
                    style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
                <option value="">-- Alle categorieën --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    style="background-color: #007bff; color: white; border: none; padding: 8px 16px; border-radius: 4px; font-weight: bold; cursor: pointer;">
                Filteren
            </button>
        </form>


        @foreach($ads as $ad)
            <a href="{{ route('ad.show', $ad->id) }}" style="text-decoration: none;">
                <div style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 20px; background-color: #fefefe; box-shadow: 0 2px 6px rgba(0,0,0,0.05); position: relative;">
                    <h3 style="margin: 0 0 10px; color: #007bff;">{{ $ad->title }}</h3>
                    <p style="margin: 0 0 12px; color: #555;">{{ $ad->description }}</p>
                    <p style="font-weight: bold; color: #28a745;">Prijs: €{{ number_format($ad->price, 2, ',', '.') }}</p>
                </div>
            </a>
        @endforeach

        @if($ads->isEmpty())
            <p style="text-align: center; color: #999;">Er zijn geen advertenties geplaatst.</p>
        @endif
        
        {{ $ads->links('pagination::bootstrap-4') }}
    </div>

@endsection