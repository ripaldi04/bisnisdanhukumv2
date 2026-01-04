

<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-4xl mx-auto px-4 py-10">

        <div class="flex flex-col md:flex-row gap-8">

            <!-- Cover -->
            <div class="md:w-1/3">
                <img src="<?php echo e(asset('storage/' . $ebook->cover_image)); ?>" class="rounded-xl shadow-lg"
                    alt="<?php echo e($ebook->title); ?>">
            </div>

            <!-- Info Ebook -->
            <div class="md:w-2/3">
                <h1 class="text-3xl font-bold mb-3"><?php echo e($ebook->title); ?></h1>

                <div class="flex items-center gap-4 mb-4">
                    <span class="text-gray-600 text-sm"><?php echo e($ebook->views); ?> views</span>
                    <span class="text-gray-600 text-sm"><?php echo e($ebook->downloads); ?> downloads</span>
                </div>

                
                <?php if(!$hasPaid): ?>
                    <div class="mb-4">
                        <?php if($ebook->is_free): ?>
                            <span class="font-semibold text-xl">
                                <s class="text-red-600">Rp 129.000</s>
                                <span>discount 100%</span>
                                <div class="text-green-600">Rp 0</div>
                            </span>
                        <?php else: ?>
                            <span class="text-yellow-600 font-semibold text-xl">
                                Rp <?php echo e(number_format($ebook->price, 0, ',', '.')); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                
                <div class="mt-6 bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-700 leading-relaxed">
                        <?php echo nl2br(e($ebook->description)); ?>

                    </p>

                    
                    <div class="mt-6">
                        <?php if($ebook->is_free): ?>
                            <?php if(auth()->guard()->check()): ?>
                                <?php
                                    $waNumber = \App\Models\Setting::where('key', 'whatsapp_number')->value('value');
                                    $template = \App\Models\Setting::where('key', 'whatsapp_message_template')->value(
                                        'value',
                                    );
                                ?>

                                <?php if($waNumber && $template): ?>
                                    <?php
                                        $message = strtr($template, [
                                            '{title}' => $ebook->title,
                                            '{name}' => auth()->user()->name,
                                            '{email}' => auth()->user()->email,
                                            '{url}' => route('ebooks.show', $ebook->id),
                                        ]);

                                        $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($message);
                                    ?>

                                    <a href="<?php echo e($waLink); ?>" target="_blank"
                                        class="inline-flex bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                                        Download Now
                                    </a>
                                <?php else: ?>
                                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-lg">
                                        WhatsApp belum dikonfigurasi oleh admin (nomor / template pesan kosong).
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
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

                                            <form method="POST" action="<?php echo e(route('ebooks.claim-discount', $ebook->id)); ?>"
                                                class="space-y-4">
                                                <?php echo csrf_field(); ?>

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

                            <?php endif; ?>
                        <?php elseif($hasPaid): ?>
                            <a href="<?php echo e(route('ebooks.download', $ebook->id)); ?>"
                                class="inline-flex bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                                Download Ebook
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('ebooks.buy', $ebook->id)); ?>"
                                class="inline-flex bg-yellow-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-700 transition">
                                Beli Ebook
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Form Download Ebook (Untuk Semua Pengguna) -->
    <?php if($ebook->is_free): ?>
        <div class="max-w-4xl mx-auto px-4 py-8">
            <div class="bg-gradient-to-r from-green-50 to-blue-50 border border-green-200 rounded-xl p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Download Ebook Ini Sekarang!</h3>
                <p class="text-gray-600 mb-4">Isi form di bawah ini untuk mendapatkan link download ebook ini melalui
                    WhatsApp.</p>

                <form action="<?php echo e(route('ebooks.download-form', $ebook->id)); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
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
    <?php endif; ?>

    <!-- Ebook Lainnya -->
    <div class="max-w-7xl mx-auto px-4 py-10">
        <h2 class="text-2xl font-bold mb-6">Ebook Lainnya</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $otherEbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $otherEbook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('ebooks.show', $otherEbook->id)); ?>" class="group block">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <img src="<?php echo e(asset('storage/' . $otherEbook->cover_image)); ?>" alt="<?php echo e($otherEbook->title); ?>"
                            class="w-full h-64 object-cover object-center group-hover:scale-105 transition-transform">
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2 group-hover:text-yellow-600 transition-colors">
                                <?php echo e($otherEbook->title); ?>

                            </h3>

                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span><?php echo e($otherEbook->views); ?> views</span>
                                <span><?php echo e($otherEbook->downloads); ?> downloads</span>
                            </div>

                            <?php if($otherEbook->is_free): ?>
                                <div class="mt-2 text-green-600 font-semibold">Gratis</div>
                            <?php else: ?>
                                <div class="mt-2 text-yellow-600 font-semibold">
                                    Rp <?php echo e(number_format($otherEbook->price, 0, ',', '.')); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project coding\bisnisdanhukum\new backupan ori dari versi sebelumnya\proj\resources\views/ebooks/show.blade.php ENDPATH**/ ?>