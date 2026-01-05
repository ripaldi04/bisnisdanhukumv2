<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="<?php echo e(env('MIDTRANS_CLIENT_KEY')); ?>"></script>
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

                </div>

            </div>
        </div>

    </div>

    <!-- Form Download Ebook (Untuk Semua Pengguna) -->
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-gradient-to-r from-green-50 to-blue-50 border border-green-200 rounded-xl p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <?php if($ebook->is_free): ?>
                    Download Ebook Ini Sekarang!
                <?php else: ?>
                    Download Ebook Ini Sekarang!
                <?php endif; ?>
            </h3>
            <p class="text-gray-600 mb-4">
                <?php if($ebook->is_free): ?>
                    Isi form di bawah ini untuk mendapatkan link download ebook ini melalui WhatsApp.
                <?php else: ?>
                    Isi form di bawah ini untuk melanjutkan pembelian ebook ini. Setelah pembayaran berhasil, Anda bisa
                    langsung download ebook.
                <?php endif; ?>
            </p>

            <?php if($ebook->is_free): ?>
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
                        class="w-full bg-yellow-600 text-white py-3 rounded-lg hover:bg-yellow-700 transition-colors font-semibold">
                        Download Now
                    </button>
                    <p class="text-xs text-gray-500 text-center">Dengan mengklik tombol di atas, Anda setuju bahwa data Anda
                        akan disimpan untuk proses download.</p>
                </form>
            <?php else: ?>
                <?php if($errors->any()): ?>
                    <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg mb-4">
                        <ul class="list-disc list-inside">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg mb-4">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <form id="purchase-form" action="<?php echo e(route('ebooks.purchase-form', $ebook->id)); ?>" method="POST"
                    class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" required
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                placeholder="Masukkan nama Anda" value="<?php echo e(old('name')); ?>">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" required
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                placeholder="contoh@email.com" value="<?php echo e(old('email')); ?>">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp" required
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                            placeholder="Masukkan nomor whatsApp aktif" value="<?php echo e(old('whatsapp')); ?>">
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
            <?php endif; ?>
        </div>
    </div>

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
                                window.location.href = '<?php echo e(route('ebooks.show', $ebook->id)); ?>';
                            },
                            onPending: function(result) {
                                alert("Menunggu pembayaran!");
                                window.location.href = '<?php echo e(route('ebooks.show', $ebook->id)); ?>';
                            },
                            onError: function(result) {
                                alert("Pembayaran gagal!");
                                window.location.href = '<?php echo e(route('ebooks.show', $ebook->id)); ?>';
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project coding\bisnisdanhukum\new backupan ori dari versi sebelumnya\proj\resources\views/ebooks/show.blade.php ENDPATH**/ ?>