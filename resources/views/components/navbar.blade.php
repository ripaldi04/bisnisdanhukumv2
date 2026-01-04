{{-- NAVBAR WRAPPER --}}
<div class="bg-base-100 sticky top-0 z-50 border-b">
    <div class="max-w-7xl mx-auto px-6 lg:px-20">
        <div class="navbar h-16 p-0">

            {{-- LEFT --}}
            <div class="navbar-start">
                <div class="dropdown lg:hidden">
                    <label tabindex="0" role="button" class="btn btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>

                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content mt-3 z-[999] p-2 shadow bg-base-100 rounded-box w-56">
                        <li><a href="{{ route('index') }}" class="font-medium">Beranda</a></li>
                        <li><a href="{{ route('pricing') }}" class="font-medium">Harga</a></li>
                        <li><a href="{{ route('ebooks.index') }}" class="font-medium">E-Books</a></li>
                        <li><a href="{{ route('events.index') }}" class="font-medium">Events</a></li>
                        <li><a href="{{ route('live-courses.index') }}" class="font-medium">Live Course</a></li>
                        <li><a href="{{ route('articles.index') }}" class="font-medium">Artikel</a></li>
                        <li><a href="#faq" class="font-medium">FAQ</a></li>

                        <div class="my-2 border-t"></div>

                        @auth
                            <li><a href="{{ route('dashboard') }}" class="font-medium">Dashboard</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left font-medium">Logout</button>
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>


                <a href="{{ route('index') }}" class="flex items-center">
                    <img src="{{ asset('assets/logo/logo-no-bg.png') }}" alt="Bisnis Hukum"
                        class="block h-26 w-auto object-contain">
                </a>
            </div>

            {{-- CENTER --}}
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal gap-2">
                    <li><a href="{{ route('index') }}">Beranda</a></li>
                    <li><a href="{{ route('pricing') }}">Harga</a></li>
                    <li><a href="{{ route('ebooks.index') }}">E-Books</a></li>
                    <li><a href="{{ route('events.index') }}">Events</a></li>
                    <li><a href="{{ route('live-courses.index') }}">Live Course</a></li>
                    <li><a href="{{ route('articles.index') }}">Artikel</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>

            {{-- RIGHT --}}
            <div class="navbar-end gap-4">

                @guest
                    <a href="{{ route('login') }}" class="font-medium text-[#D4AF37]">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-[#D4AF37] text-white font-medium px-5 py-2 rounded-lg">
                        Daftar
                    </a>
                @endguest

                @auth
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="flex items-center gap-3 cursor-pointer">
                            <div class="text-right">
                                <p class="font-semibold text-sm">
                                    Hi, {{ auth()->user()->name }}
                                </p>
                            </div>
                            <div class="w-9 h-9 rounded-full overflow-hidden border border-[#D4AF37]">
                                <img src="{{ asset('assets/people.png') }}" class="w-full h-full object-cover">
                            </div>
                        </label>

                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-44 p-2 shadow">
                            <li>
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth

            </div>
        </div>
    </div>
</div>
