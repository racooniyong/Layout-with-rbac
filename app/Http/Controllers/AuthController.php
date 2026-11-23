<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
    $request->session()->regenerate();

    if (Auth::user()->status === 'inactive') {
        return redirect()->route('dashboard')
            ->with('warning', 'Akun kamu sedang inactive. Hubungi admin jika ini keliru.');
    }

    return redirect()->route('dashboard');
}
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'gender'   => 'nullable|in:laki-laki,perempuan',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'gender'   => $data['gender'] ?? null,
            'password' => Hash::make($data['password']),
            'status'   => 'active',
            'role'     => 'user',   // kolom lama; hapus kalau kolom role sudah dihapus
        ]);

        $user->assignRole('user');

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}