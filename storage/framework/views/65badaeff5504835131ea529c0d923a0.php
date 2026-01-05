<?php
    $data = App\Models\Course::pluck('favicon')->first();

    $favicon = $data ? Storage::url($data) : asset('assets/logo/favicon.png');
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="icon" href="<?php echo e($favicon); ?>" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <title>Bisnis dan Hukum</title>
    <?php echo $__env->yieldContent('style'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>

<body class="text-black font-poppins">
    <?php echo $__env->yieldContent('content'); ?>

    <?php if(!in_array(Route::currentRouteName(), ['checkout', 'learn', 'learning'])): ?>
        <?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php echo $__env->yieldContent('script'); ?>
    <script src="<?php echo e(asset('js/main.js')); ?>"></script>
</body>

</html>
<?php /**PATH D:\project coding\bisnisdanhukum\new backupan ori dari versi sebelumnya\proj\resources\views/layout.blade.php ENDPATH**/ ?>