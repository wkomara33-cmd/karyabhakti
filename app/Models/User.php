<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke profil Anggota
     */
    public function anggota()
    {
        return $this->hasOne(Anggota::class, 'user_id');
    }

    /**
     * Transaksi keuangan yang dicatat oleh user ini
     */
    public function keuangans()
    {
        return $this->hasMany(Keuangan::class, 'user_id');
    }

    /**
     * Pengumuman yang dibuat oleh user ini
     */
    public function pengumumans()
    {
        return $this->hasMany(Pengumuman::class, 'user_id');
    }

    /**
     * Cek apakah role Admin / Pengurus
     */
    public function isAdmin(): bool
    {
        return $this->hasAnyRole(['admin', 'Ketua', 'Sekretaris', 'Bendahara', 'Pengurus']);
    }

    public function isAnggota(): bool
    {
        return $this->hasRole('Anggota');
    }

    /**
     * Avatar URL Helper
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && file_exists(public_path('storage/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }

        $initials = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$initials}&color=0D9488&background=CCFBF1&bold=true";
    }
}
