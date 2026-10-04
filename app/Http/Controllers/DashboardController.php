<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keuangan;

class DashboardController extends Controller
{
    public function index()
    {
        $saldoKas = Keuangan::getTotalSaldo();

        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth   = now()->endOfMonth()->toDateString();
        $pemasukanBulanIni   = Keuangan::getTotalPemasukan($startOfMonth, $endOfMonth);
        $pengeluaranBulanIni = Keuangan::getTotalPengeluaran($startOfMonth, $endOfMonth);

        $transaksiTerbaru = Keuangan::with('user')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->take(8)
            ->get();

        // Grafik arus kas 6 bulan terakhir
        $chartMonths      = [];
        $chartPemasukan   = [];
        $chartPengeluaran = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $start = $month->copy()->startOfMonth()->toDateString();
            $end   = $month->copy()->endOfMonth()->toDateString();

            $chartMonths[]      = $month->translatedFormat('M Y');
            $chartPemasukan[]   = (float) Keuangan::where('tipe', 'pemasukan')->whereBetween('tanggal', [$start, $end])->sum('jumlah');
            $chartPengeluaran[] = (float) Keuangan::where('tipe', 'pengeluaran')->whereBetween('tanggal', [$start, $end])->sum('jumlah');
        }

        return view('dashboard.keuangan', compact(
            'saldoKas',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'transaksiTerbaru',
            'chartMonths',
            'chartPemasukan',
            'chartPengeluaran'
        ));
    }
}
