# Sistem Informasi Buku Tamu Digital - Sibudi

Sistem Informasi Buku Tamu Digital - Sibudi adalah aplikasi buku tamu berbasis Laravel untuk mencatat data kunjungan, export CSV, dan foto tamu dari kamera browser/Windows.

## Fitur

- Login admin sederhana
- CRUD data tamu
- Halaman publik untuk tamu isi sendiri tanpa login
- Ambil foto tamu dari kamera
- Preview foto di daftar tamu
- Export data ke CSV
- Seeder data contoh
- Panduan instalasi lokal

## Kebutuhan

- PHP 8.3 atau lebih baru
- Composer
- MySQL atau MariaDB
- Laragon, XAMPP, atau terminal biasa

## Instalasi

1. Clone repository.

```bash
git clone git@github.com:farrasrayhand/sibudi.git
cd sibudi/source
```

Jika memakai HTTPS:

```bash
git clone https://github.com/farrasrayhand/sibudi.git
cd sibudi/source
```

2. Install dependency PHP.

```bash
composer install
```

3. Buat file `.env`.

Windows:

```bash
copy .env.example .env
```

Linux/macOS:

```bash
cp .env.example .env
```

4. Generate application key.

```bash
php artisan key:generate
```

5. Buat database MySQL.

```sql
CREATE DATABASE sibudi;
```

6. Atur koneksi database di `.env`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sibudi
DB_USERNAME=root
DB_PASSWORD=
```

7. Jalankan migrasi dan seeder.

```bash
php artisan migrate:fresh --seed
```

8. Buat storage link untuk file foto.

```bash
php artisan storage:link
```

9. Jalankan aplikasi.

```bash
php artisan serve
```

10. Buka aplikasi di browser.

```text
http://127.0.0.1:8000
```

## Login Admin

```text
Username: admin
Password: admin123
```

## Halaman Penting

```text
Login:        http://127.0.0.1:8000/login
Daftar tamu:  http://127.0.0.1:8000/guestbook
Tambah tamu:  http://127.0.0.1:8000/guestbook/create
Form publik:  http://127.0.0.1:8000/tamu
```

## Fitur Kamera

Pada halaman tambah tamu, klik tombol `Buka Kamera`. Browser akan meminta izin kamera dari Windows. Setelah foto diambil, foto akan tersimpan saat form disubmit.

Lokasi file foto:

```text
source/storage/app/public/guestbook-photos
```

URL publiknya melalui:

```text
source/public/storage
```

## Perintah Yang Sering Dipakai

```bash
php artisan migrate
php artisan db:seed
php artisan migrate:fresh --seed
php artisan storage:link
php artisan optimize:clear
php artisan serve
```

## Struktur Project

```text
sibudi/
+-- index.php
+-- README.md
`-- source/
    +-- app/
    +-- database/
    +-- resources/
    +-- routes/
    `-- INSTALL.md
```

## Troubleshooting

- Jika foto tidak muncul, jalankan `php artisan storage:link`.
- Jika kamera tidak muncul, pastikan browser memberi izin kamera.
- Jika database error, cek konfigurasi database di `.env`.
- Jika tampilan/perubahan belum terbaca, jalankan `php artisan optimize:clear`.
- Jika port `8000` sedang dipakai, jalankan `php artisan serve --port=8001`.

## Catatan

File `.env`, `vendor`, `node_modules`, dan file cache tidak ikut dipush ke GitHub. Jalankan `composer install` setelah clone repository.
