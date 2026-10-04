<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggotas';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'nik',
        'alamat',
        'no_hp',
        'tanggal_lahir',
        'alasan_bergabung',
        'jabatan',
        'status',
        'tanggal_bergabung',
        'jenis_kelamin',
        'foto',
        'tanggal_wawancara',
        'lokasi_wawancara',
        'catatan_wawancara',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_bergabung' => 'date',
        'tanggal_wawancara' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'anggota_id');
    }

    /**
     * Scope untuk pencarian dan filter
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        });

        $query->when($filters['status'] ?? null, function ($query, $status) {
            if ($status !== 'all' && in_array($status, ['pending', 'interview', 'aktif', 'ditolak', 'nonaktif'])) {
                $query->where('status', $status);
            }
        });

        $query->when($filters['jabatan'] ?? null, function ($query, $jabatan) {
            if ($jabatan !== 'all' && !empty($jabatan)) {
                $query->where('jabatan', $jabatan);
            }
        });
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInterview($query)
    {
        return $query->where('status', 'interview');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    /**
     * Label Status Ramah Pengguna
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Peninjauan',
            'interview' => 'Menunggu Wawancara',
            'aktif', 'active' => 'Aktif',
            'ditolak', 'rejected' => 'Ditolak',
            'nonaktif' => 'Nonaktif',
            default => ucfirst($this->status ?? 'Pending'),
        };
    }

    /**
     * Badge CSS Class Berdasarkan Status
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
            'interview' => 'bg-blue-50 text-blue-700 border-blue-200',
            'aktif', 'active' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'ditolak', 'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
            'nonaktif' => 'bg-slate-100 text-slate-600 border-slate-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };
    }

    /**
     * Hitung persentase kehadiran dari total kegiatan yang sudah selesai
     */
    public function getTingkatKehadiranAttribute(): int
    {
        $totalKegiatanSelesai = Kegiatan::where('status', 'selesai')->count();
        if ($totalKegiatanSelesai === 0) {
            return 100; // default 100% jika belum ada kegiatan selesai
        }

        $totalHadir = $this->absensis()
            ->whereHas('kegiatan', fn($q) => $q->where('status', 'selesai'))
            ->where('status_kehadiran', 'hadir')
            ->count();

        return (int) round(($totalHadir / $totalKegiatanSelesai) * 100);
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && file_exists(public_path('storage/' . $this->foto))) {
            return asset('storage/' . $this->foto);
        }

        $initials = urlencode($this->nama);
        $bg = $this->jenis_kelamin === 'P' ? 'FCE7F3' : 'E0F2FE';
        $color = $this->jenis_kelamin === 'P' ? 'DB2777' : '0284C7';
        return "https://ui-avatars.com/api/?name={$initials}&color={$color}&background={$bg}&bold=true";
    }

    public function getUsiaAttribute(): int
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : 0;
    }
}
