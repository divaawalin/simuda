<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Only create 3 core accounts
        User::create([
            'name' => 'Super Admin',
            'divisi' => 'Teknologi Informasi',
            'no_telp' => '081234567890',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'alamat' => 'Yogyakarta, Indonesia',
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        User::create([
            'name' => 'Sekretaris Organisasi',
            'divisi' => 'Sekretariat',
            'no_telp' => '081234567891',
            'email' => 'sekretaris@gmail.com',
            'password' => Hash::make('password'),
            'alamat' => 'Sleman, Yogyakarta',
            'role' => 'sekretaris',
            'status' => 'aktif',
        ]);

        User::create([
            'name' => 'Ketua Umum',
            'divisi' => 'Pimpinan',
            'no_telp' => '081234567892',
            'email' => 'ketua@gmail.com',
            'password' => Hash::make('password'),
            'alamat' => 'Bantul, Yogyakarta',
            'role' => 'ketua',
            'status' => 'aktif',
        ]);
    }
}
