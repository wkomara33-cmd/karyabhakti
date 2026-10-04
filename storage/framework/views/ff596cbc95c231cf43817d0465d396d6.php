

<?php $__env->startSection('title', 'Dashboard Keuangan'); ?>
<?php $__env->startSection('header_title', 'Dashboard'); ?>
<?php $__env->startSection('header_subtitle', 'Ringkasan keuangan Karang Taruna Karya Bhakti'); ?>

<?php $__env->startSection('header_actions'); ?>
<?php if(auth()->user()->isAdmin()): ?>
<a href="<?php echo e(route('pemasukan.create')); ?>"
   class="hidden sm:inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm">
    + Tambah Pemasukan
</a>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-7">

    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-950 p-6 sm:p-8 text-white shadow-xl">
        <div class="relative z-10">
            <p class="text-xs font-semibold text-emerald-400 uppercase tracking-widest mb-2">Karang Taruna Karya Bhakti</p>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, <?php echo e(auth()->user()->name); ?>!</h1>
            <p class="mt-1 text-sm text-slate-300">Sistem Pencatatan Keuangan Organisasi</p>
            <?php if(auth()->user()->isAdmin()): ?>
            <div class="mt-5 flex flex-wrap gap-3">
                <a href="<?php echo e(route('pemasukan.create')); ?>"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-white font-bold text-xs shadow transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Pemasukan
                </a>
                <a href="<?php echo e(route('pengeluaran.create')); ?>"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-rose-500 hover:bg-rose-400 text-white font-bold text-xs shadow transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Pengeluaran
                </a>
                <a href="<?php echo e(route('laporan.index')); ?>"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-sky-500/80 hover:bg-sky-500 text-white font-bold text-xs shadow transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Lihat Laporan
                </a>
            </div>
            <?php endif; ?>
        </div>
        <div class="absolute right-0 top-0 bottom-0 w-64 opacity-5">
            <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/></svg>
        </div>
    </div>

    <!-- 3 KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

        <!-- Saldo -->
        <div class="bg-gradient-to-br from-slate-900 to-emerald-950 text-white rounded-2xl p-6 shadow-xl border border-slate-800/50">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[11px] font-bold tracking-widest text-emerald-400 uppercase">Saldo Saat Ini</span>
                <span class="p-2 rounded-xl bg-emerald-500/20">
                    <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </span>
            </div>
            <p class="text-3xl font-black tracking-tight">Rp <?php echo e(number_format($saldoKas, 0, ',', '.')); ?></p>
            <p class="text-xs text-slate-400 mt-2 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                Diperbarui otomatis
            </p>
        </div>

        <!-- Pemasukan bulan ini -->
        <a href="<?php echo e(route('pemasukan.index')); ?>"
           class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[11px] font-bold tracking-widest text-slate-400 uppercase">Pemasukan Bulan Ini</span>
                <span class="p-2 rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                </span>
            </div>
            <p class="text-2xl font-black text-emerald-600">+ Rp <?php echo e(number_format($pemasukanBulanIni, 0, ',', '.')); ?></p>
            <p class="text-xs text-slate-400 mt-2"><?php echo e(now()->isoFormat('MMMM Y')); ?> • <span class="text-emerald-600 font-semibold group-hover:underline">Lihat detail →</span></p>
        </a>

        <!-- Pengeluaran bulan ini -->
        <a href="<?php echo e(route('pengeluaran.index')); ?>"
           class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md hover:border-rose-200 transition-all group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[11px] font-bold tracking-widest text-slate-400 uppercase">Pengeluaran Bulan Ini</span>
                <span class="p-2 rounded-xl bg-rose-50 text-rose-600 group-hover:bg-rose-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                </span>
            </div>
            <p class="text-2xl font-black text-rose-600">- Rp <?php echo e(number_format($pengeluaranBulanIni, 0, ',', '.')); ?></p>
            <p class="text-xs text-slate-400 mt-2"><?php echo e(now()->isoFormat('MMMM Y')); ?> • <span class="text-rose-600 font-semibold group-hover:underline">Lihat detail →</span></p>
        </a>
    </div>

    <!-- Chart + Transaksi Terbaru -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-7">

        <!-- Grafik -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Arus Keuangan 6 Bulan Terakhir</h2>
                    <p class="text-xs text-slate-500">Perbandingan pemasukan dan pengeluaran</p>
                </div>
                <div class="flex items-center gap-4 text-xs font-semibold text-slate-600">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>Pemasukan</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>Pengeluaran</span>
                </div>
            </div>
            <div class="h-64 w-full">
                <canvas id="cashFlowChart"></canvas>
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-slate-900">Transaksi Terbaru</h2>
                <a href="<?php echo e(route('laporan.index')); ?>" class="text-xs font-bold text-sky-600 hover:underline">Semua →</a>
            </div>
            <div class="flex-1 space-y-2 overflow-hidden">
                <?php $__empty_1 = true; $__currentLoopData = $transaksiTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center gap-3 py-2 border-b border-slate-50 last:border-0">
                    <div class="w-7 h-7 rounded-lg shrink-0 flex items-center justify-center <?php echo e($tx->tipe === 'pemasukan' ? 'bg-emerald-100' : 'bg-rose-100'); ?>">
                        <?php if($tx->tipe === 'pemasukan'): ?>
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                        <?php else: ?>
                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                        <?php endif; ?>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-semibold text-slate-900 truncate"><?php echo e($tx->kategori); ?></p>
                        <p class="text-[10px] text-slate-400"><?php echo e($tx->tanggal->isoFormat('D MMM Y')); ?></p>
                    </div>
                    <span class="text-xs font-bold whitespace-nowrap <?php echo e($tx->tipe === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600'); ?>">
                        <?php echo e($tx->tipe === 'pemasukan' ? '+' : '-'); ?>Rp <?php echo e(number_format($tx->jumlah, 0, ',', '.')); ?>

                    </span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-xs text-slate-400 py-4 text-center">Belum ada transaksi.</p>
                <?php endif; ?>
            </div>
            <?php if(auth()->user()->isAdmin()): ?>
            <div class="mt-4 pt-4 border-t border-slate-100 grid grid-cols-2 gap-2">
                <a href="<?php echo e(route('pemasukan.create')); ?>"
                   class="text-center py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition-colors">
                    + Pemasukan
                </a>
                <a href="<?php echo e(route('pengeluaran.create')); ?>"
                   class="text-center py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-xl transition-colors">
                    + Pengeluaran
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('cashFlowChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($chartMonths); ?>,
            datasets: [
                { label: 'Pemasukan', data: <?php echo json_encode($chartPemasukan); ?>, backgroundColor: '#10b981', borderRadius: 6, barPercentage: 0.55 },
                { label: 'Pengeluaran', data: <?php echo json_encode($chartPengeluaran); ?>, backgroundColor: '#f43f5e', borderRadius: 6, barPercentage: 0.55 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: (c) => c.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(c.raw) } }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 }, callback: (v) => 'Rp ' + (v/1000).toLocaleString('id-ID') + 'k' } },
                x: { grid: { display: false }, ticks: { font: { size: 10 } } }
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.keuangan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Kuliah\karyabhakti\resources\views/dashboard/keuangan.blade.php ENDPATH**/ ?>