@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div style="max-width: 800px; margin: 40px auto; font-family: Arial, sans-serif;">
        <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Mijn Advertenties</h2>

        @foreach($ads as $ad)
            <div style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 20px; background-color: #fefefe; box-shadow: 0 2px 6px rgba(0,0,0,0.05); position: relative;">
                <h3 style="margin: 0 0 10px; color: #007bff;">{{ $ad->title }}</h3>
                <p style="margin: 0 0 12px; color: #555;">{{ $ad->description }}</p>
                <p style="font-weight: bold; color: #28a745;">Prijs: €{{ number_format($ad->price, 2, ',', '.') }}</p>

                <div style="position: absolute; bottom: 20px; right: 20px; display: flex; gap: 10px;">
                    <a href="{{ route('ad.edit', $ad->id) }}" 
                    style="background-color: #ffc107; color: #333; text-decoration: none; padding: 8px 12px; border-radius: 4px; font-weight: bold; font-size: 14px;">
                        Bewerken
                    </a>

                    <form action="{{ route('ad.destroy', $ad->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Weet je zeker dat je deze advertentie wilt verwijderen?');"
                                style="background-color: #dc3545; color: white; border: none; padding: 8px 12px; border-radius: 4px; font-weight: bold; font-size: 14px; cursor: pointer;">
                            Verwijderen
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        @if($ads->isEmpty())
            <p style="text-align: center; color: #999;">Je hebt nog geen advertenties geplaatst.</p>
        @endif

        {{ $ads->links('pagination::bootstrap-4') }}

    </div>
@endsection