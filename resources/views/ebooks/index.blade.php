@extends('layout')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection

@include('components.navbar')
@section('content')
    <div class="max-w-6xl mx-auto py-10">

        <h1 class="text-3xl font-bold mb-6">Daftar Ebook</h1>

        <!-- Grid Ebook -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">

            @forelse ($ebooks as $ebook)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition flex flex-col">

                    <!-- Cover -->
                    <div class="relative w-full aspect-[2/3] overflow-hidden rounded-t-lg">
                        <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="{{ $ebook->title }}"
                            class="w-full h-full object-cover">
                    </div>

                    <!-- Content -->
                    <div class="p-3 flex flex-col flex-1">

                        <h2 class="text-sm font-semibold leading-snug line-clamp-2">
                            {{ $ebook->title }}
                        </h2>

                        <p class="mt-1 text-sm font-bold text-yellow-600">
                            @if ($ebook->is_free)
<span class="font-semibold">
            <s class="text-red-600">Rp 129.000</s>
            <span>discount 100%</span>
            <div class="text-green-600">Rp 0</div>
        </span>                            @else
                                Rp {{ number_format($ebook->price, 0, ',', '.') }}
                            @endif
                        </p>

                        <div class="flex-grow"></div>

                        <a href="{{ route('ebooks.show', $ebook->id) }}"
                            class="mt-3 inline-flex items-center justify-center bg-[#D4AF37] hover:bg-[#c9a633] text-white text-xs px-3 py-2 rounded-md transition">
                            Lihat Detail
                        </a>

                    </div>
                </div>

            @empty
                <p class="text-gray-600">Belum ada ebook tersedia.</p>
            @endforelse

        </div>



        <!-- Pagination -->
        <div class="mt-8">
            {{ $ebooks->links() }}
        </div>
    </div>
@endsection
