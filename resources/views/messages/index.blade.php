@extends('layouts.app')

@section('title', 'Advertenties')

@section('content')
    <div style="display: flex; gap: 20px;">
        
        <div style="width: 220px; background-color: #f8fafc; padding: 20px; border-right: 1px solid #e2e8f0; box-shadow: 2px 0 5px rgba(0,0,0,0.05);">
            <h4 style="margin-bottom: 16px; font-size: 18px; color: #333;">Gesprekken</h4>
            @foreach($partners as $key => $partner)
                <a href="{{ route('messages', ['conversation' => $key]) }}"
                style="display: block; padding: 10px 12px; margin-bottom: 8px; background-color: {{ $key === $conversationId ? '#e0f2fe' : '#fff' }};
                        border-radius: 6px; color: #007bff; text-decoration: none; font-weight: {{ $key === $conversationId ? 'bold' : 'normal' }};
                        border: 1px solid #dbeafe;">
                    {{ $partner->name }}
                </a>
            @endforeach
        </div>

        <div style="flex: 1; overflow-y: auto; background-color: #f1f5f9; padding: 24px;">
            @if($selectedMessages->isNotEmpty())
                @php
                    $otherUser = $selectedMessages->first()->sender_id === Auth::id()
                        ? $selectedMessages->first()->receiver
                        : $selectedMessages->first()->sender;
                @endphp

                <h4 style="color: #1e293b; font-size: 20px; margin-bottom: 20px;">Gesprek met {{ $otherUser->name }}</h4>

                @foreach($selectedMessages as $message)
                    @php $isMine = $message->sender_id === Auth::id(); @endphp
                    <div style="display: flex; justify-content: {{ $isMine ? 'flex-end' : 'flex-start' }}; margin-bottom: 12px;">
                        <div style="
                            max-width: 70%;
                            background-color: {{ $isMine ? '#d1e7dd' : '#ffffff' }};
                            border: 1px solid {{ $isMine ? '#badbcc' : '#cbd5e1' }};
                            border-radius: 12px;
                            padding: 12px 16px;
                            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                            text-align: left;
                        ">
                            <div style="margin-bottom: 6px; font-weight: bold; color: #334155;">
                                {{ $message->sender->name }}
                            </div>
                            <div style="color: {{ $isMine ? '#0f5132' : '#1d4ed8' }}; font-size: 15px; line-height: 1.5;">
                                {{ $message->message }}
                            </div>
                            <div style="margin-top: 6px;">
                                <small style="color: #64748b;">{{ $message->created_at->format('d-m-Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach

                <form method="POST" action="{{ route('message.store') }}" style="margin-top: 20px;">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
    
                    <label for="message" style="display: block; margin-bottom: 8px; font-weight: bold;">Nieuw bericht:</label>
                    <textarea name="message" id="message" rows="2" required
                        style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 12px;"></textarea>
    
                    <button type="submit"
                        style="background-color: #007bff; color: white; border: none; padding: 8px 16px; border-radius: 4px; font-weight: bold; cursor: pointer;">
                        Verzenden
                    </button>
                </form>
            
            @elseif($partners->isEmpty())
                <p style="color: #64748b;">Je hebt nog geen gesprekken.</p>

            @else
                <p style="color: #64748b;">Selecteer een gesprek om te bekijken.</p>
            @endif

        </div>

    </div>

@endsection