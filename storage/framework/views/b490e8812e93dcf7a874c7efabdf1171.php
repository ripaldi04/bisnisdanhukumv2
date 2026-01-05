<?php $__env->startSection('style'); ?>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="<?php echo e(env('MIDTRANS_CLIENT_KEY')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-2xl mx-auto px-4 py-10">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Checkout Ebook</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="font-semibold text-lg"><?php echo e($ebook->title); ?></h3>
                    <p class="text-gray-600">Harga: Rp <?php echo e(number_format($ebook->price, 0, ',', '.')); ?></p>
                </div>
                <div class="text-right">
                    <span class="text-yellow-600 font-bold text-xl">Total: Rp
                        <?php echo e(number_format($trx->amount, 0, ',', '.')); ?></span>
                </div>
            </div>

            <div class="border-t pt-6">
                <p class="text-sm text-gray-600 mb-4">
                    Silakan klik tombol di bawah untuk melanjutkan ke pembayaran melalui Midtrans.
                </p>

                <button id="pay-button"
                    class="w-full bg-yellow-600 text-white py-3 rounded-lg hover:bg-yellow-700 transition-colors font-semibold">
                    Bayar Sekarang
                </button>

                <p class="text-xs text-gray-500 text-center mt-2">
                    Pembayaran aman melalui Midtrans
                </p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('pay-button').onclick = function() {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('<?php echo e($snapToken); ?>', {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    alert("Pembayaran berhasil!");
                    window.location.href = '<?php echo e(route('ebooks.show', $ebook->id)); ?>';
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    alert("Menunggu pembayaran!");
                    window.location.href = '<?php echo e(route('ebooks.show', $ebook->id)); ?>';
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("Pembayaran gagal!");
                    window.location.href = '<?php echo e(route('ebooks.show', $ebook->id)); ?>';
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('Halaman dibuka tanpa menyelesaikan pembayaran');
                }
            });
        };
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project coding\bisnisdanhukum\new backupan ori dari versi sebelumnya\proj\resources\views/ebooks/checkout.blade.php ENDPATH**/ ?>