<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'gein@example.com',
            'password' => 'password',
            'role' => 'admin',
            'status' => 'active'
        ]);
        User::create([
            'name' => 'staff',
            'email' => 'staff@example.com',
            'password' => 'password',
            'role' => 'user',
            'status' => 'active'
        ]);
    }
}
