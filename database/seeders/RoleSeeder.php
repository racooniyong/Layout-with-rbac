<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
{
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    $all = ['kelola role', 'kelola user', 'lihat laporan', 'lihat produk'];
    foreach ($all as $p) {
        Permission::firstOrCreate(['name' => $p]);
    }

    Role::firstOrCreate(['name' => 'super admin'])->syncPermissions($all);

    Role::firstOrCreate(['name' => 'admin'])
        ->syncPermissions(['kelola user', 'lihat laporan', 'lihat produk']);

    Role::firstOrCreate(['name' => 'staff'])
        ->syncPermissions([ 'lihat produk']);

    Role::firstOrCreate(['name' => 'user'])
        ->syncPermissions(['lihat produk']);
}
}