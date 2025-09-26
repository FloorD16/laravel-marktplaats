@extends('layouts.app')

@section('title', 'Inloggen')

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
   
    <form action="{{ route('login.auth') }}" method="POST" style="max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9; font-family: Arial, sans-serif;">
        @csrf

        <label for="email" style="display: block; margin-bottom: 6px; font-weight: bold;">Email:</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required
            style="width: 100%; padding: 8px; margin-bottom: 12px; border: 1px solid #ccc; border-radius: 4px;">

        <label for="password" style="display: block; margin-bottom: 6px; font-weight: bold;">Wachtwoord:</label>
        <input id="password" name="password" type="password" required
            style="width: 100%; padding: 8px; margin-bottom: 12px; border: 1px solid #ccc; border-radius: 4px;">

        <button type="submit"
            style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
            Log in
        </button>

        <div style="text-align: center; margin-top: 12px;">
            <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPassword" style="color: #007bff; text-decoration: none; font-size: 14px;">
                Wachtwoord vergeten?
            </a>
        </div>

    </form>

    <div class="modal fade" id="forgotPassword" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Wachtwoord vergeten?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('login.sendresetlink') }}" method="POST">
                        @csrf
                        <label for="email" style="display: block; margin-bottom: 6px; font-weight: bold;">Email:</label>
                        <input id="email" name="email" type="email" required
                            style="width: 100%; padding: 8px; margin-bottom: 12px; border: 1px solid #ccc; border-radius: 4px;">

                        <button type="submit"
                            style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                            Verstuur resetlink
                        </button>
                    </form>
                </div>
            </div> 
        </div>
    </div>

    <div class="modal fade" id="resetLinkSent" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Resetlink verzonden!</h5>
                </div>
            </div> 
        </div>
    </div>

    @if(session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modal = new bootstrap.Modal(document.getElementById('resetLinkSent'));
                modal.show();
            });
        </script>
    @endif

@endsection