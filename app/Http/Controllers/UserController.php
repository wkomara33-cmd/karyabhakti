<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Anggota;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user sistem
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role', 'all');

        $query = User::with(['roles', 'anggota']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($role !== 'all') {
            $query->role($role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        $roles = Role::all();
        $anggotasWithoutUser = Anggota::whereNull('user_id')->orderBy('nama', 'asc')->get();

        return view('users.index', compact('users', 'roles', 'anggotasWithoutUser', 'role', 'search'));
    }

    /**
     * Form tambah user baru
     */
    public function create()
    {
        $roles = Role::all();
        $anggotasWithoutUser = Anggota::whereNull('user_id')->orderBy('nama', 'asc')->get();
        return view('users.create', compact('roles', 'anggotasWithoutUser'));
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'exists:roles,name'],
            'anggota_id' => ['nullable', 'exists:anggotas,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
        ]);

        $user->assignRole($validated['role']);

        if (!empty($validated['anggota_id'])) {
            $anggota = Anggota::find($validated['anggota_id']);
            if ($anggota) {
                $anggota->update(['user_id' => $user->id]);
            }
        }

        return redirect()->route('users.index')
            ->with('success', "Akun user {$user->name} dengan role {$validated['role']} berhasil dibuat.");
    }

    /**
     * Form edit user
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $anggotasWithoutUser = Anggota::where(function ($q) use ($user) {
            $q->whereNull('user_id')->orWhere('user_id', $user->id);
        })->orderBy('nama', 'asc')->get();

        return view('users.edit', compact('user', 'roles', 'anggotasWithoutUser'));
    }

    /**
     * Update data user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'exists:roles,name'],
            'anggota_id' => ['nullable', 'exists:anggotas,id'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);
        $user->syncRoles([$validated['role']]);

        // Putuskan relasi lama jika diubah
        Anggota::where('user_id', $user->id)->update(['user_id' => null]);

        if (!empty($validated['anggota_id'])) {
            $anggota = Anggota::find($validated['anggota_id']);
            if ($anggota) {
                $anggota->update(['user_id' => $user->id]);
            }
        }

        return redirect()->route('users.index')
            ->with('success', "Akun user {$user->name} berhasil diperbarui.");
    }

    /**
     * Hapus user
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Lepaskan relasi anggota jika ada
        Anggota::where('user_id', $user->id)->update(['user_id' => null]);

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
