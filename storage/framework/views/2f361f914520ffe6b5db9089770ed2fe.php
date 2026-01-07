<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startSection('content'); ?>
    <div>
        
        <section id="video-content" class="w-full p-6 bg-[#F6F8FD]">
            <div class="mx-auto grid gap-5 md:grid-cols-[1fr_320px] h-auto md:h-[calc(95vh-100px)]">

                
                <div
                    class="md:order-2 order-1 md:sticky md:top-5 h-auto md:h-[calc(95vh-100px)] overflow-y-auto bg-white
                    rounded-[26px] p-5 shadow-md scrollbar-thin scrollbar-thumb-[#D4AF37]
                    scrollbar-track-[#E9EFF3]">
                    <p class="font-bold text-lg"><?php echo e($totalModules); ?> Modul dan <?php echo e($totalSubModules); ?> Materi</p>
                    <div class="flex flex-col gap-3 mt-4">
                        <a href="<?php echo e(route('learn')); ?>"
                            class="group p-3 flex items-center gap-3 bg-[#D4AF37] rounded-full
                        text-white hover:text-black hover:bg-[#E9EFF3] transition duration-300">
                            <p class="font-semibold">Video Trailer</p>
                        </a>
                        <?php $__empty_1 = true; $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="collapse collapse-arrow border-base-300 bg-[#E5E9F2] border">
                                <input type="checkbox" class="w-full" />
                                <div class="collapse-title">
                                    <p class="font-semibold"><?php echo e($module->title); ?></p>
                                </div>
                                <div class="collapse-content">
                                    <?php $__empty_2 = true; $__currentLoopData = $module->subModules->sortBy('order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subModule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <a href="<?php echo e(route('learning', ['moduleId' => $module->id, 'subModuleId' => $subModule->id])); ?>"
                                            class="group mb-4 p-[12px_16px] flex items-center gap-[10px] bg-white
                                        rounded-full hover:bg-[#D4AF37] hover:text-white transition-all duration-300">
                                            <p class="font-semibold"><?php echo e($subModule->title); ?></p>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <p>Belum ada materi yang tersedia</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p>Belum ada data course</p>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div
                    class="md:order-1 order-2 flex flex-col overflow-y-auto scrollbar-thin scrollbar-thumb-[#D4AF37]
                scrollbar-track-[#E9EFF3]">
                    <div class="plyr__video-embed w-full aspect-video rounded-[20px] relative mb-5" id="player">
                        <iframe
                            src="https://www.youtube.com/embed/<?php echo e($course->trailer); ?>?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                            allowfullscreen allowtransparency allow="autoplay">
                        </iframe>
                    </div>

                    <section id="Video-Resources" class="max-w-[1120px] w-full mx-auto">
                        <h1 class="font-extrabold text-[24px] md:text-[30px] leading-[35px] md:leading-[45px]">
                            <?php echo e($course->title); ?></h1>
                        <div class="mt-5">
                            <h3 class="font-bold text-xl md:text-2xl">Deskripsi Course</h3>
                            <p class="font-medium leading-[25px] md:leading-[30px]"><?php echo e($course->description); ?></p>
                        </div>
                    </section>
                </div>

            </div>
        </section>
    </div>


    
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project coding\bisnisdanhukum\new backupan ori dari versi sebelumnya\proj\resources\views/learn.blade.php ENDPATH**/ ?>