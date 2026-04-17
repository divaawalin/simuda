<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\AbsensiInvite;
use App\Models\AbsensiSesi;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Users
        $admin = User::create([
            'name' => 'Super Admin',
            'divisi' => 'Teknologi Informasi',
            'no_telp' => '081234567890',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'alamat' => 'Yogyakarta, Indonesia',
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $sekretaris = User::create([
            'name' => 'Sekretaris Organisasi',
            'divisi' => 'Sekretariat',
            'no_telp' => '081234567891',
            'email' => 'sekretaris@gmail.com',
            'password' => Hash::make('password'),
            'alamat' => 'Sleman, Yogyakarta',
            'role' => 'sekretaris',
            'status' => 'aktif',
        ]);

        $ketua = User::create([
            'name' => 'Ketua Umum',
            'divisi' => 'Pimpinan',
            'no_telp' => '081234567892',
            'email' => 'ketua@gmail.com',
            'password' => Hash::make('password'),
            'alamat' => 'Bantul, Yogyakarta',
            'role' => 'ketua',
            'status' => 'aktif',
        ]);

        $anggota1 = User::create([
            'name' => 'Anggota Aktif 1',
            'divisi' => 'Pengembangan SDM',
            'no_telp' => '081234567893',
            'email' => 'anggota1@gmail.com',
            'password' => Hash::make('password'),
            'alamat' => 'Kulon Progo, Yogyakarta',
            'role' => 'anggota',
            'status' => 'aktif',
        ]);

        $anggota2 = User::create([
            'name' => 'Anggota Aktif 2',
            'divisi' => 'Hubungan Masyarakat',
            'no_telp' => '081234567894',
            'email' => 'anggota2@gmail.com',
            'password' => Hash::make('password'),
            'alamat' => 'Gunung Kidul, Yogyakarta',
            'role' => 'anggota',
            'status' => 'aktif',
        ]);

        // 2. Create Kegiatan
        $kegiatan = Kegiatan::create([
            'nama_kegiatan' => 'Rapat Pleno Bulanan',
            'deskripsi' => 'Rapat rutin bulanan untuk membahas program kerja organisasi.',
            'tanggal' => now()->toDateString(),
            'waktu_mulai' => '08:00:00',
            'waktu_selesai' => '12:00:00',
            'lokasi' => 'Aula Gedung Serbaguna',
            'status' => 'aktif',
            'created_by' => $admin->id,
        ]);

        // 3. Invite Anggota to Kegiatan
        AbsensiInvite::create([
            'kegiatan_id' => $kegiatan->id,
            'user_id' => $anggota1->id,
        ]);

        AbsensiInvite::create([
            'kegiatan_id' => $kegiatan->id,
            'user_id' => $anggota2->id,
        ]);

        // 4. Create Absensi Sesi (Mulai)
        $sesiMulai = AbsensiSesi::create([
            'kegiatan_id' => $kegiatan->id,
            'tipe_sesi' => 'mulai',
            'metode' => 'mandiri',
            'status_sesi' => 'selesai',
            'dimulai_oleh' => $admin->id,
            'dimulai_at' => now()->subHours(4),
            'diselesaikan_oleh' => $admin->id,
            'diselesaikan_at' => now()->subHours(3),
        ]);

        // 5. Create Absensi Sesi (Selesai - Berlangsung)
        $sesiSelesai = AbsensiSesi::create([
            'kegiatan_id' => $kegiatan->id,
            'tipe_sesi' => 'selesai',
            'metode' => 'qr_code',
            'status_sesi' => 'berlangsung',
            'qr_token' => Str::random(40),
            'qr_expires_at' => now()->addHours(2),
            'dimulai_oleh' => $admin->id,
            'dimulai_at' => now(),
        ]);

        // 6. Create Absensi (Kehadiran Anggota)
        // Anggota 1 hadir di sesi mulai
        Absensi::create([
            'kegiatan_id' => $kegiatan->id,
            'absensi_sesi_id' => $sesiMulai->id,
            'user_id' => $anggota1->id,
            'tipe_sesi' => 'mulai',
            'waktu_absen' => now()->subHours(3)->subMinutes(45),
            'metode' => 'mandiri',
            'status' => 'hadir',
        ]);

        // Anggota 2 hadir di sesi mulai
        Absensi::create([
            'kegiatan_id' => $kegiatan->id,
            'absensi_sesi_id' => $sesiMulai->id,
            'user_id' => $anggota2->id,
            'tipe_sesi' => 'mulai',
            'waktu_absen' => now()->subHours(3)->subMinutes(30),
            'metode' => 'mandiri',
            'status' => 'hadir',
        ]);
        
        // Anggota 1 hadir di sesi selesai (scan qr)
        Absensi::create([
            'kegiatan_id' => $kegiatan->id,
            'absensi_sesi_id' => $sesiSelesai->id,
            'user_id' => $anggota1->id,
            'tipe_sesi' => 'selesai',
            'waktu_absen' => now()->subMinutes(5),
            'metode' => 'qr_code',
            'status' => 'hadir',
        ]);
    }
}
