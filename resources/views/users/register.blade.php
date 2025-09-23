@extends('layouts.app')

@section('title', 'Registreren')

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
   
    <form action="{{ route('register.store') }}" method="POST" style="max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9; font-family: Arial, sans-serif;">
    @csrf

    <label for="name" style="display: block; margin-bottom: 6px; font-weight: bold;">Naam:</label>
    <input id="name" name="name" type="text" value="{{ old('name') }}" required
           style="width: 100%; padding: 8px; margin-bottom: 12px; border: 1px solid #ccc; border-radius: 4px;">

    <label for="email" style="display: block; margin-bottom: 6px; font-weight: bold;">Email:</label>
    <input id="email" name="email" type="email" value="{{ old('email') }}" required
           style="width: 100%; padding: 8px; margin-bottom: 12px; border: 1px solid #ccc; border-radius: 4px;">

    <label for="password" style="display: block; margin-bottom: 6px; font-weight: bold;">Wachtwoord:</label>
    <input id="password" name="password" type="password" required
           style="width: 100%; padding: 8px; margin-bottom: 12px; border: 1px solid #ccc; border-radius: 4px;">

    <label for="password_confirmation" style="display: block; margin-bottom: 6px; font-weight: bold;">Wachtwoord bevestiging:</label>
    <input id="password_confirmation" name="password_confirmation" type="password" required
           style="width: 100%; padding: 8px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">

    <button type="submit"
            style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
        Registreren
    </button>
</form>
@endsection