

<?php $__env->startSection('title', 'Laporan Keuangan'); ?>
<?php $__env->startSection('header_title', 'Laporan Keuangan'); ?>
<?php $__env->startSection('header_subtitle', 'Rekapitulasi pemasukan dan pengeluaran organisasi'); ?>

<?php $__env->startSection('header_actions'); ?>
<a href="<?php echo e(route('laporan.exportPdf', request()->query())); ?>" target="_blank"
   class="inline-flex items-center gap-2 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
    Export PDF
</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5" x-data="{ periode: '<?php echo e($periode); ?>' }">
        <form method="GET" action="<?php echo e(route('laporan.index')); ?>" class="space-y-4">

            
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Periode</label>
                <div class="flex flex-wrap gap-2">
                    <?php $__currentLoopData = ['mingguan' => 'Mingguan', 'bulanan' => 'Bulanan', 'tahunan' => 'Tahunan', 'custom' => 'Rentang Tanggal']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="cursor-pointer">
                        <input type="radio" name="periode" value="<?php echo e($val); ?>" x-model="periode"
                               class="sr-only" <?php echo e($periode === $val ? 'checked' : ''); ?>>
                        <span :class="periode === '<?php echo e($val); ?>' ? 'bg-sky-600 text-white border-sky-600' : 'bg-white text-slate-600 border-slate-200 hover:border-sky-400'"
                              class="inline-block px-4 py-2 rounded-xl text-xs font-semibold border transition-all">
                            <?php echo e($label); ?>

                        </span>
                    </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                
                <div x-show="periode === 'mingguan'" class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Pilih Tanggal dalam Minggu</label>
                    <input type="date" name="minggu" value="<?php echo e($minggu ?? now()->startOfWeek()->toDateString()); ?>"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    <p class="text-[10px] text-slate-400 mt-1">Akan menampilkan data Senin–Minggu dari tanggal yang dipilih</p>
                </div>

                
                <div x-show="periode === 'bulanan'">
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Bulan</label>
                    <select name="bulan" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($m); ?>" <?php echo e((int)$bulan === $m ? 'selected' : ''); ?>>
                            <?php echo e(\Carbon\Carbon::create(null, $m, 1)->isoFormat('MMMM')); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div x-show="periode === 'bulanan' || periode === 'tahunan'">
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Tahun</label>
                    <select name="tahun" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        <?php $__currentLoopData = $tahunList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t); ?>" <?php echo e((int)$tahun === (int)$t ? 'selected' : ''); ?>><?php echo e($t); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div x-show="periode === 'custom'">
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="<?php echo e($startDate); ?>"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>
                <div x-show="periode === 'custom'">
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="<?php echo e($endDate); ?>"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                </div>

            </div>

            <div class="flex items-center gap-3 pt-1">
                <button type="submit"
                        class="px-5 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm">
                    Tampilkan Laporan
                </button>
                <a href="<?php echo e(route('laporan.index')); ?>"
                   class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition-colors">
                    Reset
                </a>
            </div>

        </form>
    </div>

    
    <?php if($startDate || $endDate): ?>
    <div class="flex items-center gap-3 px-4 py-3 bg-sky-50 border border-sky-200 rounded-2xl text-xs font-medium text-sky-800">
        <svg class="w-4 h-4 text-sky-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        Menampilkan laporan periode:
        <strong>
            <?php if($startDate && $endDate): ?>
                <?php echo e(\Carbon\Carbon::parse($startDate)->isoFormat('D MMMM Y')); ?> – <?php echo e(\Carbon\Carbon::parse($endDate)->isoFormat('D MMMM Y')); ?>

            <?php elseif($startDate): ?>
                Mulai <?php echo e(\Carbon\Carbon::parse($startDate)->isoFormat('D MMMM Y')); ?>

            <?php else: ?>
                Sampai <?php echo e(\Carbon\Carbon::parse($endDate)->isoFormat('D MMMM Y')); ?>

            <?php endif; ?>
        </strong>
        <span class="ml-auto">
            <a href="<?php echo e(route('laporan.exportPdf', request()->query())); ?>" target="_blank"
               class="inline-flex items-center gap-1 px-3 py-1 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-semibold transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export PDF
            </a>
        </span>
    </div>
    <?php endif; ?>

    
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Saldo Awal</p>
            <p class="text-lg font-black text-slate-700">Rp <?php echo e(number_format($saldoAwal, 0, ',', '.')); ?></p>
            <p class="text-[10px] text-slate-400 mt-1">Sebelum periode ini</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-500 mb-2">Total Pemasukan</p>
            <p class="text-lg font-black text-emerald-600">+ Rp <?php echo e(number_format($totalPemasukan, 0, ',', '.')); ?></p>
            <p class="text-[10px] text-slate-400 mt-1"><?php echo e($transaksis->where('tipe','pemasukan')->count()); ?> transaksi</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-rose-100 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-widest text-rose-500 mb-2">Total Pengeluaran</p>
            <p class="text-lg font-black text-rose-600">- Rp <?php echo e(number_format($totalPengeluaran, 0, ',', '.')); ?></p>
            <p class="text-[10px] text-slate-400 mt-1"><?php echo e($transaksis->where('tipe','pengeluaran')->count()); ?> transaksi</p>
        </div>
        <div class="bg-gradient-to-br <?php echo e($saldoAkhir >= 0 ? 'from-emerald-600 to-teal-700' : 'from-rose-600 to-pink-700'); ?> text-white p-5 rounded-2xl shadow-lg">
            <p class="text-[10px] font-bold uppercase tracking-widest text-white/70 mb-2">Saldo Akhir</p>
            <p class="text-lg font-black">Rp <?php echo e(number_format($saldoAkhir, 0, ',', '.')); ?></p>
            <p class="text-[10px] text-white/70 mt-1">
                Selisih: <?php echo e($selisih >= 0 ? '+' : ''); ?>Rp <?php echo e(number_format($selisih, 0, ',', '.')); ?>

            </p>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-900 text-sm">Rincian Transaksi</h3>
            <span class="text-xs text-slate-500"><?php echo e($transaksis->count()); ?> transaksi</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="py-3 px-5">No</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Jenis</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4 text-right">Pemasukan</th>
                        <th class="py-3 px-4 text-right">Pengeluaran</th>
                        <th class="py-3 px-4 text-right">Saldo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    
                    <tr class="bg-slate-50/60">
                        <td colspan="4" class="py-3 px-5 text-xs font-bold text-slate-500 italic">Saldo Awal Periode</td>
                        <td colspan="3" class="py-3 px-4"></td>
                        <td class="py-3 px-4 text-right text-xs font-bold text-slate-700">
                            Rp <?php echo e(number_format($saldoAwal, 0, ',', '.')); ?>

                        </td>
                    </tr>

                    <?php $no = 1; $saldoBerjalan = $saldoAwal; ?>
                    <?php $__empty_1 = true; $__currentLoopData = $transaksis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        if ($tx->tipe === 'pemasukan') {
                            $saldoBerjalan += $tx->jumlah;
                        } else {
                            $saldoBerjalan -= $tx->jumlah;
                        }
                    ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-3 px-5 text-xs text-slate-400"><?php echo e($no++); ?></td>
                        <td class="py-3 px-4 text-xs font-semibold text-slate-700 whitespace-nowrap">
                            <?php echo e($tx->tanggal->isoFormat('D MMM Y')); ?>

                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold
                                <?php echo e($tx->tipe === 'pemasukan' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'); ?>">
                                <?php echo e($tx->tipe === 'pemasukan' ? 'Masuk' : 'Keluar'); ?>

                            </span>
                        </td>
                        <td class="py-3 px-4 text-xs text-slate-700"><?php echo e($tx->kategori); ?></td>
                        <td class="py-3 px-4 text-xs text-slate-600 max-w-xs">
                            <p class="line-clamp-2"><?php echo e($tx->keterangan); ?></p>
                        </td>
                        <td class="py-3 px-4 text-right text-xs font-semibold whitespace-nowrap">
                            <?php if($tx->tipe === 'pemasukan'): ?>
                            <span class="text-emerald-600">Rp <?php echo e(number_format($tx->jumlah, 0, ',', '.')); ?></span>
                            <?php else: ?>
                            <span class="text-slate-300">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4 text-right text-xs font-semibold whitespace-nowrap">
                            <?php if($tx->tipe === 'pengeluaran'): ?>
                            <span class="text-rose-600">Rp <?php echo e(number_format($tx->jumlah, 0, ',', '.')); ?></span>
                            <?php else: ?>
                            <span class="text-slate-300">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4 text-right text-xs font-bold whitespace-nowrap text-slate-800">
                            Rp <?php echo e(number_format($saldoBerjalan, 0, ',', '.')); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-400">
                            <svg class="w-10 h-10 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="font-semibold text-slate-500">Tidak ada transaksi pada periode ini</p>
                        </td>
                    </tr>
                    <?php endif; ?>

                    
                    <?php if($transaksis->count() > 0): ?>
                    <tr class="bg-slate-50 border-t-2 border-slate-200 font-bold">
                        <td colspan="5" class="py-3.5 px-5 text-xs font-bold text-slate-700 uppercase tracking-wider">Total Periode</td>
                        <td class="py-3.5 px-4 text-right text-xs text-emerald-700">
                            Rp <?php echo e(number_format($totalPemasukan, 0, ',', '.')); ?>

                        </td>
                        <td class="py-3.5 px-4 text-right text-xs text-rose-700">
                            Rp <?php echo e(number_format($totalPengeluaran, 0, ',', '.')); ?>

                        </td>
                        <td class="py-3.5 px-4 text-right text-xs <?php echo e($saldoAkhir >= 0 ? 'text-emerald-700' : 'text-rose-700'); ?>">
                            Rp <?php echo e(number_format($saldoAkhir, 0, ',', '.')); ?>

                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.keuangan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Kuliah\karyabhakti\resources\views/laporan/index.blade.php ENDPATH**/ ?>