<footer class="bg-[#eceef9]">
    <div class="container mx-auto px-6 lg:px-20 py-10 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Column 1 -->
        <div>

            <!-- Tagline -->
            <p class="mb-4 text-lg text-justify">Bisnis dan Hukum adalah lorem ipsum dolor sit amet, consectetur
                adipiscing elit. Nam elementum ultricies dolor, sed pulvinar quam euismod quis. In condimentum lacus
                lacus, vel ornare odio dignissim vel. Quisque ut erat nulla. Phasellus quis lorem vitae ipsum tempor
                rutrum. Mauris viverra nec ex vel sodales. </p>
        </div>

        <!-- Column 2 -->
        <div class="lg:mx-auto">
            <p class="font-semibold mb-4 text-lg">Menu</p>
            <ul class="space-y-2">
                <li><a href="{{ route('pricing') }}" class="hover:text-gray-400">Harga</a></li>
                <li><a href="{{ route('ebooks.index') }}" class="hover:text-gray-400">Buku & Event</a></li>
                <li><a href="{{ route('articles.index') }}" class="hover:text-gray-400">Artikel</a></li>
                <li><a href="{{ route('learn') }}" class="hover:text-gray-400">Materi</a></li>
            </ul>
        </div>

        <!-- Column 3 -->
        <div>
            <p class="font-semibold mb-4 text-lg">Alamat</p>
            <p class="mb-4 text-sm">Maktab Square, Jl. K S Tubun No.19, RT.03/RW.02, Cibuluh, Bogor Utara, Bogor City,
                West Java 16151</p>
            <p class="text-sm">+62811959019</p>
        </div>
    </div>

    <!-- Divider -->
    <div class="border-t border-gray-700 mt-6">
        <p class="text-center text-sm py-4">© 2025 — bisnisdanhukum.com</p>
    </div>
</footer>
