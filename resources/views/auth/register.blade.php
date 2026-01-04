<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>


        <!-- No HP -->
        <div class="mt-4">
            <x-input-label for="no_hp" :value="__('Nomor Whatsapp')" />
            <x-text-input id="no_hp" class="block mt-1 w-full" type="number" name="no_hp" :value="old('no_hp')"
                required />
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
        </div>


        <!-- Social Media -->
        <div class="mt-4">
            <x-input-label for="sosial_media" :value="__('Kota / Kabupaten Tempat Tinggal')" />
            <x-text-input id="sosial_media" class="block mt-1 w-full" type="text" name="sosial_media"
                :value="old('sosial_media')" required />
            <x-input-error :messages="$errors->get('sosial_media')" class="mt-2" />
        </div>


       <!-- Password -->
<div class="mt-4">
    <x-input-label for="password" :value="__('Password')" />

    <div class="relative mt-1">
        <x-text-input id="password" class="block w-full pr-12"
            type="password" name="password" required autocomplete="new-password" />

        <button type="button"
            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700"
            onclick="togglePassword('password', 'eye-password', 'eyeoff-password')"
            aria-label="Toggle password visibility">

            {{-- eye (show) --}}
            <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7S2 12 2 12z" />
                <circle cx="12" cy="12" r="3" />
            </svg>

            {{-- eye-off (hide) --}}
            <svg id="eyeoff-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-10-8-10-8a21.83 21.83 0 0 1 5.06-6.94" />
                <path d="M1 1l22 22" />
                <path d="M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 10 8 10 8a21.83 21.83 0 0 1-4.87 6.73" />
                <path d="M14.12 14.12a3 3 0 0 1-4.24-4.24" />
            </svg>
        </button>
    </div>

    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<!-- Confirm Password -->
<div class="mt-4">
    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />

    <div class="relative mt-1">
        <x-text-input id="password_confirmation" class="block w-full pr-12"
            type="password" name="password_confirmation" required autocomplete="new-password" />

        <button type="button"
            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700"
            onclick="togglePassword('password_confirmation', 'eye-confirm', 'eyeoff-confirm')"
            aria-label="Toggle password visibility">

            {{-- eye (show) --}}
            <svg id="eye-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7S2 12 2 12z" />
                <circle cx="12" cy="12" r="3" />
            </svg>

            {{-- eye-off (hide) --}}
            <svg id="eyeoff-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-10-8-10-8a21.83 21.83 0 0 1 5.06-6.94" />
                <path d="M1 1l22 22" />
                <path d="M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 10 8 10 8a21.83 21.83 0 0 1-4.87 6.73" />
                <path d="M14.12 14.12a3 3 0 0 1-4.24-4.24" />
            </svg>
        </button>
    </div>

    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
</div>



        <!-- Referral -->
        <!--<div class="mt-4">-->
        <!--    <x-input-label for="referral_code" :value="__('Kode Referral (Opsional)')" />-->
        <!--    <x-text-input id="referral_code" class="block mt-1 w-full" type="text" name="referral_code"-->
        <!--        :value="old('referral_code', request()->query('referral'))" />-->
        <!--    <x-input-error :messages="$errors->get('referral_code')" class="mt-2" />-->
        <!--</div>-->

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Sudah punya akun? Login') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('DAFTAR') }}
            </x-primary-button>
        </div>
    </form>
    
    
    <script>
    function togglePassword(inputId, eyeId, eyeOffId) {
        const input = document.getElementById(inputId);
        const eye = document.getElementById(eyeId);
        const eyeOff = document.getElementById(eyeOffId);

        if (!input) return;

        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';

        if (eye) eye.classList.toggle('hidden', isHidden);      // kalau text -> sembunyikan eye
        if (eyeOff) eyeOff.classList.toggle('hidden', !isHidden); // kalau text -> tampilkan eyeOff
    }
</script>

</x-guest-layout>
