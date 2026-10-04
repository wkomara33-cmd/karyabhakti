<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangans';

    protected $fillable = [
        'tipe',
        'tanggal',
        'jumlah',
        'kategori',
        'keterangan',
        'saldo_setelahnya',
        'user_id',
        'bukti_transaksi',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
        'saldo_setelahnya' => 'decimal:2',
    ];

    /**
     * Booted model events untuk update saldo otomatis
     */
    protected static function booted()
    {
        static::saving(function ($keuangan) {
            // Hitung saldo running sebelum transaksi ini
            $previousTransactions = static::where('tanggal', '<', $keuangan->tanggal)
                ->orWhere(function ($q) use ($keuangan) {
                    $q->where('tanggal', '=', $keuangan->tanggal)
                      ->where('id', '<', $keuangan->id ?? 0);
                })
                ->get();

            $pemasukanPrev = $previousTransactions->where('tipe', 'pemasukan')->sum('jumlah');
            $pengeluaranPrev = $previousTransactions->where('tipe', 'pengeluaran')->sum('jumlah');
            $currentSaldo = $pemasukanPrev - $pengeluaranPrev;

            if ($keuangan->tipe === 'pemasukan') {
                $keuangan->saldo_setelahnya = $currentSaldo + $keuangan->jumlah;
            } else {
                $keuangan->saldo_setelahnya = $currentSaldo - $keuangan->jumlah;
            }
        });

        static::saved(function () {
            // Recalculate all future balances to ensure integrity
            static::recalculateBalances();
        });

        static::deleted(function () {
            static::recalculateBalances();
        });
    }

    /**
     * Hitung ulang seluruh saldo secara runtut
     */
    public static function recalculateBalances(): void
    {
        $transactions = static::orderBy('tanggal', 'asc')->orderBy('id', 'asc')->get();
        $runningBalance = 0;

        foreach ($transactions as $tx) {
            if ($tx->tipe === 'pemasukan') {
                $runningBalance += (float)$tx->jumlah;
            } else {
                $runningBalance -= (float)$tx->jumlah;
            }

            if ($tx->saldo_setelahnya != $runningBalance) {
                // Update tanpa trigger event ulang
                static::withoutEvents(function () use ($tx, $runningBalance) {
                    $tx->update(['saldo_setelahnya' => $runningBalance]);
                });
            }
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function getTotalSaldo(): float
    {
        $pemasukan = (float) static::where('tipe', 'pemasukan')->sum('jumlah');
        $pengeluaran = (float) static::where('tipe', 'pengeluaran')->sum('jumlah');
        return $pemasukan - $pengeluaran;
    }

    public static function getTotalPemasukan($from = null, $to = null): float
    {
        $query = static::where('tipe', 'pemasukan');
        if ($from) $query->where('tanggal', '>=', $from);
        if ($to) $query->where('tanggal', '<=', $to);
        return (float) $query->sum('jumlah');
    }

    public static function getTotalPengeluaran($from = null, $to = null): float
    {
        $query = static::where('tipe', 'pengeluaran');
        if ($from) $query->where('tanggal', '>=', $from);
        if ($to) $query->where('tanggal', '<=', $to);
        return (float) $query->sum('jumlah');
    }

    public function getFormattedJumlahAttribute(): string
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }

    public function getFormattedSaldoAttribute(): string
    {
        return 'Rp ' . number_format($this->saldo_setelahnya ?? 0, 0, ',', '.');
    }

    public function getBuktiUrlAttribute(): ?string
    {
        if ($this->bukti_transaksi && file_exists(public_path('storage/' . $this->bukti_transaksi))) {
            return asset('storage/' . $this->bukti_transaksi);
        }
        return null;
    }
}
