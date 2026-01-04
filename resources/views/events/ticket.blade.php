@extends('layout')

@include('components.navbar')

@section('content')
    @php
        use SimpleSoftwareIO\QrCode\Facades\QrCode;
    @endphp

    <div class="max-w-md mx-auto mt-10 bg-white shadow-lg p-6 rounded-xl mb-6">

        {{-- Tombol Kembali --}}
        <div class="mt-6 text-left">
            <a href="{{ route('events.show', $event->id) }}"
                class="inline-block bg-gray-200 text-gray-700 px-5 py-3 rounded-lg hover:bg-gray-300 transition mb-3">
                ← Kembali
            </a>
        </div>

        @if ($checkedIn)
            <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded-lg">
                ✔ Anda sudah berhasil Check-In pada:
                <strong>{{ \Carbon\Carbon::parse($trx->checked_in_at)->translatedFormat('d F Y H:i') }} WIB</strong>
            </div>
        @endif

        <h1 class="text-xl font-bold mb-4">Tiket Event</h1>

        <p><strong>Event:</strong> {{ $event->title }}</p>
        <p><strong>Nama Peserta:</strong> {{ $trx->user->name }}</p>
        <p><strong>Waktu:</strong>
            {{ \Carbon\Carbon::parse($trx->start_time)->translatedFormat('d F Y H:i') }} WIB
        </p>

        <div class="mt-6 text-center">
            <h2 class="font-semibold mb-2">QR Code Tiket</h2>

            @if ($trx->ticket_code)
                <div class="flex justify-center">
                    {!! QrCode::size(250)->generate(url('/events/check-in/' . $trx->ticket_code)) !!}
                </div>

                <p class="mt-3 text-gray-600">Kode Tiket: {{ $trx->ticket_code }}</p>
            @else
                <p class="text-red-500">QR Code belum tersedia.</p>
            @endif
        </div>

    </div>
@endsection
