@extends('layout')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection

@include('components.navbar')

@section('content')
    <div class="max-w-3xl mx-auto py-10">

        @if ($liveCourse->cover_image)
            <div class="w-full h-64 rounded-xl overflow-hidden mb-6">
                <img src="{{ asset('storage/' . $liveCourse->cover_image) }}" class="w-full h-full object-cover"
                    alt="{{ $liveCourse->title }}">
            </div>
        @else
            <div class="w-full h-64 bg-gray-200 rounded-xl flex items-center justify-center mb-6">
                <p class="text-gray-500">No Image</p>
            </div>
        @endif

        <h1 class="text-3xl font-bold mb-4">{{ $liveCourse->title }}</h1>

        <p class="text-gray-600 mt-2">{{ $liveCourse->description }}</p>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <strong>Waktu:</strong><br>
                {{ \Carbon\Carbon::parse($liveCourse->start_time)->translatedFormat('d F Y H.i') }} WIB
                @if ($liveCourse->end_time)
                    - {{ \Carbon\Carbon::parse($liveCourse->end_time)->translatedFormat('H.i') }} WIB
                @endif
            </div>

            @if ($userHasAccess ?? false)
                @if ($liveCourse->meeting_id)
                    <div>
                        <strong>Meeting ID:</strong><br>
                        {{ $liveCourse->meeting_id }}
                    </div>
                @endif

                @if ($liveCourse->meeting_password)
                    <div>
                        <strong>Password:</strong><br>
                        {{ $liveCourse->meeting_password }}
                    </div>
                @endif

                @if ($liveCourse->zoom_link)
                    <div class="md:col-span-2 mt-4">
                        <a href="{{ $liveCourse->zoom_link }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Join Zoom Meeting
                        </a>
                    </div>
                @endif
            @else
                <div class="md:col-span-2 mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-yellow-800 font-medium">Detail Zoom Meeting</p>
                            <p class="text-yellow-600 text-sm">Akan ditampilkan setelah Anda berhasil mendaftar dan
                                melakukan
                                pembayaran</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if (!$userHasAccess)
            <div class="mt-6">
                <div class="text-2xl font-bold text-yellow-600">
                    @if ($liveCourse->is_free)
                        Gratis
                    @else
                        Rp {{ number_format($liveCourse->price, 0, ',', '.') }}
                    @endif
                </div>
            </div>
        @endif


        @auth
            @if (!$userHasAccess)
                {{-- Tampilkan tombol daftar hanya jika belum join --}}
                <a href="{{ route('live-courses.buy', $liveCourse->id) }}"
                    class="mt-6 inline-block bg-green-600 text-white px-5 py-3 rounded-lg">
                    @if ($liveCourse->is_free)
                        Join Sekarang
                    @else
                        Daftar Sekarang
                    @endif
                </a>
            @endif
        @else
            {{-- Belum login --}}
            <a href="{{ route('login') }}" class="mt-6 inline-block bg-yellow-600 text-white px-5 py-3 rounded-lg">
                Masuk untuk Daftar
            </a>
        @endauth


    </div>
@endsection
