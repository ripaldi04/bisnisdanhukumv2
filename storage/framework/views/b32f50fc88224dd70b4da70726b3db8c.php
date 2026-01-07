<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Membership Status -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">Membership Status</h3>
                <p class="mt-2">
                    <?php echo e($membershipStatus ? 'Active' : 'Inactive'); ?>

                    <?php if($membershipStatus): ?>
                        <span class="text-gray-600"> (Expires on: <?php echo e($membershipExpiry->format('d M Y H:i')); ?>) </span>
                    <?php endif; ?>
                </p>
            </div>

            <!-- Referral Information -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">Kode Referral Anda</h3>
                <p class="mt-2">Gunakan kode referral ini untuk mengundang orang lain. Jika ada user yang berhasil
                    mendaftar dan menjadi member menggunakan kode referral Anda, maka Anda akan mendapatkan komisi
                    sebesar <?php echo e($referralPercentage); ?>% dari total pembayaran membership mereka.</p>
                <div class="flex items-center mt-4">
                    <input id="referralCode" type="text" value="<?php echo e($user->referral_code); ?>" readonly
                        class="w-full px-4 py-2 border rounded-l-md bg-gray-100 text-gray-700">
                    <button onclick="copyReferralCode()"
                        class="px-4 py-2 bg-yellow-500 text-white rounded-r-md hover:bg-yellow-600">Copy</button>
                </div>
                <p class="mt-4 text-gray-600">Atau bagikan tautan berikut:</p>
                <div class="flex items-center mt-2">
                    <input id="referralLink" type="text"
                        value="<?php echo e(url('/register?referral=' . $user->referral_code)); ?>" readonly
                        class="w-full px-4 py-2 border rounded-l-md bg-gray-100 text-gray-700">
                    <button onclick="copyReferralLink()"
                        class="px-4 py-2 bg-green-500 text-white rounded-r-md hover:bg-green-600">Copy Link</button>
                </div>
            </div>

            <!-- Transaction History -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">Transaction History</h3>
                <?php if($transactions->isEmpty()): ?>
                    <p class="mt-2 text-gray-600">No transactions found.</p>
                <?php else: ?>
                    <table class="min-w-full bg-white border mt-4">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Transaction ID</th>
                                <th class="border px-4 py-2">Amount</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="border px-4 py-2"><?php echo e($transaction->trx_id); ?></td>
                                    <td class="border px-4 py-2">
                                        <?php echo e(number_format($transaction->total_amount, 0, ',', '.')); ?></td>
                                    <td class="border px-4 py-2"><?php echo e($transaction->status); ?></td>
                                    <td class="border px-4 py-2"><?php echo e($transaction->created_at->format('d M Y H:i')); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <!-- Form Pencairan Komisi -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">Pencairan Komisi</h3>
                <?php if(session('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline"><?php echo e($errors->first()); ?></span>
                    </div>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('commissions.withdraw')); ?>" class="mt-4">
                    <?php echo csrf_field(); ?>
                    <div class="mb-4">
                        <label for="nama_bank" class="block text-sm font-medium text-gray-700">Nama Bank</label>
                        <input type="text" name="nama_bank" id="nama_bank" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label for="nama_rekening" class="block text-sm font-medium text-gray-700">Nama Rekening</label>
                        <input type="text" name="nama_rekening" id="nama_rekening" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label for="nomor_rekening" class="block text-sm font-medium text-gray-700">Nomor
                            Rekening</label>
                        <input type="text" name="nomor_rekening" id="nomor_rekening" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <button type="submit"
                        class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Ajukan
                        Pencairan</button>
                </form>
            </div>


            <!-- Table Komisi Referral -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mt-6">
                <h3 class="font-semibold text-lg">Riwayat Komisi Referral</h3>
                <?php if($commissions->isEmpty()): ?>
                    <p class="mt-2 text-gray-600">Belum ada riwayat komisi.</p>
                <?php else: ?>
                    <table class="min-w-full bg-white border mt-4">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Tanggal</th>
                                <th class="border px-4 py-2">Nama Pengguna Referral</th>
                                <th class="border px-4 py-2">Jumlah (Rp)</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Bukti Pencairan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="border px-4 py-2"><?php echo e($commission->created_at->format('d M Y H:i')); ?>

                                    </td>
                                    <td class="border px-4 py-2"><?php echo e($commission->referredUser->name); ?></td>
                                    <td class="border px-4 py-2"><?php echo e(number_format($commission->amount, 0, ',', '.')); ?>

                                    </td>
                                    <td class="border px-4 py-2">
                                        <span
                                            class="px-2 py-1 text-sm font-medium rounded-md 
                                <?php if($commission->status === 'Pending'): ?> bg-yellow-200 text-yellow-800 
                                <?php elseif($commission->status === 'Not Submitted'): ?> bg-slate-100 text-slate-600 
                                <?php elseif($commission->status === 'Success'): ?> bg-green-200 text-green-800 
                                <?php else: ?> bg-red-200 text-red-800 <?php endif; ?>">
                                            <?php echo e($commission->status); ?>

                                        </span>
                                    </td>
                                    <td class="border px-4 py-2 text-center">
                                        <?php if($commission->proof): ?>
                                            <a href="<?php echo e(Storage::url($commission->proof)); ?>" target="_blank"
                                                class="text-yellow-600 hover:underline">Lihat Bukti</a>
                                        <?php else: ?>
                                            <span class="text-gray-500">Belum diunggah</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <!-- Referred Users -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg">Referred Users</h3>
                <?php if($referredUsers->isEmpty()): ?>
                    <p class="mt-2 text-gray-600">Belum ada user yang menggunakan kode referral Anda.</p>
                <?php else: ?>
                    <table class="min-w-full bg-white border mt-4">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Name</th>
                                <th class="border px-4 py-2">Email</th>
                                <th class="border px-4 py-2">Membership Status</th>
                                <th class="border px-4 py-2">Joined At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $referredUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="border px-4 py-2"><?php echo e($user->name); ?></td>
                                    <td class="border px-4 py-2"><?php echo e($user->email); ?></td>
                                    <td class="border px-4 py-2">
                                        <?php echo e($user->hasActiveSubscription() ? 'Active' : 'Inactive'); ?>

                                    </td>
                                    <td class="border px-4 py-2"><?php echo e($user->created_at->format('d M Y H:i')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function copyReferralCode() {
            const code = document.getElementById('referralCode');
            code.select();
            code.setSelectionRange(0, 99999);
            document.execCommand('copy');
            alert('Kode referral berhasil disalin!');
        }

        function copyReferralLink() {
            const link = document.getElementById('referralLink');
            link.select();
            link.setSelectionRange(0, 99999);
            document.execCommand('copy');
            alert('Tautan referral berhasil disalin!');
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH D:\project coding\bisnisdanhukum\new backupan ori dari versi sebelumnya\proj\resources\views/dashboard.blade.php ENDPATH**/ ?>