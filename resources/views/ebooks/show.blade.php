@extends('layout')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@include('components.navbar')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10">

        <div class="flex flex-col md:flex-row gap-8">

            <!-- Cover -->
            <div class="md:w-1/3">
                <img src="{{ asset('storage/' . $ebook->cover_image) }}" class="rounded-xl shadow-lg"
                    alt="{{ $ebook->title }}">
            </div>

            <!-- Info Ebook -->
            <div class="md:w-2/3">
                <h1 class="text-3xl font-bold mb-3">{{ $ebook->title }}</h1>

                <div class="flex items-center gap-4 mb-4">
                    <span class="text-gray-600 text-sm">{{ $ebook->views }} views</span>
                    <span class="text-gray-600 text-sm">{{ $ebook->downloads }} downloads</span>
                </div>

                {{-- Harga hanya muncul jika user BELUM membeli --}}
                @if (!$hasPaid)
                    <div class="mb-4">
                        @if ($ebook->is_free)
                            <span class="font-semibold text-xl">
                                <s class="text-red-600">Rp 129.000</s>
                                <span>discount 100%</span>
                                <div class="text-green-600">Rp 0</div>
                            </span>
                        @else
                            <span class="text-yellow-600 font-semibold text-xl">
                                Rp {{ number_format($ebook->price, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>
                @endif

                {{-- Deskripsi pindah ke sini --}}
                <div class="mt-6 bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-700 leading-relaxed">
                        {!! nl2br(e($ebook->description)) !!}
                    </p>

                    {{-- BUTTON DIPINDAHKAN KE BAWAH DESKRIPSI --}}
                    <div class="mt-6">
                        @if ($ebook->is_free)
                            @auth
                                @php
                                    $waNumber = \App\Models\Setting::where('key', 'whatsapp_number')->value('value');
                                    $template = \App\Models\Setting::where('key', 'whatsapp_message_template')->value(
                                        'value',
                                    );
                                @endphp

                                @if ($waNumber && $template)
                                    @php
                                        $message = strtr($template, [
                                            '{title}' => $ebook->title,
                                            '{name}' => auth()->user()->name,
                                            '{email}' => auth()->user()->email,
                                            '{url}' => route('ebooks.show', $ebook->id),
                                        ]);

                                        $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($message);
                                    @endphp
                                @else
                                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-lg">
                                        WhatsApp belum dikonfigurasi oleh admin (nomor / template pesan kosong).
                                    </div>
                                @endif
                            @else
                                <div x-data="{ openClaim: false }">
                                    <button type="button" @click="openClaim = true"
                                        class="inline-flex bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                                        Get 100% Disc
                                    </button>

                                    <!-- MODAL -->
                                    <div x-show="openClaim" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                                        <!-- overlay -->
                                        <div class="absolute inset-0 bg-black/50" @click="openClaim = false"></div>

                                        <!-- modal box -->
                                        <div class="relative bg-white w-full max-w-md mx-4 rounded-xl shadow-lg p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <h2 class="text-lg font-bold">Klaim Diskon 100%</h2>
                                                <button type="button" @click="openClaim = false"
                                                    class="text-gray-500 hover:text-gray-800">
                                                    ✕
                                                </button>
                                            </div>

                                            <form method="POST" action="{{ route('ebooks.claim-discount', $ebook->id) }}"
                                                class="space-y-4">
                                                @csrf

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                                    <input type="text" name="name" required
                                                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring"
                                                        placeholder="Masukkan Nama Anda">
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                                    <input type="email" name="email" required
                                                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring"
                                                        placeholder="contoh@gmail.com">
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">No
                                                        WhatsApp</label>
                                                    <input type="text" name="whatsapp" required
                                                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring"
                                                        placeholder="08xxxx / 62xxxx">
                                                    <p class="text-xs text-gray-500 mt-1">Masukkan nomor aktif untuk verifikasi
                                                        / pengiriman link.</p>
                                                </div>

                                                <button type="submit"
                                                    class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                                                    Lanjutkan
                                                </button>

                                                <p class="text-xs text-gray-500 text-center">
                                                    Dengan klik “Lanjutkan”, data kamu akan disimpan untuk proses klaim.
                                                </p>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @endauth
                        @elseif ($hasPaid)
                            <a href="{{ route('ebooks.download', $ebook->id) }}"
                                class="inline-flex bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                                Download Ebook
                            </a>
                        @else
                            <a href="{{ route('ebooks.buy', $ebook->id) }}"
                                class="inline-flex bg-yellow-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-700 transition">
                                Beli Ebook
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Form Download Ebook (Untuk Semua Pengguna) -->
    @if ($ebook->is_free)
        <div class="max-w-4xl mx-auto px-4 py-8">
            <div class="bg-gradient-to-r from-green-50 to-blue-50 border border-green-200 rounded-xl p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Download Ebook Ini Sekarang!</h3>
                <p class="text-gray-600 mb-4">Isi form di bawah ini untuk mendapatkan link download ebook ini melalui
                    WhatsApp.</p>

                <form action="{{ route('ebooks.download-form', $ebook->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" required
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" required
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="contoh@email.com">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp" required
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan nomor whatsApp aktif">
                        <p class="text-xs text-gray-500 mt-1">Pastikan nomor WhatsApp aktif.
                        </p>
                    </div>
                    <button type="submit"
                        class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition-colors font-semibold">
                        Download Now
                    </button>
                    <p class="text-xs text-gray-500 text-center">Dengan mengklik tombol di atas, Anda setuju bahwa data Anda
                        akan disimpan untuk proses download.</p>
                </form>
            </div>
        </div>
    @endif

    <!-- Ebook Lainnya -->
    <div class="max-w-7xl mx-auto px-4 py-10">
        <h2 class="text-2xl font-bold mb-6">Ebook Lainnya</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($otherEbooks as $otherEbook)
                <a href="{{ route('ebooks.show', $otherEbook->id) }}" class="group block">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <img src="{{ asset('storage/' . $otherEbook->cover_image) }}" alt="{{ $otherEbook->title }}"
                            class="w-full h-64 object-cover object-center group-hover:scale-105 transition-transform">
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2 group-hover:text-yellow-600 transition-colors">
                                {{ $otherEbook->title }}
                            </h3>

                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span>{{ $otherEbook->views }} views</span>
                                <span>{{ $otherEbook->downloads }} downloads</span>
                            </div>

                            @if ($otherEbook->is_free)
                                <div class="mt-2 text-green-600 font-semibold">Gratis</div>
                            @else
                                <div class="mt-2 text-yellow-600 font-semibold">
                                    Rp {{ number_format($otherEbook->price, 0, ',', '.') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
