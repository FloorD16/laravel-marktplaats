@extends('layouts.app')

@section('title', 'Profiel')

@section('content')
<div style="max-width: 800px; margin: 40px auto; font-family: Arial, sans-serif;">
    <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Mijn Profiel</h2>
    
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

    <div style="margin-bottom: 16px;">
        <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Naam:</label>
        <div style="display: flex; align-items: center;">
            <p id="name" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; margin: 0;">{{ $user->name }}</p>
            <i class="fas fa-edit" 
                data-bs-toggle="modal" 
                data-bs-target="#editProfile" 
                data-field="name"
                data-value="{{ $user->name }}"
                data-label="Bewerk naam:" 
                style="margin-left: 10px; cursor: pointer; font-size: 18px;">
            </i>
        </div>
    </div>

    <div style="margin-bottom: 16px;">
        <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Email:</label>
        <div style="display: flex; align-items: center;">
            <p id="name" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; margin: 0;">{{ $user->email }}</p>
            <i class="fas fa-edit" 
                data-bs-toggle="modal" 
                data-bs-target="#editProfile" 
                data-field="email"
                data-value="{{ $user->email }}"
                data-label="Bewerk email:" 
                style="margin-left: 10px; cursor: pointer; font-size: 18px;">
            </i>
        </div>
    </div>

    <div style="margin-bottom: 16px;">
        <label for="password" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Wachtwoord:</label>
        <div style="display: flex; align-items: center;">
            <p id="name" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; margin: 0;">&#9679&#9679&#9679&#9679&#9679&#9679&#9679&#9679</p>
            <i class="fas fa-edit" 
                data-bs-toggle="modal" 
                data-bs-target="#editProfile" 
                data-field="password"
                data-value=""
                data-label="Nieuw wachtwoord:" 
                style="margin-left: 10px; cursor: pointer; font-size: 18px;">
            </i>
        </div>
    </div>

    <div style="margin-bottom: 16px;">
        <form action="{{ route('profile.update') }}" method="POST" id="notificationForm">
            @csrf
            @method('PUT')

            <label for="email_notifications" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Emailnotificaties:</label>
            <div style="display: flex; align-items: center;">
                <input type="hidden" name="field" value="email_notifications">
                <div class="form-check" style="flex: 1;">
                    <input class="form-check-input" type="checkbox" name="value" id="email_notifications"
                        {{ $user->email_notifications ? 'checked' : '' }}
                        onchange="document.getElementById('notificationForm').submit();">
                    <label class="form-check-label" for="email_notifications">
                        Ontvang emailnotificaties
                    </label>
                </div>
            </div>
        </form>
    </div>
        
    <div class="modal fade" id="editProfile" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <div class="modal-body">
                            <input type="hidden" name="field" id="modalField">
                            <input type="text" name="value" id="modalValue" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Opslaan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                        </div>
                    </div>
                </div> 
            </form>
        </div>
    </div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editModal = document.getElementById('editProfile');
            editModal.addEventListener('show.bs.modal', function (event) {
                const icon = event.relatedTarget;
                const field = icon.getAttribute('data-field');
                const value = icon.getAttribute('data-value');
                const label = icon.getAttribute('data-label');

                document.getElementById('modalField').value = field;
                document.getElementById('modalValue').value = value;
                document.getElementById('editModalLabel').textContent = label;
            });
        });
    </script>
@endsection