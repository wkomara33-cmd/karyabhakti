<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    // =========================================================
    // PEMASUKAN
    // =========================================================

    /** Daftar pemasukan */
    public function pemasukan(Request $request)
    {
        $search    = $request->input('search');
        $kategori  = $request->input('kategori', 'all');
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        $query = Keuangan::with('user')
            ->where('tipe', 'pemasukan')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc');

        if ($startDate) $query->where('tanggal', '>=', $startDate);
        if ($endDate)   $query->where('tanggal', '<=', $endDate);
        if ($kategori !== 'all') $query->where('kategori', $kategori);
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $data         = $query->paginate(15)->withQueryString();
        $kategoriList = Keuangan::where('tipe', 'pemasukan')->select('kategori')->distinct()->pluck('kategori');
        $totalPeriode = Keuangan::where('tipe', 'pemasukan')
            ->when($startDate, fn($q) => $q->where('tanggal', '>=', $startDate))
            ->when($endDate,   fn($q) => $q->where('tanggal', '<=', $endDate))
            ->sum('jumlah');
        $totalAll = Keuangan::getTotalPemasukan();

        return view('pemasukan.index', compact(
            'data', 'kategoriList', 'totalPeriode', 'totalAll',
            'search', 'kategori', 'startDate', 'endDate'
        ));
    }

    /** Form tambah pemasukan */
    public function createPemasukan()
    {
        return view('pemasukan.create');
    }

    /** Simpan pemasukan */
    public function storePemasukan(Request $request)
    {
        $validated = $request->validate([
            'tanggal'          => ['required', 'date'],
            'jumlah'           => ['required', 'numeric', 'min:1'],
            'kategori'         => ['required', 'string', 'max:100'],
            'keterangan'       => ['required', 'string'],
            'bukti_transaksi'  => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,pdf', 'max:3072'],
        ]);

        $validated['tipe']    = 'pemasukan';
        $validated['user_id'] = Auth::id();

        if ($request->hasFile('bukti_transaksi')) {
            $validated['bukti_transaksi'] = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');
        }

        Keuangan::create($validated);

        return redirect()->route('pemasukan.index')
            ->with('success', 'Data pemasukan berhasil disimpan.');
    }

    // =========================================================
    // PENGELUARAN
    // =========================================================

    /** Daftar pengeluaran */
    public function pengeluaran(Request $request)
    {
        $search    = $request->input('search');
        $kategori  = $request->input('kategori', 'all');
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        $query = Keuangan::with('user')
            ->where('tipe', 'pengeluaran')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc');

        if ($startDate) $query->where('tanggal', '>=', $startDate);
        if ($endDate)   $query->where('tanggal', '<=', $endDate);
        if ($kategori !== 'all') $query->where('kategori', $kategori);
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $data         = $query->paginate(15)->withQueryString();
        $kategoriList = Keuangan::where('tipe', 'pengeluaran')->select('kategori')->distinct()->pluck('kategori');
        $totalPeriode = Keuangan::where('tipe', 'pengeluaran')
            ->when($startDate, fn($q) => $q->where('tanggal', '>=', $startDate))
            ->when($endDate,   fn($q) => $q->where('tanggal', '<=', $endDate))
            ->sum('jumlah');
        $totalAll = Keuangan::getTotalPengeluaran();

        return view('pengeluaran.index', compact(
            'data', 'kategoriList', 'totalPeriode', 'totalAll',
            'search', 'kategori', 'startDate', 'endDate'
        ));
    }

    /** Form tambah pengeluaran */
    public function createPengeluaran()
    {
        return view('pengeluaran.create');
    }

    /** Simpan pengeluaran */
    public function storePengeluaran(Request $request)
    {
        $validated = $request->validate([
            'tanggal'          => ['required', 'date'],
            'jumlah'           => ['required', 'numeric', 'min:1'],
            'kategori'         => ['required', 'string', 'max:100'],
            'keterangan'       => ['required', 'string'],
            'bukti_transaksi'  => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,pdf', 'max:3072'],
        ]);

        $validated['tipe']    = 'pengeluaran';
        $validated['user_id'] = Auth::id();

        if ($request->hasFile('bukti_transaksi')) {
            $validated['bukti_transaksi'] = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');
        }

        Keuangan::create($validated);

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil disimpan.');
    }

    // =========================================================
    // EDIT & DELETE (shared untuk pemasukan & pengeluaran)
    // =========================================================

    /** Form edit — untuk pemasukan */
    public function edit(Keuangan $keuangan)
    {
        return view('pemasukan.edit', compact('keuangan'));
    }

    /** Update pemasukan */
    public function update(Request $request, Keuangan $keuangan)
    {
        $validated = $request->validate([
            'tanggal'         => ['required', 'date'],
            'jumlah'          => ['required', 'numeric', 'min:1'],
            'kategori'        => ['required', 'string', 'max:100'],
            'keterangan'      => ['required', 'string'],
            'bukti_transaksi' => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,pdf', 'max:3072'],
        ]);

        if ($request->hasFile('bukti_transaksi')) {
            if ($keuangan->bukti_transaksi && Storage::disk('public')->exists($keuangan->bukti_transaksi)) {
                Storage::disk('public')->delete($keuangan->bukti_transaksi);
            }
            $validated['bukti_transaksi'] = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');
        }

        $keuangan->update($validated);

        return redirect()->route('pemasukan.index')
            ->with('success', 'Data pemasukan berhasil diperbarui.');
    }

    /** Form edit — untuk pengeluaran */
    public function editPengeluaran(Keuangan $keuangan)
    {
        return view('pengeluaran.edit', compact('keuangan'));
    }

    /** Update pengeluaran */
    public function updatePengeluaran(Request $request, Keuangan $keuangan)
    {
        $validated = $request->validate([
            'tanggal'         => ['required', 'date'],
            'jumlah'          => ['required', 'numeric', 'min:1'],
            'kategori'        => ['required', 'string', 'max:100'],
            'keterangan'      => ['required', 'string'],
            'bukti_transaksi' => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,pdf', 'max:3072'],
        ]);

        if ($request->hasFile('bukti_transaksi')) {
            if ($keuangan->bukti_transaksi && Storage::disk('public')->exists($keuangan->bukti_transaksi)) {
                Storage::disk('public')->delete($keuangan->bukti_transaksi);
            }
            $validated['bukti_transaksi'] = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');
        }

        $keuangan->update($validated);

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    /** Hapus (shared) */
    public function destroy(Keuangan $keuangan)
    {
        $tipe = $keuangan->tipe;

        if ($keuangan->bukti_transaksi && Storage::disk('public')->exists($keuangan->bukti_transaksi)) {
            Storage::disk('public')->delete($keuangan->bukti_transaksi);
        }

        $keuangan->delete();

        $route = $tipe === 'pemasukan' ? 'pemasukan.index' : 'pengeluaran.index';
        return redirect()->route($route)
            ->with('success', 'Data berhasil dihapus dan saldo disesuaikan.');
    }

    /** Hapus pengeluaran (alias agar route terpisah bisa resolve) */
    public function destroyPengeluaran(Keuangan $keuangan)
    {
        return $this->destroy($keuangan);
    }

    // =========================================================
    // LAPORAN KEUANGAN
    // =========================================================

    /** Halaman laporan dengan filter periode */
    public function laporan(Request $request)
    {
        $periode   = $request->input('periode', 'bulanan');   // mingguan | bulanan | tahunan | custom
        $bulan     = $request->input('bulan', now()->month);
        $tahun     = $request->input('tahun', now()->year);
        $minggu    = $request->input('minggu');                // tanggal awal minggu (Y-m-d)
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        [$startDate, $endDate] = $this->resolvePeriode($periode, $bulan, $tahun, $minggu, $startDate, $endDate);

        $query = Keuangan::with('user')
            ->orderBy('tanggal', 'asc')
            ->orderBy('id', 'asc');

        if ($startDate) $query->where('tanggal', '>=', $startDate);
        if ($endDate)   $query->where('tanggal', '<=', $endDate);

        $transaksis      = $query->get();
        $totalPemasukan  = $transaksis->where('tipe', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $transaksis->where('tipe', 'pengeluaran')->sum('jumlah');
        $selisih         = $totalPemasukan - $totalPengeluaran;
        $saldoAwal       = $this->getSaldoSebelum($startDate);
        $saldoAkhir      = $saldoAwal + $selisih;

        // Daftar tahun untuk dropdown (PostgreSQL: EXTRACT)
        $tahunList = Keuangan::selectRaw('EXTRACT(YEAR FROM tanggal)::integer as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        if (empty($tahunList)) $tahunList = [now()->year];

        return view('laporan.index', compact(
            'transaksis', 'totalPemasukan', 'totalPengeluaran', 'selisih',
            'saldoAwal', 'saldoAkhir',
            'periode', 'bulan', 'tahun', 'minggu', 'startDate', 'endDate',
            'tahunList'
        ));
    }

    /** Export laporan ke PDF */
    public function exportPdf(Request $request)
    {
        $periode   = $request->input('periode', 'bulanan');
        $bulan     = $request->input('bulan', now()->month);
        $tahun     = $request->input('tahun', now()->year);
        $minggu    = $request->input('minggu');
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        [$startDate, $endDate] = $this->resolvePeriode($periode, $bulan, $tahun, $minggu, $startDate, $endDate);

        $query = Keuangan::with('user')->orderBy('tanggal', 'asc')->orderBy('id', 'asc');
        if ($startDate) $query->where('tanggal', '>=', $startDate);
        if ($endDate)   $query->where('tanggal', '<=', $endDate);

        $transaksis       = $query->get();
        $totalPemasukan   = $transaksis->where('tipe', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $transaksis->where('tipe', 'pengeluaran')->sum('jumlah');
        $selisih          = $totalPemasukan - $totalPengeluaran;
        $saldoAwal        = $this->getSaldoSebelum($startDate);
        $saldoAkhir       = $saldoAwal + $selisih;
        $totalSaldoTerkini = Keuangan::getTotalSaldo();

        $pdf = Pdf::loadView('pdf.laporan-keuangan', compact(
            'transaksis', 'startDate', 'endDate', 'periode', 'bulan', 'tahun',
            'totalPemasukan', 'totalPengeluaran', 'selisih',
            'saldoAwal', 'saldoAkhir', 'totalSaldoTerkini'
        ))->setPaper('a4', 'landscape');

        $fileName = 'Laporan_Keuangan_' . date('Ymd_His') . '.pdf';
        return $pdf->stream($fileName);
    }

    // =========================================================
    // HELPERS
    // =========================================================

    /**
     * Resolve start & end date dari pilihan periode
     */
    private function resolvePeriode(string $periode, $bulan, $tahun, $minggu, $startDate, $endDate): array
    {
        switch ($periode) {
            case 'mingguan':
                $start = $minggu
                    ? Carbon::parse($minggu)->startOfWeek()->toDateString()
                    : now()->startOfWeek()->toDateString();
                $end = Carbon::parse($start)->endOfWeek()->toDateString();
                return [$start, $end];

            case 'bulanan':
                $start = Carbon::create($tahun, $bulan, 1)->startOfMonth()->toDateString();
                $end   = Carbon::create($tahun, $bulan, 1)->endOfMonth()->toDateString();
                return [$start, $end];

            case 'tahunan':
                $start = Carbon::create($tahun, 1, 1)->startOfYear()->toDateString();
                $end   = Carbon::create($tahun, 1, 1)->endOfYear()->toDateString();
                return [$start, $end];

            case 'custom':
            default:
                return [$startDate, $endDate];
        }
    }

    /**
     * Hitung saldo sebelum tanggal tertentu (saldo awal periode)
     */
    private function getSaldoSebelum(?string $date): float
    {
        if (!$date) return 0;

        $masuk  = (float) Keuangan::where('tipe', 'pemasukan')->where('tanggal', '<', $date)->sum('jumlah');
        $keluar = (float) Keuangan::where('tipe', 'pengeluaran')->where('tanggal', '<', $date)->sum('jumlah');
        return $masuk - $keluar;
    }

    // =========================================================
    // LEGACY — dipertahankan agar tidak error jika ada referensi lama
    // =========================================================

    public function index(Request $request)
    {
        return redirect()->route('laporan.index');
    }

    public function create()
    {
        return redirect()->route('pemasukan.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('pemasukan.index');
    }
}
