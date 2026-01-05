<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="bg-white py-16 min-h-[70vh]">
        <div class="container mx-auto px-6 lg:px-20 flex flex-col lg:flex-row items-center justify-between">
            <!-- Left Side (Copywriting) -->
            <div class="text-center lg:text-left lg:w-1/2 space-y-6">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 lg:leading-snug">
                    <?php echo e($course->banner_main_text); ?>

                </h1>
                <p class="text-lg text-gray-600">
                    <?php echo e($course->banner_text); ?>

                </p>
                <a href="<?php echo e(route('learn')); ?>"
                    class="inline-block px-8 py-3 bg-[#D4AF37] text-white font-medium rounded-lg text-lg shadow-md hover:bg-yellow-700 transition">
                    Mulai Sekarang
                </a>
            </div>

            <!-- Right Side (Image/Vector) -->
            <div class="mt-8 lg:mt-0 lg:w-1/2">
                <?php
                    $illustration = $course->illustration
                        ? Storage::url($course->illustration)
                        : asset('assets/hero-vector.png');
                ?>
                <img src=<?php echo e($illustration); ?> alt="Books Illustration" class="w-full max-w-md mx-auto lg:max-w-lg">
            </div>
        </div>
    </div>
    

    
    <div class="container mx-auto">
        <div class="bg-[#f1f1fc] rounded-lg p-6 md:p-8 w-3/4 mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="flex items-center gap-6">
                    <div class="p-8 bg-white rounded-lg">
                        <svg class="size-12 text-[#57a4df]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007 2.759-.038 4.5.16 6.956.791V4.717Zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71v15.081Z"
                                clip-rule="evenodd" />
                        </svg>

                    </div>
                    <div class="flex flex-col gap-3 items-start">
                        <p class="text-5xl text-[#D4AF37] font-bold">50+</p>
                        <p class="text-xl">MODUL</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="p-8 bg-white rounded-lg">
                        <svg class="size-12 text-[#f18d46]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M6 2c-1.10457 0-2 .89543-2 2v4c0 .55228.44772 1 1 1s1-.44772 1-1V4h12v7h-2c-.5523 0-1 .4477-1 1v2h-1c-.5523 0-1 .4477-1 1s.4477 1 1 1h5c.5523 0 1-.4477 1-1V3.85714C20 2.98529 19.3667 2 18.268 2H6Z" />
                            <path
                                d="M6 11.5C6 9.567 7.567 8 9.5 8S13 9.567 13 11.5 11.433 15 9.5 15 6 13.433 6 11.5ZM4 20c0-2.2091 1.79086-4 4-4h3c2.2091 0 4 1.7909 4 4 0 1.1046-.8954 2-2 2H6c-1.10457 0-2-.8954-2-2Z" />
                        </svg>

                    </div>
                    <div class="flex flex-col gap-3 items-start">
                        <p class="text-5xl text-[#D4AF37] font-bold">10+</p>
                        <p class="text-xl">EXPERT MENTOR</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="p-8 bg-white rounded-lg">
                        <svg class="size-12 text-[#bb39c7]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z"
                                clip-rule="evenodd" />
                        </svg>

                    </div>
                    <div class="flex flex-col gap-3 items-start">
                        <p class="text-5xl text-[#D4AF37] font-bold">500+</p>
                        <p class="text-xl">MEMBERSHIP</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    
    <div class="container mx-auto px-6 lg:px-20 py-16">
        <h1 class="text-4xl font-bold py-8">Artikel Populer</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex flex-col gap-4">
                    <img src="<?php echo e(Storage::url($article->thumbnail)); ?>" alt=""
                        class="w-full rounded-lg overflow-hidden hover:scale-105 transition-all ease-in">
                    <div class="text-center mx-auto">
                        <p class="text-xl font-bold mb-2 max-w-sm"><a
                                href="<?php echo e(route('articles.show', $article->slug)); ?>"><?php echo e($article->title); ?></a></p>
                        <p class="text-center text-slate-500"><?php echo e($article->updated_at->format('d M Y')); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="text-center">
            <a href="<?php echo e(route('articles.index')); ?>"
                class="inline-block mt-12 px-8 py-3 bg-[#D4AF37] text-white font-medium rounded-lg text-lg shadow-md hover:bg-yellow-700 transition">
                Lihat Selengkapnya
            </a>
        </div>
    </div>
    

    
    <section class="py-32" id="benefit">
        <div class="container mx-auto">
            <div class="text-center">
                <h2 class="font-bold text-4xl mb-8">Apa yang Anda Dapatkan?</h2>
                <div class="flex flex-wrap justify-center gap-12">
                    <?php $__currentLoopData = $benefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex flex-col items-center space-y-3 max-w-sm">
                            <!-- Ikon -->
                            <img src="<?php echo e(Storage::url($benefit->icon)); ?>" alt="" class="icon-blue-to-gold">
                            <!-- Judul -->
                            <h3 class="font-bold text-xl"><?php echo e($benefit->title); ?></h3>
                            <!-- Deskripsi -->
                            <p class="text-gray-600"><?php echo e($benefit->description); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </section>
    


    
    <section class="py-32" id="kenapa">
        <div class="container  mx-auto text-center px-2">
            <h2 class="text-4xl font-bold mb-12 text-gray-800">Apa yang Membuat Kami Berbeda?</h2>

            <div class="grid gap-8 md:grid-cols-3">
                <?php $__currentLoopData = $uniquenesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uniqueness): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center justify-center bg-[#D4AF37] rounded-full w-16 h-16 mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-8 h-8 text-[#FFFFFF]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-4 text-gray-800"><?php echo e($uniqueness->title); ?></h3>
                        <p class="text-gray-600"><?php echo e($uniqueness->description); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    

    <?php echo $__env->make('components.testimonial', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.faq', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            slidesPerView: 3,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true, // Pagination harus bisa diklik
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                300: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                },
            },
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project coding\bisnisdanhukum\new backupan ori dari versi sebelumnya\proj\resources\views/home.blade.php ENDPATH**/ ?>