# Database Table Data Tamu

Tabel data tamu pada aplikasi SIBUDI menggunakan nama tabel:

```text
guestbooks
```

Tabel ini digunakan untuk menyimpan data pengunjung atau tamu, baik yang diinput oleh admin melalui halaman `/guestbook/create` maupun yang diisi sendiri oleh tamu melalui halaman publik `/tamu`.

## Struktur Tabel

| No | Nama Kolom | Tipe Data | Null | Default | Keterangan |
| :---: | :--- | :--- | :---: | :--- | :--- |
| 1 | `id` | BIGINT UNSIGNED | Tidak | Auto Increment | Primary key data tamu |
| 2 | `name` | VARCHAR(255) | Tidak | - | Nama lengkap tamu |
| 3 | `email` | VARCHAR(255) | Tidak | - | Email tamu |
| 4 | `phone` | VARCHAR(20) | Tidak | - | Nomor telepon tamu |
| 5 | `organization` | VARCHAR(255) | Tidak | - | Organisasi, instansi, atau perusahaan tamu |
| 6 | `visit_date` | DATE | Tidak | - | Tanggal kunjungan |
| 7 | `message` | TEXT | Tidak | - | Keperluan atau pesan kunjungan |
| 8 | `photo` | VARCHAR(255) | Ya | NULL | Path foto tamu dari kamera |
| 9 | `status` | VARCHAR(255) | Tidak | `pending` | Status data tamu |
| 10 | `created_at` | TIMESTAMP | Ya | NULL | Waktu data dibuat |
| 11 | `updated_at` | TIMESTAMP | Ya | NULL | Waktu data diperbarui |

## Status Data Tamu

Kolom `status` memiliki tiga nilai utama:

| Status | Keterangan |
| :--- | :--- |
| `pending` | Data baru masuk dan belum diproses |
| `approved` | Data sudah disetujui |
| `rejected` | Data ditolak |

## SQL Create Table

```sql
CREATE TABLE guestbooks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    organization VARCHAR(255) NOT NULL,
    visit_date DATE NOT NULL,
    message TEXT NOT NULL,
    photo VARCHAR(255) NULL,
    status VARCHAR(255) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## Laravel Migration

Di Laravel, tabel ini dibuat melalui migration:

```text
source/database/migrations/2026_05_08_080514_create_guestbooks_table.php
```

Isi migration utama:

```php
Schema::create('guestbooks', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email');
    $table->string('phone');
    $table->string('organization');
    $table->date('visit_date');
    $table->text('message');
    $table->string('photo')->nullable();
    $table->string('status')->default('pending');
    $table->timestamps();
});
```

## Relasi Dengan Aplikasi

Tabel `guestbooks` digunakan oleh model:

```text
source/app/Models/Guestbook.php
```

Field yang dapat diisi oleh aplikasi:

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

## Contoh Data

| id | name | email | phone | organization | visit_date | message | photo | status |
| :---: | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | Budi Santoso | budi@example.com | 081234567890 | Dinas Pendidikan | 2026-05-08 | Koordinasi agenda rapat | guestbook-photos/foto.jpg | pending |

