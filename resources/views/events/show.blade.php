@extends('layout')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection

@include('components.navbar')

@section('content')
    <div class="max-w-3xl mx-auto py-10">

        <img src="{{ asset('storage/' . $event->banner) }}" class="w-full rounded-xl">

        <h1 class="text-3xl font-bold mt-4">{{ $event->title }}</h1>

        <p class="text-gray-600 mt-2">{{ $event->description }}</p>

        <div class="mt-4">
            <strong>Lokasi:</strong> {{ $event->location }} <br>
            {{ $event->address }}
        </div>

        <div class="mt-4">
            <strong>Waktu:</strong><br>
            {{ \Carbon\Carbon::parse($event->start_time)->translatedFormat('d F Y H.i') }} WIB
        </div>

        <div class="mt-4 text-xl font-bold text-yellow-600">
            @if (!$hasTicket)
                <div class="mt-4 text-xl font-bold text-yellow-600">
                    @if ($event->is_free)
                        Gratis
                    @else
                        Rp {{ number_format($event->price, 0, ',', '.') }}
                    @endif
                </div>
            @endif

        </div>

        @if (auth()->check())
            @if ($hasTicket)
                <a href="{{ route('events.ticket', $trxId) }}"
                    class="mt-6 inline-block bg-yellow-600 text-white px-5 py-3 rounded-lg">
                    Lihat Tiket
                </a>
            @else
                <a href="{{ route('events.buy', $event->id) }}"
                    class="mt-6 inline-block bg-green-600 text-white px-5 py-3 rounded-lg">
                    Daftar Sekarang
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="mt-6 inline-block bg-yellow-600 text-white px-5 py-3 rounded-lg">
                Masuk untuk Daftar
            </a>
        @endif


    </div>
@endsection
