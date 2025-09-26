@extends('layouts.app')

@section('title', 'Nieuwe advertentie')

@section('content')
    @if ($errors->any())
        <div style="background-color: #f8d7da; border: 1px solid #f5c2c7; color: #842029; padding: 16px; border-radius: 6px; margin-bottom: 20px; font-family: Arial, sans-serif;">
            <strong style="font-weight: bold;">Oeps! Er ging iets mis:</strong>
            <ul style="margin-top: 10px; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li style="margin-bottom: 6px;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
   
    <form action="{{ route('ad.store') }}" method="POST" style="max-width: 420px; margin: 30px auto; padding: 24px; border: 1px solid #ddd; border-radius: 10px; background-color: #ffffff; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    @csrf

    <label for="title" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Titel:</label>
    <input id="title" name="title" type="text" value="{{ old('title') }}" required
           style="width: 100%; padding: 10px; margin-bottom: 16px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">

    <label for="description" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Beschrijving:</label>
    <input id="description" name="description" type="text" value="{{ old('description') }}" required
           style="width: 100%; padding: 10px; margin-bottom: 16px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">

    <label for="price" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Prijs:</label>
    <input id="price" name="price" type="text" required
           style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">

    <button type="submit"
            style="width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 6px; font-weight: bold; font-size: 15px; cursor: pointer; transition: background-color 0.3s;">
        Plaatsen
    </button>
    </form>

@endsection