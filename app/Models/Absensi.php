<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $fillable = [
        'kegiatan_id',
        'anggota_id',
        'konfirmasi_kehadiran',
        'status_kehadiran',
        'waktu_konfirmasi',
        'waktu_absensi',
        'catatan',
    ];

    protected $casts = [
        'waktu_konfirmasi' => 'datetime',
        'waktu_absensi' => 'datetime',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function getStatusKehadiranBadgeAttribute(): string
    {
        return match($this->status_kehadiran) {
            'hadir' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'izin' => 'bg-amber-100 text-amber-800 border-amber-300',
            'tidak_hadir' => 'bg-rose-100 text-rose-800 border-rose-300',
            'belum_absen' => 'bg-gray-100 text-gray-600 border-gray-300',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    public function getKonfirmasiBadgeAttribute(): string
    {
        return match($this->konfirmasi_kehadiran) {
            'hadir' => 'bg-blue-100 text-blue-800 border-blue-300',
            'tidak_hadir' => 'bg-slate-100 text-slate-700 border-slate-300',
            'belum_konfirmasi' => 'bg-amber-50 text-amber-700 border-amber-200',
            default => 'bg-gray-100 text-gray-600',
        };
    }
}
