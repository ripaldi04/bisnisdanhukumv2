@extends('layout')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection

@include('components.navbar')

@section('content')
    <div class="max-w-6xl mx-auto py-10">

        <!-- HEADER -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold">Live Courses</h1>
        </div>

        <!-- CONTENT -->
        <div class="min-h-[60vh] flex items-center justify-center">

          @if ($liveCourses->isEmpty())
                <div class="flex flex-col items-center justify-center h-[300px] text-center">
                <h2 class="text-3xl font-bold text-gray-400">Coming Soon</h2>
                <p class="mt-2 text-gray-500">
                    Acara offline sedang dipersiapkan.
                </p>
            </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
                    @foreach ($liveCourses as $course)
                        <div class="bg-white rounded-xl shadow p-4 hover:shadow-lg transition">

                            @if ($course->cover_image)
                                <img src="{{ asset('storage/' . $course->cover_image) }}"
                                    class="w-full h-40 object-cover rounded"
                                    alt="{{ $course->title }}">
                            @else
                                <div class="w-full h-40 bg-gray-200 rounded flex items-center justify-center">
                                    <p class="text-gray-500">No Image</p>
                                </div>
                            @endif

                            <h2 class="text-xl font-semibold mt-3">{{ $course->title }}</h2>

                            <p class="mt-1 text-gray-600">
                                {{ \Carbon\Carbon::parse($course->start_time)->translatedFormat('d F Y H.i') }} WIB
                            </p>

                            <p class="mt-2 font-bold text-yellow-600">
                                @if ($course->is_free)
                                    Gratis
                                @else
                                    Rp {{ number_format($course->price, 0, ',', '.') }}
                                @endif
                            </p>

                            <a href="{{ route('live-courses.show', $course->id) }}"
                                class="mt-4 inline-block bg-[#D4AF37] text-white px-4 py-2 rounded">
                                Lihat Detail
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

    </div>
@endsection
