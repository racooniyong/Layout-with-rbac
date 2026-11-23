
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

// Halaman awal langsung menuju login
Route::get('/', function () {
    return redirect()->route('login');
});

// Belum login
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('auth.login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.proses');
});

// Sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard.index'))
        ->name('dashboard');

    Route::get('/produk', fn () => view('produk'))->name('produk');

    Route::get('/starter', fn () => view('starter'))->name('starter');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});

// Permission kelola user
Route::middleware(['auth', 'permission:kelola user'])->group(function () {
    Route::get('/pengguna', [UserController::class, 'index'])
        ->name('pengguna.index');
    Route::resource('users', UserController::class)
        ->only(['store', 'update', 'destroy']);
});

// Permission lihat laporan
Route::middleware(['auth', 'permission:lihat laporan'])->group(function () {
    Route::view('/laporan', 'pengguna.laporan')->name('laporan');
});
Route::middleware(['auth', 'permission:kelola role'])->group(function () {
    Route::get('/role', [RoleController::class, 'index'])->name('role');
    Route::post('/role', [RoleController::class, 'store'])->name('role.store');
    Route::put('/role/{user}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/{user}', [RoleController::class, 'destroy'])->name('role.destroy');
});
Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => view('auth.login'))->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');

    Route::get('/register', fn () => view('auth.register'))->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.proses');
});
Route::middleware(['auth', 'active.writes'])->group(function () {
    // dashboard, produk, laporan, logout, dll.
});

Route::middleware(['auth', 'active.writes', 'permission:kelola user'])->group(function () {
    // pengguna
});

Route::middleware(['auth', 'active.writes', 'permission:kelola role'])->group(function () {
    // role
});