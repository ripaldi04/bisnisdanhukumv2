<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .hero-swiper .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.7);
            opacity: 1;
        }

        .hero-swiper .swiper-pagination-bullet-active {
            background: #D4AF37;
        }

        .hero-swiper .swiper-button-next,
        .hero-swiper .swiper-button-prev {
            color: #D4AF37;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-top: -25px;
        }

        .hero-swiper .swiper-button-next:after,
        .hero-swiper .swiper-button-prev:after {
            font-size: 18px;
        }

        .hero-swiper {
            padding: 40px 0;
        }

        .hero-swiper .swiper-slide {
            max-width: 1100px;
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            transform: scale(0.9);
            transition: all 0.3s ease;
        }

        .hero-swiper .swiper-slide-active {
            transform: scale(1);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
    
    <section class="relative overflow-hidden">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="swiper-slide">
                        <div class="flex justify-center items-center bg-white rounded-lg overflow-hidden">
                            <img src="<?php echo e($banner->image ? Storage::url($banner->image) : asset('assets/Banner Website.webp')); ?>"
                                alt="Banner" class="w-auto h-auto max-w-full max-h-full object-contain">
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="swiper-pagination"></div>

            
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

    
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="swiper ebooks-swiper">
                <div class="swiper-wrapper">
                    <?php $__currentLoopData = $ebooks ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                            <a href="<?php echo e(route('ebooks.show', $ebook->id)); ?>" class="flex justify-center items-center">
                                <img src="<?php echo e(Storage::url($ebook->cover_image)); ?>" alt="<?php echo e($ebook->title); ?>"
                                    class="w-auto h-auto max-w-full max-h-full object-contain rounded-lg shadow-md hover:shadow-lg transition-shadow hover:scale-105">
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="swiper-pagination mt-6"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>

    
    
    

    
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
    

    
    <!--<?php echo $__env->make('components.faq', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>-->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Hero Carousel
        const heroSwiper = new Swiper('.hero-swiper', {
            loop: true,
            centeredSlides: true,
            slidesPerView: 1.1,
            spaceBetween: 30,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 1.3,
                },
                1024: {
                    slidesPerView: 1.6,
                },
            },
        });


        // Ebooks Carousel
        const ebooksSwiper = new Swiper('.ebooks-swiper', {
            loop: true,
            slidesPerView: 2,
            spaceBetween: 15,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                },
                1280: {
                    slidesPerView: 4
                },
            },
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project coding\bisnisdanhukum\new backupan ori dari versi sebelumnya\proj\resources\views/home.blade.php ENDPATH**/ ?>