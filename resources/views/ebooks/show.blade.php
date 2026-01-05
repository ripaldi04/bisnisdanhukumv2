@extends('layout')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
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

                </div>

            </div>
        </div>

    </div>

    <!-- Form Download Ebook (Untuk Semua Pengguna) -->
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-gradient-to-r from-green-50 to-blue-50 border border-green-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                @if ($ebook->is_free)
                    Download Ebook Ini Sekarang!
                @else
                    Download Ebook Ini Sekarang!
                @endif
            </h3>
            <p class="text-gray-600 mb-4">
                @if ($ebook->is_free)
                    Isi form di bawah ini untuk mendapatkan link download ebook ini melalui WhatsApp.
                @else
                    Isi form di bawah ini untuk melanjutkan pembelian ebook ini. Setelah pembayaran berhasil, Anda bisa
                    langsung download ebook.
                @endif
            </p>

            @if ($ebook->is_free)
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
            @else
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form id="purchase-form" action="{{ route('ebooks.purchase-form', $ebook->id) }}" method="POST"
                    class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" required
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                placeholder="Masukkan nama Anda" value="{{ old('name') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" required
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                placeholder="contoh@email.com" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp" required
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                            placeholder="Masukkan nomor whatsApp aktif" value="{{ old('whatsapp') }}">
                        <p class="text-xs text-gray-500 mt-1">Pastikan nomor WhatsApp aktif untuk konfirmasi pembayaran.
                        </p>
                    </div>
                    <button type="submit"
                        class="w-full bg-yellow-600 text-white py-3 rounded-lg hover:bg-yellow-700 transition-colors font-semibold">
                        Download Now
                    </button>
                    <p class="text-xs text-gray-500 text-center">Dengan mengklik tombol di atas, Anda setuju untuk
                        melanjutkan pembelian ebook ini.</p>
                </form>
            @endif
        </div>
    </div>

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

    <script>
        document.getElementById('purchase-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Trigger Midtrans popup
                        window.snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                alert("Pembayaran berhasil!");
                                window.location.href = '{{ route('ebooks.show', $ebook->id) }}';
                            },
                            onPending: function(result) {
                                alert("Menunggu pembayaran!");
                                window.location.href = '{{ route('ebooks.show', $ebook->id) }}';
                            },
                            onError: function(result) {
                                alert("Pembayaran gagal!");
                                window.location.href = '{{ route('ebooks.show', $ebook->id) }}';
                            },
                            onClose: function() {
                                alert('Halaman dibuka tanpa menyelesaikan pembayaran');
                            }
                        });
                    } else {
                        alert(data.message || 'Terjadi kesalahan saat memproses pembayaran.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses permintaan.');
                });
        });
    </script>
@endsection
