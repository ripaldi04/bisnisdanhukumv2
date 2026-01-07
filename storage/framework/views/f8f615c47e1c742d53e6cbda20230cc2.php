

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

<?php $__env->startSection('content'); ?>
    <div class="max-w-3xl mx-auto px-4 py-10">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900">
                <?php echo e($ebook->title); ?>

            </h1>
            <p class="text-slate-600 mt-3">
                Ebook Terbaik untuk Bisnis dan Hukum
            </p>
        </div>

        
        <div class="space-y-10">
            <article class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                
                <div class="bg-gradient-to-b from-slate-900 to-slate-700 px-6 py-10 flex justify-center">
                    <img src="<?php echo e(asset('storage/' . $ebook->cover_image)); ?>" alt="<?php echo e($ebook->title); ?>"
                        class="w-64 md:w-72 aspect-[3/4] object-cover rounded-xl shadow-2xl ring-1 ring-white/10"
                        loading="lazy">
                </div>

                <div class="p-6 md:p-8 space-y-6">
                    
                    <div class="text-center space-y-3">
                        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-tight">
                            <?php echo e($ebook->title); ?>

                        </h2>

                        <div class="text-slate-600 prose prose-slate max-w-none text-left">
                            <?php echo $ebook->landingDescription->description ?? $ebook->description; ?>

                        </div>
                    </div>

                    
                    <div class="flex items-center justify-between text-sm text-slate-500">
                        <div class="flex items-center gap-3">
                            <span><?php echo e($ebook->views); ?> views</span>
                            <span>•</span>
                            <span><?php echo e($ebook->downloads); ?> downloads</span>
                        </div>

                        <?php if($ebook->is_free): ?>
                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-semibold">
                                Gratis
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 font-semibold">
                                Rp <?php echo e(number_format($ebook->price, 0, ',', '.')); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        </div>

        
        <?php if($ebook->is_free): ?>
            <form id="order-form" method="POST" action="<?php echo e(route('ebooks.download-form', $ebook->id)); ?>"
                class="space-y-6 mt-10">
                <?php echo csrf_field(); ?>

                
                <div class="space-y-3">
                    <h3 class="text-sm font-extrabold text-slate-900">Lengkapi Data untuk Download Gratis</h3>

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-slate-700">Nama Lengkap <span
                                class="text-rose-600">*</span></label>
                        <input type="text" name="name" required value="<?php echo e(old('name')); ?>"
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs text-rose-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-slate-700">No. WhatsApp <span
                                class="text-rose-600">*</span></label>
                        <div class="flex">
                            <span
                                class="inline-flex items-center rounded-l-md border border-slate-300 bg-slate-100 px-3 text-sm text-slate-700">
                                +62
                            </span>
                            <input type="text" name="whatsapp" required value="<?php echo e(old('whatsapp')); ?>"
                                placeholder="812xxxxxxx"
                                class="w-full rounded-r-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <?php $__errorArgs = ['whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs text-rose-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-slate-700">Email <span
                                class="text-rose-600">*</span></label>
                        <input type="email" name="email" required value="<?php echo e(old('email')); ?>"
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs text-rose-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <button id="order-button" type="submit"
                    style="background:#1d4ed8;color:#fff;padding:12px;border-radius:10px;width:100%;font-weight:800;">
                    Download Gratis
                </button>

                <p class="text-[10px] text-slate-500 text-center leading-relaxed">
                    Dengan melanjutkan, Anda setuju dengan ketentuan layanan yang berlaku.
                </p>
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
                class="space-y-6 mt-10">
                <?php echo csrf_field(); ?>

                
                <div class="space-y-3">
                    <h3 class="text-sm font-extrabold text-slate-900">Lengkapi Data untuk Pembelian</h3>

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-slate-700">Nama Lengkap <span
                                class="text-rose-600">*</span></label>
                        <input type="text" name="name" required value="<?php echo e(old('name')); ?>"
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs text-rose-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-slate-700">No. WhatsApp <span
                                class="text-rose-600">*</span></label>
                        <div class="flex">
                            <span
                                class="inline-flex items-center rounded-l-md border border-slate-300 bg-slate-100 px-3 text-sm text-slate-700">
                                +62
                            </span>
                            <input type="text" name="whatsapp" required value="<?php echo e(old('whatsapp')); ?>"
                                placeholder="812xxxxxxx"
                                class="w-full rounded-r-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <?php $__errorArgs = ['whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs text-rose-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-slate-700">Email <span
                                class="text-rose-600">*</span></label>
                        <input type="email" name="email" required value="<?php echo e(old('email')); ?>"
                            class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs text-rose-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <button id="order-button" type="submit"
                    style="background:#1d4ed8;color:#fff;padding:12px;border-radius:10px;width:100%;font-weight:800;">
                    Beli Sekarang
                </button>

                <p class="text-[10px] text-slate-500 text-center leading-relaxed">
                    Dengan melanjutkan, Anda setuju dengan ketentuan layanan yang berlaku.
                </p>
            </form>
        <?php endif; ?>
    </div>

    <script>
        <?php if(!$ebook->is_free): ?>
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
                                    window.location.href =
                                    '<?php echo e(route('ebooks.show', $ebook->id)); ?>';
                                },
                                onPending: function(result) {
                                    alert("Menunggu pembayaran!");
                                    window.location.href =
                                    '<?php echo e(route('ebooks.show', $ebook->id)); ?>';
                                },
                                onError: function(result) {
                                    alert("Pembayaran gagal!");
                                    window.location.href =
                                    '<?php echo e(route('ebooks.show', $ebook->id)); ?>';
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
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project coding\bisnisdanhukum\new backupan ori dari versi sebelumnya\proj\resources\views/ebooks/landing.blade.php ENDPATH**/ ?>