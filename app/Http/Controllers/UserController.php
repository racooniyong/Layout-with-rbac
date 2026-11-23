<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);

        return view('pengguna.index', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        // Admin tidak boleh mengubah data super admin
        if ($user->hasRole('super admin') && ! $request->user()->hasRole('super admin')) {
            abort(403);
        }

        // Email dan role sengaja TIDAK divalidasi, jadi tidak akan pernah ikut tersimpan di sini
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'phone'  => 'nullable|string|max:20',
            'gender' => 'nullable|in:laki-laki,perempuan',
        ]);

        $user->update($data);

        return back()->with('success', 'Data pengguna diperbarui.');
    }
}