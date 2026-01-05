<section id="testimonial"
    class="container  mx-auto flex flex-col justify-end py-[70px] px-[50px] gap-[30px] bg-[#F5F8FA] rounded-[32px]">
    <div class="flex flex-col text-center">
        <h2 class="font-bold text-4xl leading-[60px]">Apa Kata Mereka?</h2>
        <p class="text-[#6D7786] text-lg -tracking-[2%]">Mendapatkan peluang baru dan meningkatkan kemampuan kini
            lebih terjangkau bagi siapa saja</p>
    </div>
    <div class="swiper overflow-hidden max-w-full">
        <!-- Wrapper -->
        <div class="swiper-wrapper">
            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide flex flex-col items-center space-y-4 p-6 bg-white rounded-lg shadow-md">
                    <img
                        src="<?php echo e($testimonial->avatar ? Storage::url($testimonial->avatar) : asset('assets/people.png')); ?>" class="w-24">
                    <h3 class="font-bold text-lg mb-0"><?php echo e($testimonial->name); ?></h3>
                    <p class="text-md font-semibold"><?php echo e($testimonial->occupation); ?></p>
                    <?php if($testimonial->type == 'Text'): ?>
                        <p class="text-gray-600 text-center">"<?php echo e($testimonial->content); ?>"</p>
                    <?php else: ?>
                        <video controls class="w-full h-auto">
                            <source src="<?php echo e(Storage::url($testimonial->content)); ?>" type="video/mp4">
                        </video>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <!-- Pagination -->
        <div class="swiper-pagination mt-10"></div>
    </div>

</section>
<?php /**PATH D:\project coding\bisnisdanhukum\new backupan ori dari versi sebelumnya\proj\resources\views/components/testimonial.blade.php ENDPATH**/ ?>