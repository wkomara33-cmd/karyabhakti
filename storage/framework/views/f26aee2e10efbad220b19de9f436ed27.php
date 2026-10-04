<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan Karang Taruna</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12px; color: #000; background: #fff; line-height: 1.5; }

        .kop-surat { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #000; padding-bottom: 10px; padding-top: 20px;}
        .kop-surat h1 { font-size: 16px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .kop-surat h2 { font-size: 18px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .kop-surat p { font-size: 12px; margin-bottom: 2px; }
        .kop-surat .alamat { font-size: 10px; font-style: italic; }

        .body { padding: 0 40px 20px; }
        
        .report-title { text-align: center; margin-bottom: 20px; font-size: 14px; font-weight: bold; text-decoration: underline; text-transform: uppercase; }

        .meta-info { margin-bottom: 20px; width: 100%; border-collapse: collapse; }
        .meta-info td { padding: 2px 0; vertical-align: top; }
        .meta-info .label { width: 150px; font-weight: bold; }
        .meta-info .colon { width: 15px; }

        /* Summary Cards - made simpler for formal look */
        .summary { width: 100%; margin-bottom: 20px; border-collapse: collapse; font-weight: bold;}
        .summary td { padding: 5px; border: 1px solid #000; }
        .summary .label-col { width: 25%; background-color: #f0f0f0;}

        /* Table */
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 11px; }
        .data-table thead th { padding: 8px; text-align: center; font-weight: bold; border: 1px solid #000; background-color: #f0f0f0; }
        
        .data-table tbody td { padding: 6px 8px; border: 1px solid #000; vertical-align: top; }
        .data-table tbody tr.saldo-awal { background-color: #f9f9f9; font-style: italic; }
        .data-table tbody tr.total-row { font-weight: bold; background-color: #f0f0f0; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .signature-section { margin-top: 50px; width: 100%; }
        .signature-table { width: 100%; border: none; }
        .signature-table td { width: 50%; text-align: center; border: none; padding: 0; }
        .signature-space { height: 80px; }
        .signature-name { font-weight: bold; text-decoration: underline; }

        .footer { margin-top: 30px; text-align: right; font-size: 9px; font-style: italic; color: #666; }
    </style>
</head>
<body>

<div class="body">
    <div class="kop-surat">
        <h1>PENGURUS KARANG TARUNA NISCALA DHARMA</h1>
        <h2>RW 09 KELURAHAN BOBODOLAN</h2>
        <p class="alamat">Sekretariat: Balai Warga RW 09, Kelurahan Bobodolan</p>
    </div>

    <div class="report-title">
        Laporan Keuangan
    </div>

    <table class="meta-info">
        <tr>
            <td class="label">Periode</td>
            <td class="colon">:</td>
            <td>
                <?php if($startDate && $endDate): ?>
                    <?php echo e(\Carbon\Carbon::parse($startDate)->isoFormat('D MMMM Y')); ?> s.d. <?php echo e(\Carbon\Carbon::parse($endDate)->isoFormat('D MMMM Y')); ?>

                <?php elseif($startDate): ?>
                    Sejak <?php echo e(\Carbon\Carbon::parse($startDate)->isoFormat('D MMMM Y')); ?>

                <?php elseif($endDate): ?>
                    Hingga <?php echo e(\Carbon\Carbon::parse($endDate)->isoFormat('D MMMM Y')); ?>

                <?php else: ?>
                    Seluruh Periode
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td class="label">Total Transaksi</td>
            <td class="colon">:</td>
            <td><?php echo e($transaksis->count()); ?> transaksi</td>
        </tr>
    </table>

    <table class="summary">
        <tr>
            <td class="label-col">Saldo Awal</td>
            <td>Rp <?php echo e(number_format($saldoAwal, 0, ',', '.')); ?></td>
            <td class="label-col">Total Pemasukan</td>
            <td>Rp <?php echo e(number_format($totalPemasukan, 0, ',', '.')); ?></td>
        </tr>
        <tr>
            <td class="label-col">Total Pengeluaran</td>
            <td>Rp <?php echo e(number_format($totalPengeluaran, 0, ',', '.')); ?></td>
            <td class="label-col">Saldo Akhir</td>
            <td>Rp <?php echo e(number_format($saldoAkhir, 0, ',', '.')); ?></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:12%">Tanggal</th>
                <th style="width:10%">Jenis</th>
                <th style="width:15%">Kategori</th>
                <th>Uraian</th>
                <th style="width:13%">Pemasukan (Rp)</th>
                <th style="width:13%">Pengeluaran (Rp)</th>
                <th style="width:13%">Saldo (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr class="saldo-awal">
                <td colspan="5" class="text-center"><strong>Saldo Awal Periode</strong></td>
                <td colspan="2"></td>
                <td class="text-right"><strong><?php echo e(number_format($saldoAwal, 0, ',', '.')); ?></strong></td>
            </tr>

            <?php $no = 1; $saldoBerjalan = $saldoAwal; ?>
            <?php $__currentLoopData = $transaksis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $saldoBerjalan += ($tx->tipe === 'pemasukan') ? $tx->jumlah : -$tx->jumlah;
            ?>
            <tr>
                <td class="text-center"><?php echo e($no++); ?></td>
                <td class="text-center"><?php echo e($tx->tanggal->isoFormat('D MMM Y')); ?></td>
                <td class="text-center"><?php echo e(ucfirst($tx->tipe)); ?></td>
                <td><?php echo e($tx->kategori); ?></td>
                <td><?php echo e($tx->keterangan); ?></td>
                <td class="text-right">
                    <?php echo e($tx->tipe === 'pemasukan' ? number_format($tx->jumlah, 0, ',', '.') : '-'); ?>

                </td>
                <td class="text-right">
                    <?php echo e($tx->tipe === 'pengeluaran' ? number_format($tx->jumlah, 0, ',', '.') : '-'); ?>

                </td>
                <td class="text-right">
                    <?php echo e(number_format($saldoBerjalan, 0, ',', '.')); ?>

                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($transaksis->count() > 0): ?>
            <tr class="total-row">
                <td colspan="5" class="text-center">JUMLAH TOTAL</td>
                <td class="text-right"><?php echo e(number_format($totalPemasukan, 0, ',', '.')); ?></td>
                <td class="text-right"><?php echo e(number_format($totalPengeluaran, 0, ',', '.')); ?></td>
                <td class="text-right"><?php echo e(number_format($saldoAkhir, 0, ',', '.')); ?></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td></td>
                <td>Bobodolan, <?php echo e(now()->isoFormat('D MMMM Y')); ?></td>
            </tr>
            <tr>
                <td>Mengetahui,<br>Ketua Karang Taruna</td>
                <td><br>Bendahara</td>
            </tr>
            <tr>
                <td class="signature-space"></td>
                <td class="signature-space"></td>
            </tr>
            <tr>
                <td><span class="signature-name">....................................</span></td>
                <td><span class="signature-name">Bendahara</span></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Dicetak oleh Sistem Keuangan Niscala Dharma &nbsp;|&nbsp; <?php echo e(now()->isoFormat('D MMMM Y HH:mm')); ?> WIB
    </div>

</div>
</body>
</html>
<?php /**PATH C:\Kuliah\karyabhakti\resources\views/pdf/laporan-keuangan.blade.php ENDPATH**/ ?>