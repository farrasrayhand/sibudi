# BAB II
# Perancangan Sistem dan Database

## 2.1 Gambaran Umum Sistem

SIBUDI menggunakan konsep MVC atau Model View Controller yang merupakan pola umum pada framework Laravel. Pola ini memisahkan aplikasi menjadi tiga bagian utama:

1. Model untuk mengelola data.
2. View untuk menampilkan halaman.
3. Controller untuk mengatur proses bisnis aplikasi.

Pada aplikasi ini, data utama yang dikelola adalah data tamu. Data tersebut disimpan pada tabel `guestbooks`. Admin dapat mengelola data melalui route `/guestbook`, sedangkan tamu dapat mengisi data sendiri melalui route `/tamu`.

## 2.2 Perancangan Alur Sistem

### 2.2.1 Alur Admin

Alur penggunaan oleh admin adalah:

1. Admin membuka halaman `/login`.
2. Admin mengisi username dan password.
3. Jika login berhasil, admin diarahkan ke halaman daftar tamu.
4. Admin dapat melihat, menambah, mengubah, menghapus, dan mengekspor data tamu.
5. Admin dapat logout dari sistem.

Alur sederhana:

```text
Login -> Daftar Tamu -> Tambah/Edit/Hapus/Export -> Logout
```

### 2.2.2 Alur Tamu Publik

Alur penggunaan oleh tamu adalah:

1. Tamu membuka halaman `/tamu`.
2. Tamu mengisi data diri dan keperluan kunjungan.
3. Tamu dapat mengambil foto menggunakan kamera.
4. Tamu menekan tombol simpan.
5. Sistem menyimpan data dengan status awal `pending`.
6. Sistem menampilkan pesan bahwa data berhasil dikirim.

Alur sederhana:

```text
Buka /tamu -> Isi Form -> Ambil Foto -> Simpan -> Data Masuk Database
```

## 2.3 Perancangan Route

Route aplikasi berada di file:

```text
source/routes/web.php
```

Daftar route utama:

| Method | URL | Nama Route | Fungsi |
| --- | --- | --- | --- |
| GET | `/` | `home` | Redirect ke login atau daftar tamu |
| GET | `/login` | `login` | Menampilkan form login |
| POST | `/login` | `login.store` | Memproses login |
| POST | `/logout` | `logout` | Memproses logout |
| GET | `/tamu` | `tamu.create` | Menampilkan form tamu publik |
| POST | `/tamu` | `tamu.store` | Menyimpan data dari form publik |
| GET | `/guestbook` | `guestbook.index` | Menampilkan daftar tamu admin |
| GET | `/guestbook/create` | `guestbook.create` | Menampilkan form tambah tamu admin |
| POST | `/guestbook` | `guestbook.store` | Menyimpan data tamu dari admin |
| GET | `/guestbook/{id}/edit` | `guestbook.edit` | Menampilkan form edit |
| PUT | `/guestbook/{id}` | `guestbook.update` | Memperbarui data tamu |
| DELETE | `/guestbook/{id}` | `guestbook.destroy` | Menghapus data tamu |
| GET | `/guestbook/export` | `guestbook.export` | Mengekspor data ke CSV |

Perbedaan penting:

1. Route `/tamu` tidak memerlukan login.
2. Route `/guestbook/*` memerlukan session admin.

## 2.4 Perancangan Controller

Controller utama yang digunakan adalah:

```text
source/app/Http/Controllers/GuestbookController.php
source/app/Http/Controllers/AuthController.php
```

### 2.4.1 AuthController

`AuthController` menangani proses login dan logout admin.

Method penting:

| Method | Fungsi |
| --- | --- |
| `showLogin()` | Menampilkan halaman login |
| `login()` | Memvalidasi username dan password |
| `logout()` | Menghapus session login |

Login menggunakan pengecekan sederhana:

```text
Username: admin
Password: admin123
```

Jika login berhasil, session berikut disimpan:

```php
session(['admin_logged_in' => true, 'admin_name' => 'Administrator']);
```

### 2.4.2 GuestbookController

`GuestbookController` menangani seluruh proses data tamu.

Method penting:

| Method | Fungsi |
| --- | --- |
| `index()` | Menampilkan daftar tamu |
| `create()` | Menampilkan form tambah data admin |
| `store()` | Menyimpan data dari admin |
| `publicCreate()` | Menampilkan form publik `/tamu` |
| `publicStore()` | Menyimpan data dari form publik |
| `edit()` | Menampilkan form edit |
| `update()` | Memperbarui data |
| `destroy()` | Menghapus data |
| `export()` | Export data ke CSV |
| `createGuestbook()` | Validasi dan penyimpanan data tamu |
| `storeCameraPhoto()` | Menyimpan foto base64 ke storage |
| `ensureAdmin()` | Mengecek session admin |

## 2.5 Perancangan Model

Model data tamu berada di:

```text
source/app/Models/Guestbook.php
```

Model ini menggunakan Eloquent ORM. Field yang dapat diisi massal didefinisikan pada `$fillable`:

```php
protected $fillable = [
    'name',
    'email',
    'phone',
    'organization',
    'visit_date',
    'message',
    'photo',
    'status',
];
```

Artinya Laravel mengizinkan field tersebut disimpan melalui method seperti `Guestbook::create($data)`.

## 2.6 Perancangan Database

Tabel utama aplikasi adalah `guestbooks`. Struktur tabel dibuat melalui migrasi:

```text
source/database/migrations/2026_05_08_080514_create_guestbooks_table.php
```

Struktur tabel:

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id` | bigint | Primary key |
| `name` | string | Nama lengkap tamu |
| `email` | string | Email tamu |
| `phone` | string | Nomor telepon |
| `organization` | string | Instansi/perusahaan |
| `visit_date` | date | Tanggal kunjungan |
| `message` | text | Keperluan atau pesan |
| `photo` | string nullable | Path foto tamu |
| `status` | string | Status data, default `pending` |
| `created_at` | timestamp | Waktu data dibuat |
| `updated_at` | timestamp | Waktu data diperbarui |

Status tamu memiliki tiga kemungkinan:

| Status | Keterangan |
| --- | --- |
| `pending` | Data baru atau belum diproses |
| `approved` | Data disetujui |
| `rejected` | Data ditolak |

## 2.7 Perancangan Seeder

Seeder digunakan untuk mengisi data contoh ke database. File seeder utama:

```text
source/database/seeders/GuestbookSeeder.php
```

Seeder membuat tiga data contoh:

1. Budi Santoso dari Dinas Pendidikan.
2. Siti Aminah dari PT Nusantara Digital.
3. Andi Pratama dari Universitas Merdeka.

Seeder menggunakan `updateOrCreate()`, sehingga aman dijalankan berulang karena data dengan email yang sama akan diperbarui, bukan selalu dibuat baru.

## 2.8 Perancangan Tampilan

View aplikasi berada pada folder:

```text
source/resources/views
```

View penting:

| View | Fungsi |
| --- | --- |
| `layouts/app.blade.php` | Layout utama aplikasi |
| `auth/login.blade.php` | Halaman login admin |
| `guestbook/index.blade.php` | Daftar data tamu |
| `guestbook/create.blade.php` | Form tambah data dan form publik |
| `guestbook/edit.blade.php` | Form edit data |

Form `guestbook/create.blade.php` digunakan untuk dua kebutuhan:

1. Admin menambah data melalui `/guestbook/create`.
2. Tamu mengisi data melalui `/tamu`.

Perbedaannya dikendalikan oleh variabel:

| Variabel | Fungsi |
| --- | --- |
| `$formAction` | Menentukan tujuan submit form |
| `$isPublicGuestForm` | Menentukan apakah form publik atau admin |
| `$pageTitle` | Menentukan judul halaman |

## 2.9 Perancangan Fitur Kamera

Fitur kamera dibuat menggunakan JavaScript browser dengan API:

```javascript
navigator.mediaDevices.getUserMedia()
```

Alur kerja kamera:

1. User menekan tombol `Buka Kamera`.
2. Browser meminta izin kamera.
3. Video kamera ditampilkan pada elemen `<video>`.
4. User menekan tombol `Ambil Foto`.
5. Gambar dari video digambar ke `<canvas>`.
6. Canvas diubah menjadi data base64.
7. Data base64 disimpan ke input hidden `photo`.
8. Saat form disubmit, controller menyimpan foto ke storage.

Foto disimpan di:

```text
storage/app/public/guestbook-photos
```

Agar foto dapat diakses browser, Laravel membutuhkan:

```bash
php artisan storage:link
```

## 2.10 Kesimpulan Bab II

Pada bab ini dijelaskan rancangan aplikasi SIBUDI. Sistem menggunakan pola MVC Laravel, memiliki route admin dan route publik, menggunakan tabel `guestbooks`, serta memiliki fitur kamera yang terhubung dengan penyimpanan foto. Perancangan ini menjadi dasar implementasi aplikasi pada bab berikutnya.
