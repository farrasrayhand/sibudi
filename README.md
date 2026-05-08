# SIBUDI - Buku Tamu Digital

Folder ini berisi aplikasi Laravel utama untuk SIBUDI.

Panduan instalasi lengkap tersedia di:

- [README root project](../README.md)
- [INSTALL.md](INSTALL.md)

Perintah cepat setelah masuk folder `source`:

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Login admin:

```text
Username: admin
Password: admin123
```
