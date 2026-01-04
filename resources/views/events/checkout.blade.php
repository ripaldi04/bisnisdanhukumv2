@extends('layout')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection

@include('components.navbar')

@section('content')
    <div class="max-w-2xl mx-auto py-10">

        <h1 class="text-2xl font-bold">Checkout Event</h1>

        <div class="bg-white p-6 shadow rounded-lg mt-4">

            <h2 class="text-xl font-semibold">{{ $event->title }}</h2>

            <p class="mt-2 text-gray-600">
                Harga: <strong>{{ $event->is_free ? 'Gratis' : 'Rp ' . number_format($event->price) }}</strong>
            </p>

            <p class="mt-1 text-sm text-gray-500">
                TRX ID: {{ $trx->trx_id }}
            </p>

            <hr class="my-4">

            <!-- Tombol Midtrans -->
            <button id="pay-button" class="bg-yellow-600 text-white px-4 py-2 rounded">
                Bayar Sekarang
            </button>

        </div>
    </div>

    {{-- Script Midtrans --}}
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = "/events/{{ $event->id }}";
                },
                onPending: function(result) {
                    alert("Menunggu pembayaran...");
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                }
            });
        };
    </script>
@endsection
