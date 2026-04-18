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
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // migrate:fresh already drops all tables, so no need for truncate() here
        // Absensi::truncate();
        // AbsensiInvite::truncate();
        // AbsensiSesi::truncate();
        // Kegiatan::truncate();
        // User::truncate();

        // 1. Create Core Users
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

        // 2. Create more Anggota Users
        $anggotaUsers = collect();
        $anggotaUsers->push(User::create([ // Keep the original ones
            'name' => 'Anggota Aktif 1',
            'divisi' => 'Pengembangan SDM',
            'no_telp' => '081234567893',
            'email' => 'anggota1@gmail.com',
            'password' => Hash::make('password'),
            'alamat' => 'Kulon Progo, Yogyakarta',
            'role' => 'anggota',
            'status' => 'aktif',
        ]));
        $anggotaUsers->push(User::create([
            'name' => 'Anggota Aktif 2',
            'divisi' => 'Hubungan Masyarakat',
            'no_telp' => '081234567894',
            'email' => 'anggota2@gmail.com',
            'password' => Hash::make('password'),
            'alamat' => 'Gunung Kidul, Yogyakarta',
            'role' => 'anggota',
            'status' => 'aktif',
        ]));

        $divisis = ['Pengembangan SDM', 'Hubungan Masyarakat', 'Keuangan', 'Operasional', 'Teknologi Informasi', 'Marketing', 'Produksi'];
        for ($i = 3; $i <= 55; $i++) { // Create 53 additional anggota users (total ~55)
            $anggotaUsers->push(User::create([
                'name' => 'Anggota ' . $i,
                'divisi' => $divisis[array_rand($divisis)],
                'no_telp' => '0812' . rand(100000000, 999999999),
                'email' => 'anggota' . $i . '@gmail.com',
                'password' => Hash::make('password'),
                'alamat' => 'Kota ' . Str::random(5),
                'role' => 'anggota',
                'status' => 'aktif',
            ]));
        }

        // 3. Create Multiple Kegiatan
        $kegiatans = collect();
        for ($k = 1; $k <= 8; $k++) { // Create 8 activities
            $kegiatanDate = Carbon::now()->subMonths(rand(0, 6))->subDays(rand(0, 20))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            $kegiatans->push(Kegiatan::create([
                'nama_kegiatan' => 'Kegiatan ' . $k . ': ' . Str::title(Str::random(10)),
                'deskripsi' => 'Deskripsi untuk kegiatan ' . $k . '.',
                'tanggal_keg' => $kegiatanDate->toDateString(),
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '12:00:00',
                'lokasi' => 'Lokasi Kegiatan ' . $k,
                'status' => 'aktif',
                'created_by' => $admin->id,
            ]));
        }

        // 4. Populate AbsensiInvite, AbsensiSesi, Absensi data
        foreach ($kegiatans as $kegiatan) {
            // Invite a larger subset of anggota, up to all of them for a large activity
            $numToInvite = rand(ceil($anggotaUsers->count() * 0.5), $anggotaUsers->count());
            $invitedAnggota = $anggotaUsers->random($numToInvite); 

            foreach ($invitedAnggota as $anggota) {
                AbsensiInvite::create([
                    'kegiatan_id' => $kegiatan->id,
                    'user_id' => $anggota->id,
                ]);
            }

            // Create 'mulai' session
            $sesiMulaiDate = Carbon::parse($kegiatan->tanggal_keg)->setTime(8, 0, 0);
            $sesiMulai = AbsensiSesi::create([
                'kegiatan_id' => $kegiatan->id,
                'tipe_sesi' => 'mulai',
                'metode' => (rand(0,1) == 1) ? 'mandiri' : 'qr_code',
                'status_sesi' => 'selesai', // Ensure it's finished for percentage calculation
                'dimulai_oleh' => $admin->id,
                'dimulai_at' => $sesiMulaiDate,
                'diselesaikan_oleh' => $admin->id,
                'diselesaikan_at' => $sesiMulaiDate->copy()->addMinutes(30),
            ]);

            // Create 'selesai' session
            $sesiSelesaiDate = Carbon::parse($kegiatan->tanggal_keg)->setTime(12, 0, 0);
            $sesiSelesai = AbsensiSesi::create([
                'kegiatan_id' => $kegiatan->id,
                'tipe_sesi' => 'selesai',
                'metode' => (rand(0,1) == 1) ? 'mandiri' : 'qr_code',
                'status_sesi' => 'selesai', // Ensure it's finished for percentage calculation
                'dimulai_oleh' => $admin->id,
                'dimulai_at' => $sesiSelesaiDate->copy()->subMinutes(30),
                'diselesaikan_oleh' => $admin->id,
                'diselesaikan_at' => $sesiSelesaiDate,
            ]);

            foreach ($invitedAnggota as $anggota) {
                // Decision for 'mulai' session attendance
                if (rand(1, 100) <= 85) { // 85% chance to be 'hadir'
                    Absensi::create([
                        'kegiatan_id' => $kegiatan->id,
                        'absensi_sesi_id' => $sesiMulai->id,
                        'user_id' => $anggota->id,
                        'tipe_sesi' => 'mulai',
                        'waktu_absen' => $sesiMulaiDate->copy()->addMinutes(rand(1, 20)),
                        'metode' => $sesiMulai->metode,
                        'status' => 'hadir',
                    ]);
                } else {
                    // Optionally create 'tidak_hadir' record, though its absence also implies it.
                    // For explicit 'tidak_hadir' records, you might adjust logic.
                }

                // Decision for 'selesai' session attendance
                if (rand(1, 100) <= 75) { // 75% chance to be 'hadir'
                    Absensi::create([
                        'kegiatan_id' => $kegiatan->id,
                        'absensi_sesi_id' => $sesiSelesai->id,
                        'user_id' => $anggota->id,
                        'tipe_sesi' => 'selesai',
                        'waktu_absen' => $sesiSelesaiDate->copy()->subMinutes(rand(1, 20)),
                        'metode' => $sesiSelesai->metode,
                        'status' => 'hadir',
                    ]);
                } else {
                    // Optionally create 'tidak_hadir' record.
                }
            }
        }
    }
}
