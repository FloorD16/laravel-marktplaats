@extends('layouts.app')

@section('title', 'Advertenties')

@section('content')
    <div style="max-width: 800px; margin: 40px auto; font-family: Arial, sans-serif;">
        <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Advertenties</h2>

        @foreach($ads as $ad)
            <div style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 20px; background-color: #fefefe; box-shadow: 0 2px 6px rgba(0,0,0,0.05); position: relative;">
                <h3 style="margin: 0 0 10px; color: #007bff;">{{ $ad->title }}</h3>
                <p style="margin: 0 0 12px; color: #555;">{{ $ad->description }}</p>
                <p style="font-weight: bold; color: #28a745;">Prijs: €{{ number_format($ad->price, 2, ',', '.') }}</p>
            </div>
        @endforeach

        @if($ads->isEmpty())
            <p style="text-align: center; color: #999;">Er zijn geen advertenties geplaatst.</p>
        @endif
    </div>
@endsection