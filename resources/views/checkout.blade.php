@extends('layout')

@include('components.navbar')
@section('content')
    <div id="checkout-section" class="mx-auto w-full min-h-screen flex flex-col gap-[30px]">
        <div class="mx-auto container">
            <div class="flex flex-col gap-[10px] items-center">
                <div class="bg-[#4540e1] w-fit p-[8px_16px] rounded-full  flex items-center gap-[6px]">
                    <p class="font-medium text-sm text-white">Investasi Dirimu Hari Ini</p>
                </div>
                <h2 class="font-bold text-[40px] leading-[60px] text-white">Checkout Subscription</h2>
            </div>
            <div class="mx-auto flex lg:flex-row flex-col gap-10 px-14 py-8  justify-center">
                <div class="xl:w-1/3 w-full ">
                    <div class="xl:w-[400px] w-full flex shrink-0 flex-col bg-[#f1f1fc] rounded-2xl p-5 gap-4 h-fit">
                        <p class="font-bold text-lg">Paket</p>
                        <div class="flex items-center justify-between w-full">
                            <div class="flex items-center gap-3">
                                <div class="w-[50px] h-[50px] flex shrink-0 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/icon/Web Development 1.svg') }}"
                                        class="w-full h-full object-cover" alt="photo">
                                </div>
                                <div class="flex flex-col gap-[2px]">
                                    <p class="font-semibold">Premium</p>
                                    <p class="text-sm text-[#6D7786]">1 tahun akses</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="flex flex-col gap-5">
                            <div class="flex gap-3">
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="{{ asset('assets/icon/tick-circle.svg') }}" class="w-full h-full object-cover"
                                        alt="icon">
                                </div>
                                <p class="text-[#475466]">Akses ke semua materi</p>
                            </div>
                            <div class="flex gap-3">
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="{{ asset('assets/icon/tick-circle.svg') }}" class="w-full h-full object-cover"
                                        alt="icon">
                                </div>
                                <p class="text-[#475466]">Komunitas Eksklusif</p>
                            </div>
                            <div class="flex gap-3">
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="{{ asset('assets/icon/tick-circle.svg') }}" class="w-full h-full object-cover"
                                        alt="icon">
                                </div>
                                <p class="text-[#475466]">Praktik Terbaik</p>
                            </div>
                        </div>
                        <p class="font-semibold text-[28px] leading-[42px]">Rp
                            {{ number_format($invoice->total_amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <div class="xl:w-1/2 w-full">
                    <form action="{{ route('checkout.store', ['trxID' => $invoice->trx_id]) }}" method="POST"
                        enctype="multipart/form-data" class="w-full flex flex-col bg-[#f1f1fc] rounded-2xl p-5 gap-5">
                        @csrf

                        <p>{{ $invoice->invoice_code }}</p>
                        <div class="flex justify-between">
                            <p class="font-bold text-lg">No Invoice</p>
                            <p class="font-semibold">{{ $invoice->trx_id }}</p>
                        </div>
                        <div class="flex justify-between">
                            <p class="font-bold text-lg">Batas pembayaran</p>
                            <p class="font-semibold"><span id="countdown"></span></p>
                        </div>

                        <p class="font-bold text-lg">Metode Pembayaran</p>
                        @foreach ($paymentMethods as $paymentMethod)
                            <div>
                                <div class="flex flex-col gap-5">
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-3">
                                            <div class="w-6 h-6 flex shrink-0">
                                                <img src="{{ asset('assets/icon/tick-circle.svg') }}"
                                                    class="w-full h-full object-cover" alt="icon">
                                            </div>
                                            <p class="text-[#475466]">Nama Bank</p>
                                        </div>
                                        <p class="font-semibold">{{ $paymentMethod->nama_bank }}</p>
                                        <input type="hidden" name="bankName" value="Bank Indonesia">
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-3">
                                            <div class="w-6 h-6 flex shrink-0">
                                                <img src="{{ asset('assets/icon/tick-circle.svg') }}"
                                                    class="w-full h-full object-cover" alt="icon">
                                            </div>
                                            <p class="text-[#475466]">Nomor Rekening</p>
                                        </div>
                                        <p class="font-semibold">{{ $paymentMethod->no_rekening }}</p>
                                        <input type="hidden" name="accountNumber" value="22081996202191404">
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-3">
                                            <div class="w-6 h-6 flex shrink-0">
                                                <img src="{{ asset('assets/icon/tick-circle.svg') }}"
                                                    class="w-full h-full object-cover" alt="icon">
                                            </div>
                                            <p class="text-[#475466]">Nama Akun</p>
                                        </div>
                                        <p class="font-semibold">{{ $paymentMethod->nama_akun }}</p>
                                        <input type="hidden" name="accountName" value="Alqowy Education First">
                                    </div>
                                </div>
                                <hr class="border-2 mt-5 border-gray-500">
                            </div>
                        @endforeach
                        <p class="font-bold text-lg">Konfirmasi Pembayaran</p>
                        <div class="relative">
                            <button type="button"
                                class="p-4 rounded-full flex gap-3 w-full ring-1 ring-black transition-all duration-300 hover:ring-2 hover:ring-[#4540e1]"
                                onclick="document.getElementById('file').click()">
                                <div class="w-6 h-6 flex shrink-0">
                                    <img src="{{ asset('assets/icon/note-add.svg') }}" alt="icon">
                                </div>
                                <p id="fileLabel">Upload bukti pembayaran</p>
                            </button>
                            <input id="file" type="file" name="proof" class="hidden"
                                onchange="updateFileName(this)" required>
                        </div>
                        <input type="hidden" name="trxID" value="{{ $invoice->trx_id }}">
                        <button
                            class="p-[20px_32px] bg-[#4540e1] text-white rounded-full text-center font-semibold transition-all duration-300 hover:shadow-[0_10px_20px_0_#4540e180]">Saya
                            Sudah Bayar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Set waktu batas pembayaran
        const expiresAt = new Date("{{ $invoice->expires_at }}").getTime();

        // Update hitung mundur setiap 1 detik
        const countdownInterval = setInterval(() => {
            const now = new Date().getTime();
            const distance = expiresAt - now;

            // Hitung jam, menit, dan detik
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Tampilkan hasil
            document.getElementById("countdown").innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;

            // Jika waktu habis, hentikan interval
            if (distance < 0) {
                clearInterval(countdownInterval);
                document.getElementById("countdown").innerHTML = " - Waktu Habis";
            }
        }, 1000);
    </script>
@endsection
