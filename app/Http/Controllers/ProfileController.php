<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Kegiatan;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->load('anggota');
        $anggota = $user->anggota;

        $riwayatAbsensi = collect();
        $totalKegiatanSelesai = 0;
        $totalHadir = 0;
        $totalIzin = 0;
        $totalTidakHadir = 0;

        if ($anggota) {
            $riwayatAbsensi = $anggota->absensis()
                ->with('kegiatan')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $totalKegiatanSelesai = Kegiatan::where('status', 'selesai')->count();
            $totalHadir = $anggota->absensis()->where('status_kehadiran', 'hadir')->count();
            $totalIzin = $anggota->absensis()->where('status_kehadiran', 'izin')->count();
            $totalTidakHadir = $anggota->absensis()->where('status_kehadiran', 'tidak_hadir')->count();
        }

        return view('profile.show', compact(
            'user',
            'anggota',
            'riwayatAbsensi',
            'totalKegiatanSelesai',
            'totalHadir',
            'totalIzin',
            'totalTidakHadir'
        ));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'alamat' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars/users', 'public');
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'avatar' => $validated['avatar'] ?? $user->avatar,
        ]);

        if ($user->anggota) {
            $user->anggota->update([
                'nama' => $validated['name'],
                'email' => $validated['email'],
                'no_hp' => $validated['phone'] ?? $user->anggota->no_hp,
                'alamat' => $validated['alamat'] ?? $user->anggota->alamat,
            ]);
        }

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password Anda berhasil diganti.');
    }
}
