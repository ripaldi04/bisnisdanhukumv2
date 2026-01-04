@extends('layout')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection

@include('components.navbar')

@section('content')
    <div class="max-w-6xl mx-auto py-10">

        <h1 class="text-3xl font-bold mb-6">Acara Offline</h1>

        @if ($events->isEmpty())
            <!-- Coming Soon -->
            <div class="flex flex-col items-center justify-center h-[300px] text-center">
                <h2 class="text-3xl font-bold text-gray-400">Coming Soon</h2>
                <p class="mt-2 text-gray-500">
                    Acara offline sedang dipersiapkan.
                </p>
            </div>
        @else
            <!-- Grid Event -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($events as $event)
                    <div class="bg-white rounded-xl shadow p-4 hover:shadow-lg transition">

                        <img src="{{ asset('storage/' . $event->banner) }}" class="w-full h-40 object-cover rounded"
                            alt="{{ $event->title }}">

                        <h2 class="text-xl font-semibold mt-3">
                            {{ $event->title }}
                        </h2>

                        <p class="mt-1 text-gray-600">
                            {{ \Carbon\Carbon::parse($event->start_time)->translatedFormat('d F Y H.i') }} WIB
                        </p>

                        <p class="mt-2 font-bold text-yellow-600">
                            @if ($event->is_free)
                                Gratis
                            @else
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            @endif
                        </p>

                        <a href="{{ route('events.show', $event->id) }}"
                            class="mt-4 inline-block bg-[#D4AF37] text-white px-4 py-2 rounded">
                            Lihat Detail
                        </a>

                    </div>
                @endforeach
            </div>
        @endif

    </div>

@endsection
