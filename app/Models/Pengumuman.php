<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumumans';

    protected $fillable = [
        'judul',
        'konten',
        'kategori',
        'prioritas',
        'is_aktif',
        'user_id',
        'lampiran',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true)->orderBy('created_at', 'desc');
    }

    public function getPrioritasBadgeAttribute(): string
    {
        return match($this->prioritas) {
            'mendesak' => 'bg-rose-100 text-rose-800 border-rose-300 font-bold animate-pulse',
            'penting' => 'bg-amber-100 text-amber-800 border-amber-300 font-semibold',
            default => 'bg-emerald-100 text-emerald-800 border-emerald-300',
        };
    }
}
