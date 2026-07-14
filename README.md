# SIMUDA (Sistem Informasi Muda Jember)

SIMUDA adalah aplikasi berbasis web yang dirancang untuk mengelola data anggota, kegiatan, absensi, konten, dan dokumen organisasi secara efisien. Sistem ini dibangun dengan fokus pada kemudahan akses, antarmuka yang modern, dan responsivitas penuh di berbagai perangkat.

## 🚀 Fitur Utama

*   **Manajemen Anggota:** Pendataan, pengelolaan profil, dan pengelompokan anggota berdasarkan divisi, desa, dan kelompok.
*   **Sistem Absensi Terintegrasi:** Kelola kegiatan, buat sesi absensi, dan undang anggota secara spesifik. Tersedia fitur scanner QR untuk kehadiran yang lebih cepat.
*   **Manajemen Kegiatan:** Penjadwalan kegiatan organisasi dengan visualisasi kalender interaktif.
*   **Distribusi Konten & Dokumen:** Wadah berbagi materi, link, dan dokumen penting bagi seluruh anggota.
*   **Laporan & Analitik:** Rekapitulasi absensi secara global maupun per kegiatan, dengan visualisasi grafik untuk memantau tren kehadiran.
*   **Manajemen Admin:** Pengaturan hak akses untuk admin, sekretaris, dan ketua.
*   **Antarmuka Responsif:** Desain modern (Mobile-First) yang nyaman digunakan di Desktop, Tablet, dan Smartphone.

## 🛠 Teknologi yang Digunakan

*   **Framework:** [Laravel](https://laravel.com/)
*   **Frontend:** [Bootstrap 5](https://getbootstrap.com/)
*   **Database:** MySQL
*   **Charts & Visuals:** [Chart.js](https://www.chartjs.org/)
*   **Kalender:** [FullCalendar](https://fullcalendar.io/)
*   **Lainnya:** SweetAlert2, FontAwesome, Google Fonts (Plus Jakarta Sans)

## 📋 Prasyarat

Pastikan server Anda memiliki:
*   PHP ^8.2
*   Composer
*   Node.js & NPM
*   MySQL/MariaDB

## ⚙️ Instalasi

1. **Clone Repository:**
   ```bash
   git clone https://github.com/divaawalin/simuda.git
   cd simuda
   ```

2. **Instalasi Dependensi:**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Lingkungan:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Sesuaikan file `.env` dengan konfigurasi database lokal Anda.*

4. **Migrasi Database:**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi:**
   ```bash
   php artisan serve
   npm run dev
   ```

## 📱 Responsivitas
SIMUDA dibangun dengan pendekatan *Responsive Web Design* yang memastikan pengalaman pengguna konsisten. Fitur utama termasuk:
*   **Off-canvas Sidebar:** Navigasi yang elegan pada perangkat mobile.
*   **Adaptive Grid:** Tata letak *banner*, *form*, dan *tabel* yang menyesuaikan ukuran layar secara otomatis.
*   **Mobile-Friendly Interaction:** Penggunaan tombol yang mudah dijangkau dan tampilan kalender yang dapat berubah bentuk (*View Switching*).

## 🤝 Kontribusi
Proyek ini dikembangkan untuk kebutuhan organisasi. Jika Anda memiliki saran atau menemukan bug, silakan buat *issue* atau kirimkan *pull request*.

---
*Dikembangkan oleh Tim IT Generus Jember.*


## Donasi

Jika project ini bermanfaat, Anda dapat mendukung pengembangan selanjutnya melalui donasi:

<div align="center">

![QRIS](public/assets/qris.png)

**Scan QRIS di atas untuk berdonasi**

Setiap donasi akan digunakan untuk:
- Pengembangan fitur baru
- Perbaikan bug & maintenance
- Infrastruktur server

</div>