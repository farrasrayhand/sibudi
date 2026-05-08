# BAB III
# Implementasi, Pengujian, dan Panduan Instalasi

## 3.1 Implementasi Aplikasi

Implementasi aplikasi SIBUDI dilakukan menggunakan framework Laravel. Project utama berada pada folder:

```text
C:\laragon\www\sibudi\source
```

Fitur yang sudah diimplementasikan meliputi:

1. Login admin.
2. Daftar data tamu.
3. Tambah data tamu.
4. Edit data tamu.
5. Hapus data tamu.
6. Form publik tanpa login melalui `/tamu`.
7. Pengambilan foto dari kamera browser.
8. Penyimpanan foto ke storage Laravel.
9. Export data tamu ke CSV.
10. Migrasi dan seeder database.

## 3.2 Implementasi Route

Route didefinisikan di:

```text
source/routes/web.php
```

Contoh implementasi route publik:

```php
Route::get('/tamu', [GuestbookController::class, 'publicCreate'])->name('tamu.create');
Route::post('/tamu', [GuestbookController::class, 'publicStore'])->name('tamu.store');
```

Route tersebut membuat halaman `/tamu` dapat diakses tanpa login. Halaman ini digunakan oleh tamu untuk mengisi data secara mandiri.

Contoh route admin:

```php
Route::get('/guestbook', [GuestbookController::class, 'index'])->name('guestbook.index');
Route::get('/guestbook/create', [GuestbookController::class, 'create'])->name('guestbook.create');
Route::post('/guestbook', [GuestbookController::class, 'store'])->name('guestbook.store');
```

Route admin tetap dilindungi oleh pengecekan session melalui method `ensureAdmin()`.

## 3.3 Implementasi Login Admin

Login admin dibuat pada `AuthController`.

File:

```text
source/app/Http/Controllers/AuthController.php
```

Login menggunakan validasi sederhana:

```php
if ($request->username === 'admin' && $request->password === 'admin123') {
    session(['admin_logged_in' => true, 'admin_name' => 'Administrator']);
    return redirect()->route('guestbook.index')->with('success', 'Login berhasil');
}
```

Jika username dan password benar, sistem menyimpan session. Session ini digunakan untuk menentukan apakah admin boleh membuka halaman pengelolaan tamu.

## 3.4 Implementasi CRUD Data Tamu

CRUD data tamu dibuat pada `GuestbookController`.

File:

```text
source/app/Http/Controllers/GuestbookController.php
```

### 3.4.1 Menampilkan Data

Method `index()` mengambil data tamu dari database:

```php
$guestbooks = Guestbook::orderBy('visit_date', 'desc')->paginate(10);
return view('guestbook.index', compact('guestbooks'));
```

Data ditampilkan dalam tabel pada view:

```text
source/resources/views/guestbook/index.blade.php
```

### 3.4.2 Menambah Data

Data tamu dapat ditambahkan melalui dua cara:

1. Admin melalui `/guestbook/create`.
2. Tamu melalui `/tamu`.

Keduanya menggunakan logic penyimpanan yang sama, yaitu method `createGuestbook()`.

Validasi data:

```php
$request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email',
    'phone' => 'required|string|max:20',
    'organization' => 'required|string|max:255',
    'visit_date' => 'required|date',
    'message' => 'required|string',
    'photo' => 'nullable|string',
]);
```

### 3.4.3 Mengubah Data

Method `update()` digunakan untuk memperbarui data tamu. Admin dapat mengubah nama, email, telepon, organisasi, tanggal kunjungan, pesan, dan status.

### 3.4.4 Menghapus Data

Method `destroy()` digunakan untuk menghapus data:

```php
Guestbook::findOrFail($id)->delete();
```

Jika data tidak ditemukan, Laravel otomatis menampilkan error 404.

## 3.5 Implementasi Form Publik `/tamu`

Form publik dibuat agar tamu dapat mengisi data sendiri tanpa login.

Method controller:

```php
public function publicCreate()
{
    return view('guestbook.create', [
        'formAction' => route('tamu.store'),
        'isPublicGuestForm' => true,
        'pageTitle' => 'Isi Buku Tamu',
    ]);
}
```

Method penyimpanan:

```php
public function publicStore(Request $request)
{
    $this->createGuestbook($request);

    return redirect()
        ->route('tamu.create')
        ->with('success', 'Terima kasih, data kunjungan Anda berhasil dikirim.');
}
```

Dengan cara ini, form publik tetap memakai tampilan yang sama dengan form admin, tetapi tujuan submit dan tampilan tombolnya disesuaikan.

## 3.6 Implementasi Foto Kamera

Fitur foto kamera dibuat di view:

```text
source/resources/views/guestbook/create.blade.php
```

Elemen penting:

| Elemen | Fungsi |
| --- | --- |
| `<video>` | Menampilkan kamera aktif |
| `<img>` | Menampilkan preview foto |
| `<input type="hidden" name="photo">` | Menyimpan data foto base64 |
| `<canvas>` | Mengambil gambar dari video |

JavaScript memakai:

```javascript
activeStream = await navigator.mediaDevices.getUserMedia({
    video: {
        facingMode: 'user',
        width: { ideal: 1280 },
        height: { ideal: 960 }
    },
    audio: false
});
```

Saat tombol `Ambil Foto` ditekan, gambar dari video diubah menjadi base64:

```javascript
const photoData = canvas.toDataURL('image/jpeg', 0.9);
photoInput.value = photoData;
```

Pada controller, data base64 diproses oleh method `storeCameraPhoto()` lalu disimpan ke:

```text
storage/app/public/guestbook-photos
```

## 3.7 Implementasi Export CSV

Export CSV dibuat pada method `export()`. Sistem mengambil semua data tamu, lalu membuat output CSV dengan header:

```text
No, Nama, Email, Telepon, Organisasi, Tanggal Kunjungan, Pesan, Status, Dibuat
```

File hasil export memiliki nama:

```text
guestbook-YYYY-MM-DD.csv
```

## 3.8 Implementasi Database

Migrasi utama:

```text
source/database/migrations/2026_05_08_080514_create_guestbooks_table.php
```

Perintah menjalankan migrasi:

```bash
php artisan migrate
```

Perintah reset database dan isi data contoh:

```bash
php artisan migrate:fresh --seed
```

Seeder data contoh:

```text
source/database/seeders/GuestbookSeeder.php
```

## 3.9 Pengujian Sistem

Pengujian dilakukan dengan membuka route aplikasi di browser dan menggunakan command Laravel.

### 3.9.1 Pengujian Route

Perintah untuk melihat route tamu:

```bash
php artisan route:list --path=tamu
```

Hasil yang diharapkan:

```text
GET|HEAD tamu  -> tamu.create
POST     tamu  -> tamu.store
```

Perintah untuk melihat route admin:

```bash
php artisan route:list --path=guestbook
```

Hasil yang diharapkan adalah route index, create, store, edit, update, destroy, dan export.

### 3.9.2 Pengujian Login

Langkah pengujian:

1. Buka `/login`.
2. Masukkan username `admin`.
3. Masukkan password `admin123`.
4. Klik login.
5. Sistem diarahkan ke `/guestbook`.

Hasil yang diharapkan: admin berhasil masuk dan daftar tamu tampil.

### 3.9.3 Pengujian Form Publik

Langkah pengujian:

1. Buka `/tamu`.
2. Isi semua field wajib.
3. Klik `Buka Kamera`.
4. Izinkan akses kamera.
5. Klik `Ambil Foto`.
6. Klik `Simpan`.

Hasil yang diharapkan: data tersimpan dan muncul pesan sukses.

### 3.9.4 Pengujian Export CSV

Langkah pengujian:

1. Login sebagai admin.
2. Buka `/guestbook`.
3. Klik tombol `Export CSV`.

Hasil yang diharapkan: browser mengunduh file CSV berisi data tamu.

## 3.10 Panduan Instalasi

Langkah instalasi dari awal:

1. Clone repository.

```bash
git clone git@github.com:farrasrayhand/sibudi.git
cd sibudi/source
```

2. Install dependency.

```bash
composer install
```

3. Buat file `.env`.

```bash
copy .env.example .env
```

4. Generate key.

```bash
php artisan key:generate
```

5. Buat database.

```sql
CREATE DATABASE sibudi;
```

6. Atur `.env`.

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

8. Buat link storage.

```bash
php artisan storage:link
```

9. Jalankan server.

```bash
php artisan serve
```

10. Buka aplikasi.

```text
http://127.0.0.1:8000
```

## 3.11 Kelebihan dan Kekurangan

### 3.11.1 Kelebihan

1. Memiliki form publik tanpa login.
2. Memiliki fitur kamera.
3. Data tersimpan di database.
4. Admin dapat melakukan CRUD data.
5. Data dapat diekspor ke CSV.
6. Sudah memiliki migrasi dan seeder.

### 3.11.2 Kekurangan

1. Login admin masih sederhana dan belum memakai tabel users.
2. Belum ada role management.
3. Belum ada dashboard statistik.
4. Belum ada validasi ukuran foto secara detail.
5. Belum ada fitur pencarian data tamu.

## 3.12 Saran Pengembangan

Saran pengembangan aplikasi:

1. Menggunakan autentikasi Laravel bawaan untuk admin.
2. Menambahkan fitur pencarian dan filter data tamu.
3. Menambahkan dashboard statistik kunjungan.
4. Menambahkan validasi ukuran dan format foto yang lebih ketat.
5. Menambahkan fitur cetak laporan PDF.
6. Menambahkan QR code menuju halaman `/tamu`.

## 3.13 Kesimpulan Bab III

Bab ini menjelaskan implementasi aplikasi SIBUDI mulai dari route, controller, model, view, fitur kamera, export CSV, migrasi, seeder, pengujian, hingga panduan instalasi. Berdasarkan implementasi tersebut, aplikasi telah memenuhi kebutuhan utama sebagai sistem buku tamu digital berbasis Laravel dengan fitur admin dan form publik tanpa login.
