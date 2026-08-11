# SIM-MAGANG (Sistem Informasi Manajemen Magang dan PKL)

SIM-MAGANG adalah portal digital terpadu untuk pendaftaran, verifikasi, penempatan, evaluasi, hingga penyelesaian program magang/PKL di **Balai Besar Pengujian Standar Instrumen Bioteknologi (BB-Biogen), Kementerian Pertanian RI**.

Sistem ini didesain menggunakan **Laravel 13**, **Tailwind CSS**, **Alpine.js**, dan **Spatie Permission** untuk mempermudah operasional secara digital dan paperless.

---

## Fitur Utama

- **Landing Page & Pendaftaran Mandiri**: Alur pengisian career form interaktif 4 step (pilihan jenjang Siswa/Mahasiswa, bidang penempatan, tanggal mulai dengan rolling slot dinamis, isi kuesioner SKM, dan unggah surat pengantar).
- **Verifikasi Berkas Operasional**: Petugas memverifikasi kelengkapan dokumen pendaftaran (Setujui/Tolak dengan catatan revisi).
- **Penempatan Bidang Rolling Capacity**: Menghitung kuota ketersediaan slot bidang secara real-time berbasis tanggal untuk menghindari tumpang tindih berlebih.
- **Siklus Status Otomatis**: Scheduler harian memproses transisi status (`Disetujui` -> `Terjadwal` -> `Sedang Magang`), mengirim reminder laporan terlambat, dan menghitung badge peringatan.
- **Review Laporan & Sertifikat Kelulusan**: Peserta mengunggah laporan PDF. Staf mengulas dokumen, menerbitkan sertifikat kelulusan formal (.pdf), dan mengubah status menjadi `Selesai`.
- **Indeks Kepuasan Masyarakat (IKM/SKM)**: Survei kepuasan dengan visualisasi diagram lingkaran (Pie Chart) interaktif di dashboard Admin.
- **Modul Administrator & Laporan**: Manajemen hak akses user, konfigurasi kuesioner SKM, serta ekspor rekapitulasi tahunan dalam format PDF, Excel (.xlsx), dan CSV.
- **Keamanan Ketat**: Proteksi IDOR pada unduhan dokumen via UUID (`public_id`), validasi double MIME-sniffing file, dan rate limiting login per IP.

---

## Persyaratan Sistem

- **PHP** >= 8.2
- **Composer** (untuk dependensi PHP)
- **Node.js** & **NPM** (untuk aset frontend)
- **MySQL** atau **MariaDB**

---

## Panduan Instalasi Lokal

### 1. Kloning & Persiapan Dependensi
```bash
# Install package PHP
composer install

# Install package Node
npm install
```

### 2. Konfigurasi Environment
Salin file `.env.example` menjadi `.env` lalu sesuaikan konfigurasi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=brmp_biogen
DB_USERNAME=root
DB_PASSWORD=

# Gunakan database driver untuk queue
QUEUE_CONNECTION=database
```

### 3. Migrasi & Seeding Database
Jalankan perintah Artisan berikut untuk membuat tabel dan mengisi data contoh bawaan:
```bash
# Generate key aplikasi
php artisan key:generate

# Migrasi fresh disertai seeder
php artisan migrate:fresh --seed
```

### 4. Compile Asset & Jalankan Server
Kompilasi asset frontend menggunakan Vite dan jalankan server lokal:
```bash
# Compile asset produksi
npm run build

# Jalankan server lokal
php artisan serve
```
Aplikasi kini dapat diakses di browser melalui URL: `http://127.0.0.1:8000`

---

## Data Kredensial Uji Coba (Seed Data)

Semua akun default menggunakan password: `password`

1. **Administrator**
   - Email: `admin@biogen.com`
2. **Petugas Operasional (Staf)**
   - Email: `petugas@biogen.com`
   - Email: `petugas2@biogen.com`
3. **Pengguna (Peserta/Pemohon)**
   - Email: `pengguna@biogen.com` (Jenjang Mahasiswa)
   - Email: `pengguna2@biogen.com` (Jenjang Siswa)

---

## Panduan Deployment ke Hostinger Shared Hosting (Tanpa SSH)

Hostinger plan shared hosting memiliki keterbatasan tidak tersedianya akses terminal SSH. Ikuti langkah di bawah ini untuk deploy:

### 1. Build Lokal Sebelum Upload
Jalankan kompilasi aset dan persiapkan folder vendor secara lokal sebelum diunggah:
```bash
composer install --no-dev --optimize-autoloader
npm run build
```
Kompres folder proyek Anda menjadi file `.zip` (pastikan menyertakan folder `vendor/` dan `public/build/`), lalu unggah ke File Manager Hostinger.

### 2. Jalankan Migrasi & Storage Link Melalui Browser
Karena keterbatasan akses SSH, kami menyediakan route khusus yang dilindungi token rahasia untuk memicu database migrations dan pembuatan link penyimpanan:

Akses URL berikut pada browser Anda:
```
http://domain-magang-anda.com/deploy-migrations-and-links/brmp-biogen-deploy-token-2026
```
Rute ini akan memicu `migrate --force` dan `storage:link`, lalu mengembalikan respon JSON berisi detail log sukses eksekusi.

### 3. Konfigurasi Queue & Cron Job di hPanel Hostinger
Agar email dan transisi status otomatis berjalan di shared hosting tanpa menjalankan queue worker daemon:

1. Masuk ke **hPanel Hostinger** -> **Cron Jobs**.
2. Daftarkan cron job baru untuk memicu scheduler Laravel setiap menit:
   ```bash
   * * * * * /usr/bin/php /home/uXXXXX/domains/domain-anda.com/artisan schedule:run >> /dev/null 2>&1
   ```
3. Sistem secara otomatis akan menjalankan antrean melalui scheduler yang sudah dikonfigurasi di `routes/console.php`:
   - Transisi status & reminder telat lapor berjalan otomatis harian (`daily`).
   - Email queue worker dijalankan hemat memori tiap menit dengan perintah `queue:work --stop-when-empty --without-overlapping`.

---

## Pengujian Fitur (Test Suite)

Untuk menjalankan seluruh unit & feature test otomatis (59 test, 238 assertion) guna memverifikasi stabilitas sistem:
```bash
php artisan test
```
