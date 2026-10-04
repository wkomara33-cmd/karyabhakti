<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    /**
     * Tampilkan daftar pengumuman
     */
    public function index(Request $request)
    {
        $prioritas = $request->input('prioritas', 'all');
        $search = $request->input('search');

        $query = Pengumuman::with('user');

        if (!Auth::user()->isAdmin()) {
            $query->where('is_aktif', true);
        }

        if ($prioritas !== 'all' && in_array($prioritas, ['biasa', 'penting', 'mendesak'])) {
            $query->where('prioritas', $prioritas);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('konten', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $pengumumans = $query->orderBy('is_aktif', 'desc')
            ->orderByRaw("CASE prioritas WHEN 'mendesak' THEN 1 WHEN 'penting' THEN 2 ELSE 3 END")
            ->orderBy('created_at', 'desc')
            ->paginate(9)
            ->withQueryString();

        return view('pengumuman.index', compact('pengumumans', 'prioritas', 'search'));
    }

    /**
     * Form buat pengumuman baru
     */
    public function create()
    {
        return view('pengumuman.create');
    }

    /**
     * Simpan pengumuman baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'konten' => ['required', 'string'],
            'kategori' => ['required', 'string', 'max:100'],
            'prioritas' => ['required', 'in:biasa,penting,mendesak'],
            'is_aktif' => ['nullable', 'boolean'],
            'lampiran' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg,webp,doc,docx', 'max:5120'],
        ]);

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('lampiran/pengumuman', 'public');
        }

        $validated['is_aktif'] = $request->has('is_aktif');
        $validated['user_id'] = Auth::id();

        Pengumuman::create($validated);

        return redirect()->route('pengumuman.index')
            ->with('success', 'Pengumuman baru berhasil diterbitkan.');
    }

    /**
     * Tampilkan detail pengumuman
     */
    public function show(Pengumuman $pengumuman)
    {
        return view('pengumuman.show', compact('pengumuman'));
    }

    /**
     * Form edit pengumuman
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update pengumuman
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'konten' => ['required', 'string'],
            'kategori' => ['required', 'string', 'max:100'],
            'prioritas' => ['required', 'in:biasa,penting,mendesak'],
            'is_aktif' => ['nullable', 'boolean'],
            'lampiran' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg,webp,doc,docx', 'max:5120'],
        ]);

        if ($request->hasFile('lampiran')) {
            if ($pengumuman->lampiran && Storage::disk('public')->exists($pengumuman->lampiran)) {
                Storage::disk('public')->delete($pengumuman->lampiran);
            }
            $validated['lampiran'] = $request->file('lampiran')->store('lampiran/pengumuman', 'public');
        }

        $validated['is_aktif'] = $request->has('is_aktif');

        $pengumuman->update($validated);

        return redirect()->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Hapus pengumuman
     */
    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->lampiran && Storage::disk('public')->exists($pengumuman->lampiran)) {
            Storage::disk('public')->delete($pengumuman->lampiran);
        }

        $pengumuman->delete();

        return redirect()->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
