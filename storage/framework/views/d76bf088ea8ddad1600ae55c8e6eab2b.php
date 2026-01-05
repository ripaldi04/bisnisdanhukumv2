

<?php $__env->startSection('content'); ?>
    <div class="max-w-3xl mx-auto px-4 py-10">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900">
                Koleksi Ebook Terbaik untuk Bisnis dan Hukum
            </h1>
            <p class="text-slate-600 mt-3">
                Baca dari atas, pilih ebook, lalu lanjut detail untuk klaim / beli.
            </p>
        </div>

        
        <div class="space-y-10">
            <?php $__empty_1 = true; $__currentLoopData = $ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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

                        
                        

                        
                        
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-center text-slate-500">Tidak ada ebook tersedia saat ini.</p>
            <?php endif; ?>
        </div>

        <form id="order-form" method="POST" action="/ebooks/<?php echo e($ebooks->first()->id ?? 0); ?>/download-form"
            class="space-y-6 mt-10">
            <?php echo csrf_field(); ?>

            
            <div class="space-y-2">
                <h3 class="text-sm font-extrabold text-slate-900">Pilih Ebook:</h3>

                <?php $__currentLoopData = $ebooks->where('is_free', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="block" data-title="<?php echo e($ebook->title); ?>"
                        data-desc="<?php echo e(Str::limit(strip_tags($ebook->description), 80)); ?>" data-price="<?php echo e($ebook->price); ?>"
                        data-free="1">
                        <div class="flex gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4">
                            <input type="radio" name="ebook_id" value="<?php echo e($ebook->id); ?>"
                                <?php echo e($loop->first ? 'checked' : ''); ?> class="mt-1 h-4 w-4 text-blue-600">

                            <div class="flex-1">
                                <div class="flex items-start gap-3">
                                    
                                    <img src="<?php echo e(asset('storage/' . $ebook->cover_image)); ?>" alt="<?php echo e($ebook->title); ?>"
                                        class="w-12 h-16 object-cover rounded-md ring-1 ring-slate-200">

                                    <div class="space-y-1">
                                        <div class="text-xs font-extrabold text-slate-900 uppercase">
                                            <?php echo e($ebook->title); ?>

                                        </div>

                                        <div class="text-xs text-slate-600">
                                            <?php echo e(Str::limit(strip_tags($ebook->description), 120)); ?>

                                        </div>

                                        <div class="text-xs text-blue-700 font-semibold">
                                            Gratis
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="space-y-3">
                <h3 class="text-sm font-extrabold text-slate-900">Lengkapi Data</h3>

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
                            🇮🇩 +62
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
                    <label class="text-xs font-semibold text-slate-700">Email <span class="text-rose-600">*</span></label>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project coding\bisnisdanhukum\new backupan ori dari versi sebelumnya\proj\resources\views/landing.blade.php ENDPATH**/ ?>