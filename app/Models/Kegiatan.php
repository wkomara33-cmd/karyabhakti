<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatans';

    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'tanggal',
        'tanggal_selesai',
        'lokasi',
        'status',
        'created_by',
        'banner',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'kegiatan_id');
    }

    public function scopeMendatang($query)
    {
        return $query->where('tanggal', '>=', now())
                     ->whereIn('status', ['akan_datang', 'berlangsung'])
                     ->orderBy('tanggal', 'asc');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai')->orderBy('tanggal', 'desc');
    }

    // Statistik kehadiran
    public function getJumlahHadirAttribute(): int
    {
        return $this->absensis()->where('status_kehadiran', 'hadir')->count();
    }

    public function getJumlahIzinAttribute(): int
    {
        return $this->absensis()->where('status_kehadiran', 'izin')->count();
    }

    public function getJumlahTidakHadirAttribute(): int
    {
        return $this->absensis()->where('status_kehadiran', 'tidak_hadir')->count();
    }

    public function getJumlahBelumAbsenAttribute(): int
    {
        return $this->absensis()->where('status_kehadiran', 'belum_absen')->count();
    }

    public function getJumlahRsvpHadirAttribute(): int
    {
        return $this->absensis()->where('konfirmasi_kehadiran', 'hadir')->count();
    }

    public function getJumlahRsvpTidakHadirAttribute(): int
    {
        return $this->absensis()->where('konfirmasi_kehadiran', 'tidak_hadir')->count();
    }

    public function getPersentaseKehadiranAttribute(): int
    {
        $totalAktif = Anggota::where('status', 'aktif')->count();
        if ($totalAktif === 0) return 0;
        return (int) round(($this->jumlah_hadir / $totalAktif) * 100);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'akan_datang' => 'bg-blue-100 text-blue-800 border-blue-200',
            'berlangsung' => 'bg-emerald-100 text-emerald-800 border-emerald-200 animate-pulse',
            'selesai' => 'bg-slate-100 text-slate-800 border-slate-200',
            'dibatalkan' => 'bg-rose-100 text-rose-800 border-rose-200',
            default => 'bg-slate-100 text-slate-800',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'akan_datang' => 'Akan Datang',
            'berlangsung' => 'Sedang Berlangsung',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }
}
