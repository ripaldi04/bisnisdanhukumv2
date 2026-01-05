@extends('layout')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-10">
        {{-- HEADER --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900">
                Koleksi Ebook Terbaik untuk Bisnis dan Hukum
            </h1>
            <p class="text-slate-600 mt-3">
                Baca dari atas, pilih ebook, lalu lanjut detail untuk klaim / beli.
            </p>
        </div>

        {{-- LIST VERTICAL (1 COLUMN) --}}
        <div class="space-y-10">
            @forelse ($ebooks as $ebook)
                <article class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    {{-- COVER TOP (SEPERTI GAMBAR) --}}
                    <div class="bg-gradient-to-b from-slate-900 to-slate-700 px-6 py-10 flex justify-center">
                        <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="{{ $ebook->title }}"
                            class="w-64 md:w-72 aspect-[3/4] object-cover rounded-xl shadow-2xl ring-1 ring-white/10"
                            loading="lazy">
                    </div>

                    <div class="p-6 md:p-8 space-y-6">
                        {{-- TITLE --}}
                        <div class="text-center space-y-3">
                            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-tight">
                                {{ $ebook->title }}
                            </h2>

                            <div class="text-slate-600 prose prose-slate max-w-none text-left">
                                {!! $ebook->landingDescription->description ?? $ebook->description !!}
                            </div>
                        </div>

                        {{-- STATS + PRICE --}}
                        {{-- <div class="flex items-center justify-between text-sm text-slate-500">
                            <div class="flex items-center gap-3">
                                <span>{{ $ebook->views }} views</span>
                                <span>•</span>
                                <span>{{ $ebook->downloads }} downloads</span>
                            </div>

                            @if ($ebook->is_free)
                                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-semibold">
                                    Gratis
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 font-semibold">
                                    Rp {{ number_format($ebook->price, 0, ',', '.') }}
                                </span>
                            @endif
                        </div> --}}

                        {{-- CTA UTAMA --}}
                        {{-- <div class="flex justify-center">
                            <a href="{{ route('ebooks.show', $ebook->id) }}"
                                class="inline-flex items-center justify-center rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-semibold px-6 py-3 transition">
                                Lihat Detail Ebook
                            </a>
                        </div> --}}
                    </div>
                </article>
            @empty
                <p class="text-center text-slate-500">Tidak ada ebook tersedia saat ini.</p>
            @endforelse
        </div>

        <form id="order-form" method="POST" action="/ebooks/{{ $ebooks->first()->id ?? 0 }}/download-form"
            class="space-y-6 mt-10">
            @csrf

            {{-- PILIH PAKET --}}
            <div class="space-y-2">
                <h3 class="text-sm font-extrabold text-slate-900">Pilih Ebook:</h3>

                @foreach ($ebooks->where('is_free', true) as $ebook)
                    <label class="block" data-title="{{ $ebook->title }}"
                        data-desc="{{ Str::limit(strip_tags($ebook->description), 80) }}" data-price="{{ $ebook->price }}"
                        data-free="1">
                        <div class="flex gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4">
                            <input type="radio" name="ebook_id" value="{{ $ebook->id }}"
                                {{ $loop->first ? 'checked' : '' }} class="mt-1 h-4 w-4 text-blue-600">

                            <div class="flex-1">
                                <div class="flex items-start gap-3">
                                    {{-- thumbnail kecil (opsional) --}}
                                    <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="{{ $ebook->title }}"
                                        class="w-12 h-16 object-cover rounded-md ring-1 ring-slate-200">

                                    <div class="space-y-1">
                                        <div class="text-xs font-extrabold text-slate-900 uppercase">
                                            {{ $ebook->title }}
                                        </div>

                                        <div class="text-xs text-slate-600">
                                            {{ Str::limit(strip_tags($ebook->description), 120) }}
                                        </div>

                                        <div class="text-xs text-blue-700 font-semibold">
                                            Gratis
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>

            {{-- LENGKAPI DATA --}}
            <div class="space-y-3">
                <h3 class="text-sm font-extrabold text-slate-900">Lengkapi Data</h3>

                <div class="space-y-2">
                    <label class="text-xs font-semibold text-slate-700">Nama Lengkap <span
                            class="text-rose-600">*</span></label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-semibold text-slate-700">No. WhatsApp <span
                            class="text-rose-600">*</span></label>
                    <div class="flex">
                        <span
                            class="inline-flex items-center rounded-l-md border border-slate-300 bg-slate-100 px-3 text-sm text-slate-700">
                            🇮🇩 +62
                        </span>
                        <input type="text" name="whatsapp" required value="{{ old('whatsapp') }}"
                            placeholder="812xxxxxxx"
                            class="w-full rounded-r-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    @error('whatsapp')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-semibold text-slate-700">Email <span class="text-rose-600">*</span></label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>



            {{-- SUBMIT --}}
            <button id="order-button" type="submit"
                class="w-full rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-3 transition">
                Download Gratis
            </button>

            <p class="text-[10px] text-slate-500 text-center leading-relaxed">
                Dengan melanjutkan, Anda setuju dengan ketentuan layanan yang berlaku.
            </p>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const radios = document.querySelectorAll('input[name="ebook_id"]');
                const form = document.getElementById('order-form');

                function updateForm() {
                    const checked = document.querySelector('input[name="ebook_id"]:checked');
                    if (checked) {
                        const ebookId = checked.value;
                        form.action = `/ebooks/${ebookId}/download-form`;
                    }
                }

                radios.forEach(radio => {
                    radio.addEventListener('change', updateForm);
                });

                // Initial update
                updateForm();
            });
        </script>
    </div>
@endsection
