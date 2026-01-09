

<?php $__env->startSection('style'); ?>
    <link rel="icon" href="<?php echo e(asset('assets/logo/favicon.png')); ?>" type="image/x-icon" />
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
                            <span class="downloads-count"><?php echo e($ebook->downloads); ?> downloads</span>
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
                class="space-y-6 mt-10" onsubmit="handleDownload(event)">
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
                    class="w-full px-4 py-3 bg-yellow-500 text-white font-bold rounded-lg hover:bg-yellow-600 transition">
                    Download Now
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
                    class="w-full px-4 py-3 bg-yellow-500 text-white font-bold rounded-lg hover:bg-yellow-600 transition">
                    Beli Sekarang
                </button>

                <p class="text-[10px] text-slate-500 text-center leading-relaxed">
                    Dengan melanjutkan, Anda setuju dengan ketentuan layanan yang berlaku.
                </p>
            </form>
        <?php endif; ?>
    </div>

    <?php
        $waNumber = App\Models\Setting::where('key', 'whatsapp_number')->value('value');
    ?>

    <a href="<?php echo e($waNumber ? 'https://wa.me/' . $waNumber : '#'); ?>" <?php echo e($waNumber ? 'target="_blank"' : ''); ?>

        onclick="<?php echo e(!$waNumber ? 'alert(\'Admin belum mengatur nomor WhatsApp\'); return false;' : ''); ?>"
        style="position: fixed; bottom: 20px; right: 20px; background: #25D366; color: white; padding: 12px 16px; border-radius: 50px; text-decoration: none; font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.2); z-index: 1000; display: flex; align-items: center; gap: 8px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"
                fill="white" />
        </svg>
        Tanya Admin
    </a>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const descriptionDiv = document.querySelector('.text-slate-600.prose');
            if (descriptionDiv) {
                const headers = descriptionDiv.querySelectorAll('h1, h2');
                headers.forEach((header, index) => {
                    if (index % 2 === 0) { // Odd headers: 1st, 3rd, 5th (0-based: 0,2,4)
                        const wrapper = document.createElement('div');
                        wrapper.className = 'text-center mb-2';
                        const button = document.createElement('button');
                        button.textContent = 'Download Now';
                        button.className =
                            'px-4 py-2 bg-yellow-500 text-white font-bold rounded-lg hover:bg-yellow-600 transition';
                        button.onclick = function() {
                            const form = document.getElementById('order-form') || document
                                .getElementById('purchase-form');
                            if (form) {
                                form.scrollIntoView({
                                    behavior: 'smooth'
                                });
                            }
                        };
                        wrapper.appendChild(button);
                        header.insertAdjacentElement('beforebegin', wrapper);
                    }
                });
            }
        });

        function handleDownload(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update download count on page
                        const downloadElement = document.querySelector('.downloads-count');
                        if (downloadElement) {
                            const currentCount = parseInt(downloadElement.textContent);
                            downloadElement.textContent = currentCount + 1;
                        }
                        // Redirect to WhatsApp
                        window.location.href = data.whatsapp_url;
                    } else {
                        alert(data.message || 'Terjadi kesalahan saat memproses download.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses permintaan.');
                });
        }

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