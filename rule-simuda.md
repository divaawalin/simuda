# RULE-SIMUDA.md
# Sistem Informasi Manajemen Anggota dan Absensi (SIMUDA)
> Website Sistem Absensi untuk Organisasi berbasis Laravel

---

## 📌 DESKRIPSI UMUM

SIMUDA adalah sistem informasi berbasis web untuk manajemen absensi anggota organisasi. Sistem ini mendukung dua jenis role utama yaitu **Admin (mencakup Admin, Sekretaris, Ketua)** dan **Anggota**, dengan fitur absensi dua sesi (mulai & selesai), QR Code, dan manajemen konten organisasi.

---

## 🗂️ STRUKTUR ROLE

| Role        | Level | Keterangan                                      |
|-------------|-------|-------------------------------------------------|
| Admin       | 1     | Akses penuh ke seluruh fitur manajemen          |
| Sekretaris  | 2     | Akses manajemen kegiatan, anggota, absensi      |
| Ketua       | 3     | Akses lihat laporan, manajemen konten           |
| Anggota     | 4     | Hanya bisa melakukan absensi & lihat konten     |

> Semua role menggunakan **halaman login yang sama**. Sistem otomatis mendeteksi role dan mengarahkan ke dashboard masing-masing.

---

## 🗃️ DATABASE & MODEL

### Tabel: `users`
```
id, name, divisi, no_telp, email, password, alamat, foto_profile, role (admin/sekretaris/ketua/anggota), status (aktif/tidak_aktif), remember_token, created_at, updated_at
```

> - `role` untuk membedakan admin, sekretaris, ketua, anggota  
> - `status` hanya berlaku aktif untuk anggota (admin selalu aktif)  
> - `divisi` = jabatan/dapukan dalam organisasi

### Tabel: `kegiatan`
```
id, nama_kegiatan, deskripsi, tanggal, waktu_mulai, waktu_selesai, lokasi, status (draft/aktif/selesai), created_by, created_at, updated_at
```

### Tabel: `absensi_sesi`
```
id, kegiatan_id, tipe_sesi (mulai/selesai), metode (mandiri/qr_code), status_sesi (belum_mulai/berlangsung/selesai), qr_token, qr_expires_at, dimulai_oleh, dimulai_at, diselesaikan_oleh, diselesaikan_at, created_at, updated_at
```

### Tabel: `absensi_invite`
```
id, kegiatan_id, user_id (anggota yang diinvite), created_at, updated_at
```

### Tabel: `absensi`
```
id, kegiatan_id, absensi_sesi_id, user_id, tipe_sesi (mulai/selesai), waktu_absen, metode (mandiri/qr_code), status (hadir/tidak_hadir), created_at, updated_at
```

### Tabel: `konten`
```
id, nama_konten, deskripsi, tipe (gambar/file/link), file_path, link_url, created_by, created_at, updated_at
```

### Tabel: `password_reset_tokens`
```
email, token, created_at
```

---

## 🔐 AUTENTIKASI

### Login (Satu Halaman untuk Semua Role)
- Route: `GET|POST /login`
- Input: `email`, `password`
- Setelah login, sistem redirect berdasarkan role:
  - `admin / sekretaris / ketua` → `/admin/dashboard`
  - `anggota` → `/anggota/dashboard`

### Lupa Password
1. **Halaman Lupa Password**
   - Route: `GET|POST /lupa-password`
   - User input email yang terdaftar
   - Sistem kirim token reset ke email (atau tampilkan link langsung jika tanpa email service)
   - Jika email ditemukan → redirect ke halaman ubah password dengan token

2. **Halaman Ubah Password Baru**
   - Route: `GET|POST /reset-password/{token}`
   - Input: `password_baru`, `konfirmasi_password_baru`
   - Validasi token masih valid
   - Setelah berhasil → redirect ke `/login` dengan pesan sukses

### Logout
- Route: `POST /logout`

---

## 👤 DATA PENGGUNA

### Data Admin / Sekretaris / Ketua
| Field         | Tipe     | Keterangan                        |
|---------------|----------|-----------------------------------|
| nama          | string   | Nama lengkap                      |
| divisi        | string   | Divisi atau jabatan/dapukan       |
| no_telp       | string   | Nomor telepon                     |
| email         | string   | Email (unique, untuk login)       |
| password      | string   | Bcrypt hash                       |
| alamat        | text     | Alamat lengkap                    |
| foto_profile  | string   | Nama file foto (disimpan storage) |
| role          | enum     | admin / sekretaris / ketua        |

### Data Anggota
| Field          | Tipe     | Keterangan                         |
|----------------|----------|------------------------------------|
| nama           | string   | Nama lengkap                       |
| divisi         | string   | Divisi atau jabatan/dapukan        |
| no_telp        | string   | Nomor telepon                      |
| email          | string   | Email (unique, untuk login)        |
| password       | string   | Bcrypt hash                        |
| alamat         | text     | Alamat lengkap                     |
| foto_profile   | string   | Nama file foto (disimpan storage)  |
| role           | enum     | anggota                            |
| status         | enum     | aktif / tidak_aktif                |

---

## 🖥️ FITUR ADMIN (Admin / Sekretaris / Ketua)

### 1. Dashboard Admin
- Statistik: total anggota, total kegiatan, absensi hari ini
- Aktivitas terbaru

---

### 2. Manajemen Kegiatan
| Route                              | Method | Keterangan                  |
|------------------------------------|--------|-----------------------------|
| `/admin/kegiatan`                  | GET    | Daftar semua kegiatan       |
| `/admin/kegiatan/create`           | GET    | Form tambah kegiatan        |
| `/admin/kegiatan`                  | POST   | Simpan kegiatan baru        |
| `/admin/kegiatan/{id}/edit`        | GET    | Form edit kegiatan          |
| `/admin/kegiatan/{id}`             | PUT    | Update kegiatan             |
| `/admin/kegiatan/{id}`             | DELETE | Hapus kegiatan              |

**Field Kegiatan:** nama_kegiatan, deskripsi, tanggal, waktu_mulai, waktu_selesai, lokasi, status

---

### 3. Manajemen Anggota
| Route                              | Method | Keterangan                  |
|------------------------------------|--------|-----------------------------|
| `/admin/anggota`                   | GET    | Daftar semua anggota        |
| `/admin/anggota/create`            | GET    | Form tambah anggota         |
| `/admin/anggota`                   | POST   | Simpan anggota baru         |
| `/admin/anggota/{id}/edit`         | GET    | Form edit anggota           |
| `/admin/anggota/{id}`              | PUT    | Update data anggota         |
| `/admin/anggota/{id}`              | DELETE | Hapus anggota               |
| `/admin/anggota/{id}/toggle-status`| POST   | Aktif / nonaktifkan anggota |

---

### 4. Manajemen Absensi
#### Alur Lengkap:

**Step 1 — Pilih Kegiatan**
- Admin memilih kegiatan dari daftar kegiatan yang tersedia

**Step 2 — Invite Anggota**
- Admin memilih anggota mana saja yang dapat melakukan absensi pada kegiatan tersebut
- Anggota yang tidak diinvite tidak bisa absen pada kegiatan itu

**Step 3 — Kelola Sesi Absensi**
Setiap kegiatan memiliki **2 sesi absensi**:
- `Sesi Mulai` → absensi saat kegiatan dimulai
- `Sesi Selesai` → absensi saat kegiatan berakhir

Untuk setiap sesi, admin memilih metode:
- **Mandiri** → anggota absen langsung tanpa scan QR
- **QR Code** → sistem generate QR Code, anggota arahkan kamera ke layar/device admin

**Step 4 — Kontrol Sesi**
| Route                                          | Method | Keterangan                            |
|------------------------------------------------|--------|---------------------------------------|
| `/admin/absensi`                               | GET    | Pilih kegiatan                        |
| `/admin/absensi/{kegiatan_id}/invite`          | GET    | Halaman invite anggota                |
| `/admin/absensi/{kegiatan_id}/invite`          | POST   | Simpan daftar anggota yang diinvite   |
| `/admin/absensi/{kegiatan_id}/sesi`            | GET    | Halaman kelola sesi absensi           |
| `/admin/absensi/{kegiatan_id}/sesi/mulai`      | POST   | Mulai sesi absensi (mulai/selesai)    |
| `/admin/absensi/{kegiatan_id}/sesi/akhiri`     | POST   | Akhiri sesi absensi                   |
| `/admin/absensi/{kegiatan_id}/qr`              | GET    | Tampilkan QR Code (jika metode QR)    |
| `/admin/absensi/{kegiatan_id}/scan`            | POST   | Proses scan QR Code dari anggota      |
| `/admin/absensi/{kegiatan_id}/rekap`           | GET    | Rekap absensi kegiatan                |

**Logika Sesi:**
```
- Sesi Mulai: status_sesi = belum_mulai → (admin klik Mulai) → berlangsung → (admin klik Akhiri) → selesai
- Sesi Selesai: sama seperti sesi mulai, dilakukan setelah kegiatan selesai
- QR Token di-generate saat sesi dimulai dan expire setelah sesi diakhiri
```

---

### 5. Manajemen Admin (User Admin/Sekretaris/Ketua)
| Route                              | Method | Keterangan                          |
|------------------------------------|--------|-------------------------------------|
| `/admin/users`                     | GET    | Daftar admin, sekretaris, ketua     |
| `/admin/users/create`              | GET    | Form tambah user                    |
| `/admin/users`                     | POST   | Simpan user baru                    |
| `/admin/users/{id}/edit`           | GET    | Form edit user                      |
| `/admin/users/{id}`                | PUT    | Update user                         |
| `/admin/users/{id}`                | DELETE | Hapus user                          |

---

### 6. Manajemen Konten
| Route                              | Method | Keterangan                          |
|------------------------------------|--------|-------------------------------------|
| `/admin/konten`                    | GET    | Daftar semua konten                 |
| `/admin/konten/create`             | GET    | Form tambah konten                  |
| `/admin/konten`                    | POST   | Simpan konten baru                  |
| `/admin/konten/{id}/edit`          | GET    | Form edit konten                    |
| `/admin/konten/{id}`               | PUT    | Update konten                       |
| `/admin/konten/{id}`               | DELETE | Hapus konten                        |

**Tipe Konten:**
- `gambar` → upload file gambar
- `file` → upload file (pdf, doc, dll)
- `link` → input URL eksternal

**Field:** nama_konten, deskripsi, tipe, file/link

---

### 7. Pengaturan Profile (Admin)
| Route                              | Method | Keterangan                          |
|------------------------------------|--------|-------------------------------------|
| `/admin/profile`                   | GET    | Halaman profile admin               |
| `/admin/profile`                   | PUT    | Update profile admin                |
| `/admin/profile/password`          | PUT    | Ubah password admin                 |

---

## 📱 FITUR ANGGOTA

### 1. Beranda Anggota
- Route: `GET /anggota/dashboard`
- Menampilkan daftar konten yang telah ditambahkan admin
- Konten berupa gambar, file (download), atau link (buka tab baru)

---

### 2. Absensi Anggota
#### Alur:

**Step 1 — Pilih Kegiatan**
- Anggota hanya bisa melihat kegiatan di mana dirinya telah diinvite oleh admin
- Route: `GET /anggota/absensi`

**Step 2 — Pilih Sesi**
- Anggota memilih sesi: **Absen Mulai** atau **Absen Selesai**
- Sesi hanya bisa dilakukan jika admin sudah memulai sesi tersebut (`status_sesi = berlangsung`)

**Step 3 — Lakukan Absensi**

**Metode Mandiri:**
- Anggota klik tombol "Absen Sekarang"
- Sistem catat waktu absensi
- Route: `POST /anggota/absensi/{kegiatan_id}/absen`

**Metode QR Code:**
- Tampilan halaman anggota otomatis generate QR Code unik milik anggota tersebut
- Anggota **mengarahkan QR Code dari layar device-nya** ke kamera scanner yang ada di device admin
- Admin yang melakukan scan di halamannya
- Setelah scan berhasil, absensi tercatat
- Route QR anggota: `GET /anggota/absensi/{kegiatan_id}/qr`

| Route                                        | Method | Keterangan                              |
|----------------------------------------------|--------|-----------------------------------------|
| `/anggota/absensi`                           | GET    | Daftar kegiatan yang bisa diabsen       |
| `/anggota/absensi/{kegiatan_id}`             | GET    | Detail sesi absensi kegiatan            |
| `/anggota/absensi/{kegiatan_id}/qr`          | GET    | Tampilkan QR Code anggota               |
| `/anggota/absensi/{kegiatan_id}/absen`       | POST   | Submit absen mandiri                    |

---

### 3. Pengaturan Profile (Anggota)
| Route                              | Method | Keterangan                          |
|------------------------------------|--------|-------------------------------------|
| `/anggota/profile`                 | GET    | Halaman profile anggota             |
| `/anggota/profile`                 | PUT    | Update profile anggota              |
| `/anggota/profile/password`        | PUT    | Ubah password anggota               |

---

## 🗄️ PENYIMPANAN FILE (TANPA STORAGE LINK)

### Konfigurasi `filesystems.php`

Tambahkan disk custom untuk setiap jenis file:

```php
'disks' => [
    // ... disk lainnya ...

    'profiles' => [
        'driver' => 'local',
        'root' => storage_path('profiles'),
    ],

    'konten' => [
        'driver' => 'local',
        'root' => storage_path('konten'),
    ],
],
```

> File disimpan di dalam `storage/` Laravel (bukan `public/`), sehingga **tidak perlu `php artisan storage:link`**.

---

### Struktur Folder Storage

```
C:\xampp\htdocs\simuda\storage\
├── profiles\          ← foto profile user (admin & anggota)
└── konten\            ← file konten (gambar/file)
```

---

### Route untuk Menampilkan Gambar

Tambahkan di `routes/web.php`:

```php
use Illuminate\Support\Facades\File;

// Route foto profile
Route::get('/storage/profiles/{filename}', function ($filename) {
    $path = storage_path('profiles/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    return response($file, 200)->header('Content-Type', $type);
})->name('storage.profiles');

// Route file konten (gambar/file)
Route::get('/storage/konten/{filename}', function ($filename) {
    $path = storage_path('konten/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    return response($file, 200)->header('Content-Type', $type);
})->name('storage.konten');
```

---

### Contoh Controller — Upload Foto Profile

```php
// Upload foto profile
if ($request->hasFile('foto_profile')) {
    // Hapus foto lama jika ada
    if ($user->foto_profile && file_exists(storage_path('profiles/' . $user->foto_profile))) {
        unlink(storage_path('profiles/' . $user->foto_profile));
    }
    $file = $request->file('foto_profile');
    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    $file->move(storage_path('profiles'), $fileName);
    $data['foto_profile'] = $fileName;
}
```

### Contoh Controller — Upload File Konten

```php
// Upload file konten (gambar atau file)
if ($request->hasFile('file_konten')) {
    if ($konten->file_path && file_exists(storage_path('konten/' . $konten->file_path))) {
        unlink(storage_path('konten/' . $konten->file_path));
    }
    $file = $request->file('file_konten');
    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    $file->move(storage_path('konten'), $fileName);
    $data['file_path'] = $fileName;
}
```

### Penggunaan di Blade (View)

```blade
{{-- Foto Profile --}}
<img src="{{ route('storage.profiles', $user->foto_profile) }}" alt="Foto Profile">

{{-- Konten Gambar --}}
<img src="{{ route('storage.konten', $konten->file_path) }}" alt="{{ $konten->nama_konten }}">

{{-- Konten File (Download) --}}
<a href="{{ route('storage.konten', $konten->file_path) }}" download>Download File</a>

{{-- Konten Link --}}
<a href="{{ $konten->link_url }}" target="_blank">Buka Link</a>
```

---

## 🔒 MIDDLEWARE & PROTEKSI ROUTE

```php
// Middleware yang diperlukan
'auth'          // Harus login
'role:admin'    // Hanya admin
'role:anggota'  // Hanya anggota
'role:admin,sekretaris,ketua' // Admin + Sekretaris + Ketua
```

### Grup Route

```php
// Guest only
Route::middleware('guest')->group(function () {
    Route::get('/login', ...);
    Route::post('/login', ...);
    Route::get('/lupa-password', ...);
    Route::post('/lupa-password', ...);
    Route::get('/reset-password/{token}', ...);
    Route::post('/reset-password/{token}', ...);
});

// Admin Area
Route::middleware(['auth', 'role:admin,sekretaris,ketua'])->prefix('admin')->group(function () {
    Route::get('/dashboard', ...);
    Route::resource('/kegiatan', KegiatanController::class);
    Route::resource('/anggota', AnggotaController::class);
    Route::resource('/konten', KontenController::class);
    Route::resource('/users', UserAdminController::class);
    // Absensi routes...
    // Profile routes...
});

// Anggota Area
Route::middleware(['auth', 'role:anggota'])->prefix('anggota')->group(function () {
    Route::get('/dashboard', ...);
    // Absensi routes...
    // Profile routes...
});
```

---

## 🔄 ALUR SISTEM ABSENSI (RINGKASAN)

```
ADMIN:
1. Buat Kegiatan
2. Buka Manajemen Absensi → Pilih Kegiatan
3. Invite Anggota yang bisa absen
4. Pilih Sesi (Mulai / Selesai) & Metode (Mandiri / QR Code)
5. Klik "Mulai Sesi" → sesi status = berlangsung
6. [Jika QR] Tampilkan QR Scanner di device admin
7. Klik "Akhiri Sesi" → sesi status = selesai

ANGGOTA:
1. Login → masuk halaman beranda (lihat konten)
2. Buka menu Absensi → Pilih Kegiatan
3. Pilih Sesi (Mulai / Selesai) — hanya aktif jika admin sudah mulai
4. [Jika Mandiri] Klik "Absen Sekarang"
5. [Jika QR] Tampilkan QR Code anggota → arahkan ke scanner admin
```

---

## 📋 DAFTAR CONTROLLER

| Controller                  | Keterangan                              |
|-----------------------------|-----------------------------------------|
| `AuthController`            | Login, logout, lupa password, reset     |
| `AdminDashboardController`  | Dashboard admin                         |
| `KegiatanController`        | CRUD kegiatan                           |
| `AnggotaController`         | CRUD anggota + toggle status            |
| `AbsensiController`         | Kelola sesi, invite, QR, rekap          |
| `UserAdminController`       | CRUD user admin/sekretaris/ketua        |
| `KontenController`          | CRUD konten (gambar/file/link)          |
| `ProfileController`         | Update profile & password               |
| `AnggotaDashboardController`| Dashboard & absensi anggota             |

---

## 📦 PACKAGE / LIBRARY TAMBAHAN

| Package                    | Kegunaan                                |
|----------------------------|-----------------------------------------|
| `simplesoftwareio/simple-qrcode` | Generate QR Code                 |
| `intervention/image`       | Resize/compress foto profile (opsional) |

**Install:**
```bash
composer require simplesoftwareio/simple-qrcode
composer require intervention/image
```

---

## 📁 STRUKTUR FOLDER VIEW

```
resources/views/
├── auth/
│   ├── login.blade.php
│   ├── lupa-password.blade.php
│   └── reset-password.blade.php
├── admin/
│   ├── dashboard.blade.php
│   ├── kegiatan/
│   ├── anggota/
│   ├── absensi/
│   │   ├── index.blade.php       (pilih kegiatan)
│   │   ├── invite.blade.php      (invite anggota)
│   │   ├── sesi.blade.php        (kelola sesi)
│   │   ├── qr-scanner.blade.php  (scan qr anggota)
│   │   └── rekap.blade.php
│   ├── users/
│   ├── konten/
│   └── profile/
└── anggota/
    ├── dashboard.blade.php
    ├── absensi/
    │   ├── index.blade.php       (pilih kegiatan)
    │   ├── sesi.blade.php        (pilih sesi)
    │   └── qr.blade.php          (tampil qr anggota)
    └── profile/
```

---

*Rule SIMUDA — Versi 1.0 | Laravel Framework*
