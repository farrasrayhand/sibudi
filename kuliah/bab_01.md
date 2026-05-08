# BAB I
# Pendahuluan dan Analisis Sistem

## 1.1 Latar Belakang

Perkembangan teknologi informasi membuat proses administrasi menjadi lebih cepat, rapi, dan mudah ditelusuri. Salah satu proses administrasi yang masih sering dilakukan secara manual adalah pencatatan buku tamu. Pada sistem manual, data tamu biasanya ditulis di buku fisik sehingga rawan hilang, sulit dicari, dan kurang praktis ketika data perlu direkap.

Aplikasi SIBUDI atau Sistem Buku Tamu Digital dibuat untuk membantu proses pencatatan kunjungan tamu secara digital. Aplikasi ini berbasis web menggunakan Laravel, sehingga dapat diakses melalui browser. Data tamu dapat dicatat oleh admin maupun oleh tamu secara mandiri melalui halaman publik. Selain data teks seperti nama, email, telepon, organisasi, tanggal kunjungan, dan pesan, aplikasi juga mendukung pengambilan foto tamu menggunakan kamera perangkat.

Dengan adanya aplikasi ini, proses pencatatan tamu menjadi lebih efisien. Admin dapat melihat daftar tamu, mengubah data, menghapus data, mengatur status kunjungan, serta mengekspor data ke format CSV.

## 1.2 Rumusan Masalah

Berdasarkan latar belakang tersebut, rumusan masalah dalam pengembangan aplikasi ini adalah:

1. Bagaimana membuat sistem buku tamu digital berbasis web?
2. Bagaimana menyediakan form pengisian data tamu untuk admin dan untuk tamu tanpa login?
3. Bagaimana menyimpan data tamu ke database secara terstruktur?
4. Bagaimana menambahkan fitur pengambilan foto melalui kamera browser?
5. Bagaimana menyediakan fitur pengelolaan data tamu untuk admin?

## 1.3 Tujuan

Tujuan pengembangan aplikasi SIBUDI adalah:

1. Membuat aplikasi buku tamu digital berbasis Laravel.
2. Menyediakan fitur login admin.
3. Menyediakan fitur CRUD data tamu.
4. Menyediakan halaman publik `/tamu` agar tamu dapat mengisi data sendiri tanpa login.
5. Menyediakan fitur foto tamu dari kamera.
6. Menyediakan fitur export data tamu ke CSV.
7. Menyediakan migrasi, seeder, dan panduan instalasi agar aplikasi mudah dipasang ulang.

## 1.4 Batasan Masalah

Batasan masalah pada aplikasi ini adalah:

1. Login admin masih menggunakan validasi sederhana di controller, yaitu username `admin` dan password `admin123`.
2. Data yang dikelola berfokus pada data tamu, bukan sistem manajemen pengguna yang lengkap.
3. Foto tamu disimpan di storage publik Laravel.
4. Export data menggunakan format CSV.
5. Aplikasi ditujukan untuk berjalan di local server seperti Laragon atau XAMPP.

## 1.5 Metode Pengembangan

Metode pengembangan yang digunakan adalah pendekatan sederhana berbasis tahapan:

1. Analisis kebutuhan sistem.
2. Perancangan database dan alur aplikasi.
3. Implementasi route, controller, model, view, migrasi, dan seeder.
4. Pengujian fitur utama melalui route Laravel.
5. Penyusunan dokumentasi instalasi.

## 1.6 Teknologi Yang Digunakan

Teknologi yang digunakan pada aplikasi SIBUDI adalah:

| Teknologi | Keterangan |
| --- | --- |
| PHP | Bahasa pemrograman backend |
| Laravel | Framework utama aplikasi |
| MySQL/MariaDB | Database penyimpanan data |
| Blade | Template engine Laravel |
| Bootstrap | Framework tampilan antarmuka |
| Bootstrap Icons | Ikon pada tombol dan tampilan |
| JavaScript | Mengakses kamera browser dan mengambil foto |
| Composer | Manajemen dependency PHP |

## 1.7 Analisis Kebutuhan Sistem

### 1.7.1 Kebutuhan Fungsional

Kebutuhan fungsional aplikasi adalah:

1. Sistem dapat menampilkan halaman login admin.
2. Admin dapat login menggunakan username dan password.
3. Admin dapat melihat daftar tamu.
4. Admin dapat menambahkan data tamu.
5. Admin dapat mengubah data tamu.
6. Admin dapat menghapus data tamu.
7. Admin dapat mengekspor data tamu ke CSV.
8. Tamu dapat mengisi data sendiri melalui route `/tamu` tanpa login.
9. Sistem dapat mengambil foto tamu dari kamera browser.
10. Sistem dapat menyimpan data tamu ke database.

### 1.7.2 Kebutuhan Non-Fungsional

Kebutuhan non-fungsional aplikasi adalah:

1. Aplikasi mudah dijalankan di local server.
2. Struktur kode mengikuti pola Laravel MVC.
3. Form memiliki validasi agar data yang masuk sesuai kebutuhan.
4. File foto disimpan di storage Laravel.
5. Panduan instalasi tersedia agar aplikasi mudah dipasang ulang.

## 1.8 Analisis Struktur Project

Project Laravel berada pada folder:

```text
C:\laragon\www\sibudi\source
```

Struktur folder penting pada aplikasi:

```text
source/
+-- app/
|   +-- Http/Controllers/
|   +-- Models/
+-- database/
|   +-- migrations/
|   +-- seeders/
+-- resources/
|   +-- views/
+-- routes/
|   `-- web.php
+-- public/
+-- storage/
```

Penjelasan:

| Folder/File | Fungsi |
| --- | --- |
| `routes/web.php` | Mendefinisikan alamat URL aplikasi |
| `app/Http/Controllers` | Berisi logic aplikasi |
| `app/Models/Guestbook.php` | Model data tamu |
| `database/migrations` | Struktur tabel database |
| `database/seeders` | Data awal atau data contoh |
| `resources/views` | Tampilan halaman Blade |
| `storage/app/public` | Lokasi penyimpanan foto |
| `public/storage` | Link publik agar foto dapat diakses browser |

## 1.9 Kesimpulan Bab I

Pada bab ini dijelaskan bahwa SIBUDI adalah aplikasi buku tamu digital berbasis Laravel. Aplikasi ini dibuat untuk menggantikan pencatatan tamu manual menjadi pencatatan digital yang lebih rapi. Sistem memiliki fitur login admin, CRUD data tamu, form publik tanpa login, pengambilan foto dari kamera, export CSV, migrasi database, seeder, dan dokumentasi instalasi.
