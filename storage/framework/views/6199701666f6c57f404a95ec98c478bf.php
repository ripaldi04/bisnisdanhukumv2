<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startSection('content'); ?>
    <div class="max-w-6xl mx-auto py-10">

        <h1 class="text-3xl font-bold mb-6">Daftar Ebook</h1>

        <!-- Grid Ebook -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">

            <?php $__empty_1 = true; $__currentLoopData = $ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition flex flex-col">

                    <!-- Cover -->
                    <div class="relative w-full aspect-[2/3] overflow-hidden rounded-t-lg">
                        <img src="<?php echo e(asset('storage/' . $ebook->cover_image)); ?>" alt="<?php echo e($ebook->title); ?>"
                            class="w-full h-full object-cover">
                    </div>

                    <!-- Content -->
                    <div class="p-3 flex flex-col flex-1">

                        <h2 class="text-sm font-semibold leading-snug line-clamp-2">
                            <?php echo e($ebook->title); ?>

                        </h2>

                        <p class="mt-1 text-sm font-bold text-yellow-600">
                            <?php if($ebook->is_free): ?>
<span class="font-semibold">
            <s class="text-red-600">Rp 129.000</s>
            <span>discount 100%</span>
            <div class="text-green-600">Rp 0</div>
        </span>                            <?php else: ?>
                                Rp <?php echo e(number_format($ebook->price, 0, ',', '.')); ?>

                            <?php endif; ?>
                        </p>

                        <div class="flex-grow"></div>

                        <a href="<?php echo e(route('ebooks.show', $ebook->id)); ?>"
                            class="mt-3 inline-flex items-center justify-center bg-[#D4AF37] hover:bg-[#c9a633] text-white text-xs px-3 py-2 rounded-md transition">
                            Lihat Detail
                        </a>

                    </div>
                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-600">Belum ada ebook tersedia.</p>
            <?php endif; ?>

        </div>



        <!-- Pagination -->
        <div class="mt-8">
            <?php echo e($ebooks->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project coding\bisnisdanhukum\new backupan ori dari versi sebelumnya\proj\resources\views/ebooks/index.blade.php ENDPATH**/ ?>