<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);
        $roles = Role::withCount('users')->get();   // untuk ringkasan jumlah per role

        return view('pengguna.role', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
            'gender'   => 'nullable|in:laki-laki,perempuan',
            'role'     => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    => $data['phone'] ?? null,
            'gender'   => $data['gender'] ?? null,
            'role'     => $data['role'],   // kolom lama, hapus baris ini kalau kolomnya sudah dihapus
            'status'   => 'active',
        ]);

        $user->assignRole($data['role']);

        return back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        // Super admin tidak boleh mengubah role/email dirinya sendiri (mencegah terkunci)
        if ($user->is($request->user())) {
            return back()->with('error', 'Kamu tidak bisa mengubah role atau email akunmu sendiri.');
        }

        $data = $request->validate([
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->getKey())],
            'role'  => 'required|exists:roles,name',
        ]);

        $user->update(['email' => $data['email'], 'role' => $data['role']]);
        $user->syncRoles([$data['role']]);

        return back()->with('success', 'Email dan role diperbarui.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->is($request->user())) {
            return back()->with('error', 'Kamu tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return back()->with('success', 'User dihapus.');
    }
}