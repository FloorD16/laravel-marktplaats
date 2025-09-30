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

        <div>
            <button type="button" data-bs-toggle="modal" data-bs-target="#sendMessage"
                style="background-color: #007bff; color: white; border: none; padding: 8px 16px; margin-top: 20px; border-radius: 4px; font-weight: bold; cursor: pointer;">
                Stuur een bericht    
            </button>
        </div>

        <div class="modal fade" id="sendMessage" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                    <div class="modal-header" style="background-color: #007bff; color: white;">
                        <h5 class="modal-title">Berichten</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="max-height: 400px; overflow-y: auto; background-color: #f9f9f9; padding: 20px;">
                        @forelse($ad->messages as $message)
                            <div style="background-color: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 12px 16px; margin-bottom: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                <div style="margin-bottom: 6px;">
                                    <strong style="color: #333;">{{ $message->sender->name }}</strong>
                                </div>
                                <div style="color: #007bff; font-size: 15px; line-height: 1.4;">
                                    {{ $message->message }}
                                </div>
                                <div style="margin-top: 8px;">
                                    <small style="color: #999;">{{ $message->created_at->format('d-m-Y H:i') }}</small>
                                </div>
                            </div>
                        @empty
                            <p style="color: #999;">Er zijn nog geen berichten.</p>
                        @endforelse

                        <form method="POST" action="{{ route('message.store') }}" style="margin-top: 20px;">
                            @csrf
                            <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                            <input type="hidden" name="receiver_id" value="{{ $ad->user_id }}">

                            <label for="message" style="display: block; margin-bottom: 8px; font-weight: bold;">Nieuw bericht:</label>
                            <textarea name="message" id="message" rows="2" required
                                style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 12px;"></textarea>

                            <button type="submit"
                                style="background-color: #007bff; color: white; border: none; padding: 8px 16px; border-radius: 4px; font-weight: bold; cursor: pointer;">
                                Verzenden
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @endauth

    </div>
@endsection