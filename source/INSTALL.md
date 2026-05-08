# Panduan Instalasi Sistem Informasi Buku Tamu Digital - Sibudi

Panduan ini untuk menjalankan aplikasi Sistem Informasi Buku Tamu Digital - Sibudi di Laragon atau local server Laravel.

## Kebutuhan

- PHP 8.3 atau lebih baru
- Composer
- MySQL atau MariaDB
- Laragon/XAMPP atau terminal biasa

## Langkah Instalasi

1. Masuk ke folder project Laravel.

```bash
cd c:\laragon\www\sibudi\source
```

2. Install dependency PHP.

```bash
composer install
```

3. Buat file environment.

```bash
copy .env.example .env
```

Jika file `.env` sudah ada, cukup edit isinya.

4. Generate application key.

```bash
php artisan key:generate
```

5. Buat database MySQL.

Contoh nama database:

```sql
CREATE DATABASE sibudi;
```

6. Atur koneksi database di file `.env`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sibudi
DB_USERNAME=root
DB_PASSWORD=
```

7. Jalankan migrasi database.

```bash
php artisan migrate
```

8. Jalankan seeder data contoh.

```bash
php artisan db:seed
```

Jika ingin reset database dari awal sekaligus isi data contoh:

```bash
php artisan migrate:fresh --seed
```

Seeder akan otomatis mengisi:

- Data buku tamu contoh
- Table `employment_statuses` berisi `PNS` dan `P3K`
- Table `bidangs` berisi daftar bidang
- Table `personils` berisi daftar nama ASN/P3K 2025

Jika hanya ingin mengisi ulang data PNS/P3K, bidang, dan nama tanpa reset database:

```bash
php artisan db:seed --class=PersonilSeeder
```

9. Buat link storage untuk menyimpan foto kamera.

```bash
php artisan storage:link
```

10. Jalankan server Laravel.

```bash
php artisan serve
```

11. Buka aplikasi.

```text
http://127.0.0.1:8000
```

## Login Admin

Aplikasi saat ini memakai login sederhana dari controller.

```text
Username: admin
Password: admin123
```

## Fitur Kamera

Form tambah tamu ada di:

```text
http://127.0.0.1:8000/guestbook/create
```

Form publik tanpa login untuk tamu isi sendiri ada di:

```text
http://127.0.0.1:8000/tamu
```

Klik tombol `Buka Kamera`, lalu izinkan akses kamera dari Windows/browser. Setelah foto diambil, gambar akan tersimpan saat form disubmit.

Foto tersimpan di:

```text
storage/app/public/guestbook-photos
```

Dan dapat diakses dari browser melalui:

```text
public/storage
```

## Perintah Yang Sering Dipakai

```bash
php artisan migrate
php artisan db:seed
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

## Catatan Troubleshooting

- Jika foto tidak muncul, jalankan ulang `php artisan storage:link`.
- Jika kamera tidak muncul, pastikan browser memberi izin kamera.
- Jika database error, cek nama database, username, dan password di `.env`.
- Jika perubahan belum terbaca, jalankan `php artisan optimize:clear`.
