

<?php $__env->startSection('title', 'Edit Pengeluaran'); ?>
<?php $__env->startSection('header_title', 'Edit Pengeluaran'); ?>
<?php $__env->startSection('header_subtitle', 'Perbarui data pengeluaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?php echo e(route('pengeluaran.index')); ?>"
           class="p-2 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-slate-900 hover:bg-slate-50 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-900">Edit Pengeluaran</h1>
            <p class="text-xs text-slate-500">Perbarui data — saldo akan dihitung ulang otomatis</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
        <form action="<?php echo e(route('pengeluaran.update', $keuangan->id)); ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="tanggal" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tanggal <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggal"
                           value="<?php echo e(old('tanggal', $keuangan->tanggal->format('Y-m-d'))); ?>" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-rose-500 focus:outline-none">
                    <?php $__errorArgs = ['tanggal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-rose-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="jumlah" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Jumlah (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-bold text-slate-400">Rp</span>
                        <input type="number" name="jumlah" id="jumlah" min="1" step="1"
                               value="<?php echo e(old('jumlah', (int)$keuangan->jumlah)); ?>" required
                               class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold focus:ring-2 focus:ring-rose-500 focus:outline-none">
                    </div>
                    <?php $__errorArgs = ['jumlah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-rose-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div>
                <label for="kategori" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Kategori <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="kategori" id="kategori" list="kategori_list"
                       value="<?php echo e(old('kategori', $keuangan->kategori)); ?>" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-rose-500 focus:outline-none">
                <datalist id="kategori_list">
                    <option value="Konsumsi Kegiatan">
                    <option value="Perlengkapan & Logistik">
                    <option value="Operasional Sekretariat">
                    <option value="Sewa Tempat / Alat">
                    <option value="Santunan / Bantuan Sosial">
                    <option value="Administrasi & Percetakan">
                    <option value="Transportasi">
                    <option value="Lain-lain">
                </datalist>
                <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-rose-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="keterangan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Keterangan <span class="text-rose-500">*</span>
                </label>
                <textarea name="keterangan" id="keterangan" rows="3" required
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-rose-500 focus:outline-none"><?php echo e(old('keterangan', $keuangan->keterangan)); ?></textarea>
                <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-rose-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Ganti Bukti / Nota (Opsional)
                </label>
                <?php if($keuangan->bukti_transaksi): ?>
                <div class="mb-2">
                    <a href="<?php echo e(asset('storage/' . $keuangan->bukti_transaksi)); ?>" target="_blank"
                       class="text-xs text-rose-600 underline">Lihat bukti saat ini</a>
                </div>
                <?php endif; ?>
                <input type="file" name="bukti_transaksi" accept="image/*,application/pdf"
                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100">
                <?php $__errorArgs = ['bukti_transaksi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-xs text-rose-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="<?php echo e(route('pengeluaran.index')); ?>"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-lg shadow-rose-600/20">
                    Update Pengeluaran
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.keuangan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Kuliah\karyabhakti\resources\views/pengeluaran/edit.blade.php ENDPATH**/ ?>