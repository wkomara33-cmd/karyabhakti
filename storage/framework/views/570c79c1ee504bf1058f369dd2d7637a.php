

<?php $__env->startSection('title', 'Pemasukan'); ?>
<?php $__env->startSection('header_title', 'Pemasukan'); ?>
<?php $__env->startSection('header_subtitle', 'Daftar seluruh data pemasukan organisasi'); ?>

<?php $__env->startSection('header_actions'); ?>
<?php if(auth()->user()->isAdmin()): ?>
<a href="<?php echo e(route('pemasukan.create')); ?>"
   class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
    Tambah Pemasukan
</a>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div class="bg-gradient-to-br from-emerald-600 to-teal-700 text-white rounded-2xl p-6 shadow-lg">
            <p class="text-xs font-bold uppercase tracking-widest text-emerald-100 mb-3">Total Pemasukan Keseluruhan</p>
            <p class="text-3xl font-black">Rp <?php echo e(number_format($totalAll, 0, ',', '.')); ?></p>
            <p class="text-xs text-emerald-100 mt-2">Akumulasi semua pemasukan</p>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">
                <?php if($startDate || $endDate): ?> Periode Terpilih <?php else: ?> Total Keseluruhan <?php endif; ?>
            </p>
            <p class="text-3xl font-black text-emerald-600">Rp <?php echo e(number_format($totalPeriode, 0, ',', '.')); ?></p>
            <p class="text-xs text-slate-400 mt-2">
                <?php if($startDate && $endDate): ?> <?php echo e(\Carbon\Carbon::parse($startDate)->isoFormat('D MMM Y')); ?> – <?php echo e(\Carbon\Carbon::parse($endDate)->isoFormat('D MMM Y')); ?>

                <?php elseif($startDate): ?> Mulai <?php echo e(\Carbon\Carbon::parse($startDate)->isoFormat('D MMM Y')); ?>

                <?php elseif($endDate): ?> Sampai <?php echo e(\Carbon\Carbon::parse($endDate)->isoFormat('D MMM Y')); ?>

                <?php else: ?> Semua periode <?php endif; ?>
            </p>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <form method="GET" action="<?php echo e(route('pemasukan.index')); ?>" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="<?php echo e($startDate); ?>"
                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="<?php echo e($endDate); ?>"
                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Kategori</label>
                <select name="kategori" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <option value="all">Semua Kategori</option>
                    <?php $__currentLoopData = $kategoriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($kat); ?>" <?php echo e($kategori === $kat ? 'selected' : ''); ?>><?php echo e($kat); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Cari Keterangan</label>
                <input type="text" name="search" value="<?php echo e($search); ?>" placeholder="Ketik kata kunci..."
                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl transition-colors">
                    Filter
                </button>
                <a href="<?php echo e(route('pemasukan.index')); ?>" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors" title="Reset">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </a>
            </div>
        </form>
    </div>

    
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="py-3.5 px-5">Tanggal</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Keterangan</th>
                        <th class="py-3.5 px-4 text-right">Jumlah</th>
                        <th class="py-3.5 px-4">Dicatat Oleh</th>
                        <?php if(auth()->user()->isAdmin()): ?>
                        <th class="py-3.5 px-5 text-center">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-emerald-50/30 transition-colors">
                        <td class="py-3.5 px-5 text-xs font-semibold text-slate-700 whitespace-nowrap">
                            <?php echo e($item->tanggal->isoFormat('D MMM Y')); ?>

                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                <?php echo e($item->kategori); ?>

                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-xs text-slate-700 max-w-xs">
                            <p class="line-clamp-2"><?php echo e($item->keterangan); ?></p>
                            <?php if($item->bukti_transaksi): ?>
                            <a href="<?php echo e(asset('storage/' . $item->bukti_transaksi)); ?>" target="_blank"
                               class="inline-flex items-center gap-1 text-[10px] text-emerald-600 hover:text-emerald-700 mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                Lihat Bukti
                            </a>
                            <?php endif; ?>
                        </td>
                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                            <span class="font-black text-sm text-emerald-600">
                                + Rp <?php echo e(number_format($item->jumlah, 0, ',', '.')); ?>

                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-xs text-slate-500 whitespace-nowrap">
                            <?php echo e($item->user->name ?? 'Sistem'); ?>

                        </td>
                        <?php if(auth()->user()->isAdmin()): ?>
                        <td class="py-3.5 px-5 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="<?php echo e(route('pemasukan.edit', $item->id)); ?>"
                                   class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="<?php echo e(route('pemasukan.destroy', $item->id)); ?>" method="POST"
                                      onsubmit="return confirm('Hapus data pemasukan ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="<?php echo e(auth()->user()->isAdmin() ? 6 : 5); ?>" class="py-12 text-center text-slate-400">
                            <svg class="w-10 h-10 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                            <p class="font-semibold text-slate-500">Belum ada data pemasukan</p>
                            <?php if(auth()->user()->isAdmin()): ?>
                            <a href="<?php echo e(route('pemasukan.create')); ?>" class="mt-2 inline-block text-xs text-emerald-600 font-semibold hover:underline">+ Tambah sekarang</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($data->hasPages()): ?>
        <div class="p-4 border-t border-slate-100 bg-slate-50/50"><?php echo e($data->links()); ?></div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.keuangan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Kuliah\karyabhakti\resources\views/pemasukan/index.blade.php ENDPATH**/ ?>