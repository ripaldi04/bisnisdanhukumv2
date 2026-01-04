@extends('layout')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection

@include('components.navbar')

@section('content')
    <div class="max-w-3xl mx-auto py-10">

        <div class="bg-white rounded-xl shadow p-6">
            <h1 class="text-2xl font-bold mb-6">Checkout Live Course</h1>

            <div class="mb-6">
                <h2 class="text-xl font-semibold">{{ $liveCourse->title }}</h2>
                <p class="text-gray-600 mt-1">{{ $liveCourse->description }}</p>
            </div>

            <div class="border-t pt-4 mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span>Harga Live Course</span>
                    <span class="font-semibold">Rp {{ number_format($liveCourse->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center font-bold text-lg">
                    <span>Total</span>
                    <span>Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <div id="payment-form" class="space-y-4">
                <div id="pay-button"
                    class="w-full bg-yellow-600 text-white py-3 rounded-lg cursor-pointer hover:bg-yellow-700 transition">
                    Bayar Sekarang
                </div>
            </div>
        </div>

    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = "/live-courses/{{ $liveCourse->id }}";
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
