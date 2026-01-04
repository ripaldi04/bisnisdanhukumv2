@extends('layout')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection

@include('components.navbar')
@section('content')
    <section class="container w-full mx-auto px-6 lg:px-20 py-16">

        <div class="flex flex-col gap-[30px] items-center">
            <div class="bg-[#D4AF37] w-fit p-[8px_16px] rounded-full  flex items-center gap-[6px]">
                <p class="font-medium text-sm text-white">Dapatkan Harga Terbaik</p>
            </div>
            <div class="flex flex-col  text-center">
                <h2 class="font-bold text-[40px] leading-[60px]">{{ $premium->title }}</h2>
                <p class="text-lg -tracking-[2%]">{{ $premium->sub_title }}</p>
            </div>
            <div class="flex lg:flex-row flex-col justify-between space-x-0 lg:space-x-12 gap-[30px]">
                <div class="flex flex-col rounded-3xl p-8 gap-[30px] bg-[#f1f1fc] shadow lg:shadow-none h-fit">
                    <div class="flex flex-col gap-5">
                        <div class="flex flex-col gap-4">
                            <p class="font-semibold text-4xl leading-[54px]">Standar</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold text-4xl leading-[54px]">Rp 0 (Free)</p>
                        </div>
                        <div class="flex flex-col gap-4">
                            <div class="flex gap-3">
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="assets/icon/tick-circle.svg" class="w-full h-full object-cover"
                                        alt="icon">
                                </div>
                                <p class="text-[#475466]">Akses terbatas hanya 3 materi</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('register') }}"
                        class="p-[20px_32px] rounded-full text-center font-semibold text-xl ring-1 ring-black transition-all duration-300 hover:ring-2 hover:ring-[#4540e1]">Daftar
                        Akun</a>
                </div>
                <div class="flex flex-col rounded-3xl p-8 gap-[30px] bg-[#f1f1fc] shadow lg:shadow-none h-fit">
                    <div class="flex flex-col gap-5">
                        <div class="flex flex-col gap-4">
                            <p class="font-semibold text-4xl leading-[54px]">Premium</p>
                            <p class="text-[#475466] text-lg">{{ $premium->description }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <!-- Harga coret pertama -->
                            <p class="text-[#475466] text-lg line-through">Rp 3.750.000 /tahun</p>
                            <!-- Harga coret kedua -->
                            <p class="text-[#475466] text-lg line-through">Rp 2.250.000 /tahun</p>
                            <!-- Harga utama -->
                            <p class="font-semibold text-4xl leading-[54px]">Rp
                                {{ number_format($premium->price, 0, ',', '.') }} /tahun</p>
                        </div>
                        <div class="flex flex-col gap-4">
                            @foreach ($premium->premiumDescriptions as $description)
                                <div class="flex gap-3">
                                    <div class="w-6 h-6 flex shrink-0">
                                        <img src="assets/icon/tick-circle.svg" class="w-full h-full object-cover"
                                            alt="icon">
                                    </div>
                                    <p class="text-[#475466]">{{ $description->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <form action="{{ route('create-invoice') }}" method="POST">
                        @csrf
                        <button
                            class="p-[20px_32px] bg-[#D4AF37] text-white rounded-full text-center font-semibold text-xl transition-all duration-300 hover:shadow-[0_10px_20px_0_#4540e180]">Subscribe
                            Sekarang</button>
                    </form>
                </div>
            </div>
            @include('components.testimonial2')
            @include('components.faq')
        </div>
    </section>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            slidesPerView: 3,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true, // Pagination harus bisa diklik
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                300: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                },
            },
        });
    </script>
@endsection
