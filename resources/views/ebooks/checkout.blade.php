@extends('layout')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection

@include('components.navbar')
@section('content')
    <div class="max-w-2xl mx-auto py-10">

        <h1 class="text-2xl font-bold mb-4">Checkout Ebook</h1>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold">{{ $ebook->title }}</h2>

            <p class="mt-2 text-gray-600">
                Harga: <strong>Rp {{ number_format($ebook->price) }}</strong>
            </p>

            <p class="text-sm text-gray-500">
                TRX ID: {{ $trx->trx_id }}
            </p>

            <hr class="my-4">

            <div class="flex justify-between items-center">
                {{-- Tombol Kembali --}}
                <a href="{{ route('ebooks.show', $ebook->id) }}"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
                    ← Kembali
                </a>

                {{-- Tombol Bayar --}}
                <button id="pay-button" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition">
                    Bayar dengan Midtrans
                </button>
            </div>
        </div>
    </div>

    {{-- Midtrans JS --}}
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = "/ebooks/{{ $ebook->id }}";
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
