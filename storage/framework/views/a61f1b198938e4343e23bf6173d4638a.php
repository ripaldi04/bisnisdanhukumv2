<section id="faq" class="container mx-auto px-10 lg:px-[100px] py-[70px]">
    <div class="text-center">
        <h2 class="font-bold text-[36px] leading-[52px]">Pertanyaan Umum</h2>
        <p>Simak beberapa pertanyaan-pertanyaan berikut, siapa tahu salah satunya adalah pertanyaan yang ingin Anda
            tanyakan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mt-8">
        <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div
                class="flex flex-col p-5 rounded-2xl bg-[#F5F8FA] border-t-4 border-[#D4AF37] has-[.hide]:border-0 w-full">
                <button class="accordion-button flex justify-between  gap-1 items-center"
                    data-accordion="accordion-faq-<?php echo e($loop->iteration); ?>">
                    <span class="font-semibold text-lg text-left"><?php echo e($faq->question); ?></span>
                    <div class="arrow w-9 h-9 flex shrink-0">
                        <img src="<?php echo e(asset('assets/icon/add.svg')); ?>" alt="icon">
                    </div>
                </button>
                <div id="accordion-faq-<?php echo e($loop->iteration); ?>" class="accordion-content hide">
                    <p class="leading-[30px] text-[#475466] pt-[10px]"><?php echo e($faq->answer); ?></p>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="flex flex-col space-y-3 mt-8 text-center items-center">
        <p class="font-bold text-lg">Punya pertanyaan lain?</p>
        <a href="https://wa.me/<?php echo e($course->phone); ?>?text=Halo%20Sekolah%20Marketing%20Properti,%20saya%20mau%20daftar.%20Bagaimana%20caranya?"
            target="_blank"
            class="text-white font-semibold lg:ms-0 rounded-[30px] p-[16px_32px] bg-[#D4AF37] transition-all duration-300 hover:shadow-[0_10px_20px_0_#D4AF3780] w-fit">Hubungi
            Kami</a>
    </div>
</section>
<?php /**PATH D:\project coding\bisnisdanhukum\new backupan ori dari versi sebelumnya\proj\resources\views/components/faq.blade.php ENDPATH**/ ?>