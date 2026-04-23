<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\AbsensiInvite;
use App\Models\AbsensiSesi;
use App\Models\Kegiatan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Ahmad Budi Santoso',
            'divisi' => 'Pengembangan SDM',
            'no_telp' => '081234567893',
            'email' => 'anggota1@gmail.com',
            'password' => Hash::make('password'),
            'alamat' => 'Jl. Malioboro No. 12, Yogyakarta',
            'role' => 'anggota',
            'status' => 'aktif',
        ]));
        $anggotaUsers->push(User::create([
            'name' => 'Siti Nurhaliza',
            'divisi' => 'Hubungan Masyarakat',
            'no_telp' => '081234567894',
            'email' => 'anggota2@gmail.com',
            'password' => Hash::make('password'),
            'alamat' => 'Jl. Solo No. 45, Sleman, Yogyakarta',
            'role' => 'anggota',
            'status' => 'aktif',
        ]));

        $namaAnggota = [
            'Bambang Sutrisno', 'Ratna Sari Dewi', 'Dedi Kurniawan', 'Fitriani Maharani',
            'Eko Prasetyo', 'Lestari Wulandari', 'Hendra Gunawan', 'Sri Wahyuni',
            'Agus Salim', 'Rina Amelia', 'Joko Susilo', 'Maya Sari',
            'Budiarto Nugroho', 'Dian Purnamasari', 'Andi Saputra', 'Citra Kirana',
            'Fajar Nugraha', 'Indah Permata', 'Hendra Wijaya', 'Sari Melati',
            'Doni Kusuma', 'Rini Handayani', 'Fachri Alamsyah', 'Tari Wulandari',
            'Rizki Ramadhan', 'Mawar Tika', 'Sandi Pratama', 'Lina Marlina',
            'Yoga Septian', 'Dewi Sartika', 'Rama Setiawan', 'Merry Magdalena',
            'Toni Suhendar', 'Elsa Firmansyah', 'Wira Saputra', 'Nina Kartika',
            'Hasan Basri', 'Yuni Astuti', 'Dika Fernanda', 'Rika Fatimah',
            'Oscar Pratama', 'Nita Aulia', 'Rian Firmansyah', 'Santi Dewi',
            'David Kurniawan', 'Fani Oktavia', 'Bayu Aji', 'Lia Anggraini',
            'Rangga Putra', 'Mira Kusuma', 'Aldi Maulana', 'Yani Sri',
            'Fajar Maulana', 'Intan Permatasari', 'Reza Fauzi', 'Dina Mariana',
        ];

        $divisis = ['Pengembangan SDM', 'Hubungan Masyarakat', 'Keuangan', 'Operasional', 'Teknologi Informasi', 'Marketing', 'Produksi'];
        foreach ($namaAnggota as $index => $nama) {
            $anggotaUsers->push(User::create([
                'name' => $nama,
                'divisi' => $divisis[array_rand($divisis)],
                'no_telp' => '0812'.rand(1000000, 9999999),
                'email' => 'anggota'.($index + 3).'@gmail.com',
                'password' => Hash::make('password'),
                'alamat' => 'Kota '.['Yogyakarta', 'Sleman', 'Bantul', 'Kulon Progo', 'Gunung Kidul'][array_rand(['Yogyakarta', 'Sleman', 'Bantul', 'Kulon Progo', 'Gunung Kidul'])],
                'role' => 'anggota',
                'status' => 'aktif',
            ]));
        }

        // 3. Create Multiple Kegiatan
        $kegiatans = collect();
        $kegiatanData = [
            ['Rapat Koordinasi Bulanan', 'Evaluasi kinerja bulanan seluruh divisi organisasi'],
            ['Bakti Sosial', 'Kegiatan sosial untuk masyarakat sekitar kampus'],
            ['Seminar Kepemimpinan', 'Workshop pengembangan soft skill kepemimpinan'],
            ['Turnamen Futsal Antar Divisi', 'Kompetisi olahraga untuk mempererat solidaritas'],
            ['Buka Puasa Bersama', 'Acara buka puasa bareng seluruh anggota organisasi'],
            ['Workshop Digital Marketing', 'Pelatihan strategi pemasaran di era digital'],
            ['Charity Event', 'Penggalangan dana untuk korban bencana alam'],
            ['Study Tour Kampus', 'Kunjungan edukatif ke perusahaan teknologi'],
        ];

        foreach ($kegiatanData as $index => $data) {
            $kegiatanDate = Carbon::now()->subMonths(rand(0, 6))->subDays(rand(0, 20))->setTime(8, 0, 0);
            $kegiatans->push(Kegiatan::create([
                'nama_kegiatan' => $data[0],
                'deskripsi' => $data[1],
                'tanggal' => $kegiatanDate->toDateString(),
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '12:00:00',
                'lokasi' => 'Gedung Serbaguna '.['A', 'B', 'C'][array_rand(['A', 'B', 'C'])],
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
                'metode' => (rand(0, 1) == 1) ? 'mandiri' : 'qr_code',
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
                'metode' => (rand(0, 1) == 1) ? 'mandiri' : 'qr_code',
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
