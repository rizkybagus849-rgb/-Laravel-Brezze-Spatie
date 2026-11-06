# Aplikasi Manajemen Buku — Laravel Breeze + Spatie Permission

**Stack:** Laravel 11 · Laravel Breeze 2.x (Blade) · spatie/laravel-permission 6.x · SQLite (default)

## Cara menjalankan
Syarat: PHP ≥ 8.2, Composer, Node.js.

### 1) Masuk ke folder project
```powershell
cd "c:\Users\acer\Downloads\manajemen-buku\manajemen-buku\buku-app"
```

### 2) Install dependency Composer
```powershell
composer install --no-interaction --no-blocking
```

### 3) Buat key aplikasi dan migrasi database
```powershell
php artisan key:generate
php artisan migrate:fresh --seed
```

### 4) Jalankan aplikasi
```powershell
php artisan serve
```
Lalu buka di browser:
```text
http://127.0.0.1:8000
```

### 5) Jika ingin cek hak akses otomatis
```powershell
php artisan test --testsuite=Feature --filter=BookAccessTest
```

### 6) Jika error login / akun tidak muncul
Jalankan ulang database seed:
```powershell
php artisan migrate:fresh --seed
```

> Jika memakai MySQL, ubah `.env` terlebih dahulu (`DB_CONNECTION=mysql`, `DB_DATABASE=...`) sebelum langkah migrate.

## Akun pengujian (password: `password`)
| Role | Email |
|---|---|
| Admin | admin@example.com |
| Dosen | dosen@example.com |
| Mahasiswa | mahasiswa@example.com |

Pendaftar baru lewat halaman Register otomatis menjadi **Mahasiswa**; hanya Admin yang dapat mengubah role (menu *Kelola Role Pengguna* di dashboard).

## Matriks hak akses → permission
| Fitur | Permission | Admin | Dosen | Mahasiswa |
|---|---|:-:|:-:|:-:|
| Lihat buku | `book.view` | ✔ | ✔ | ✔ |
| Tambah buku | `book.create` | ✔ | ✔ | ✘ |
| Edit buku | `book.edit` | ✔ | ✔ | ✘ |
| Hapus buku | `book.delete` | ✔ | ✘ | ✘ |
| Kelola role | `user.manage-roles` + middleware `role:Admin` | ✔ | ✘ | ✘ |

## Peta file (untuk penjelasan video)
| File | Fungsi |
|---|---|
| `routes/web.php` | Middleware `auth`, `permission:...`, `role:Admin` per rute (**keamanan di server**) |
| `bootstrap/app.php` | Mendaftarkan alias middleware Spatie (`role`, `permission`) |
| `app/Models/User.php` | Trait `HasRoles` |
| `database/seeders/RolePermissionSeeder.php` | Membuat permission, role, matriks, dan 3 akun uji |
| `app/Http/Controllers/Auth/RegisteredUserController.php` | `assignRole('Mahasiswa')` saat register |
| `app/Http/Controllers/BookController.php` | CRUD buku + validasi |
| `app/Http/Controllers/Admin/UserRoleController.php` | Admin mengubah role pengguna |
| `resources/views/books/*` | View CRUD; `@can(...)` hanya menyembunyikan tombol |
| `tests/Feature/BookAccessTest.php` | Uji otomatis 403/redirect untuk tiap role |

## Catatan keamanan
`@can` di Blade **hanya tampilan**. Pengaman sebenarnya adalah middleware di `routes/web.php`: mengetik URL langsung (mis. `/books/create` sebagai Mahasiswa) menghasilkan **403 Forbidden**, dan tanpa login diarahkan ke `/login`.

Dokumen pendukung: `docs/HASIL_PENGUJIAN.md` (tabel catatan uji) dan `docs/NASKAH_VIDEO.md` (alur penjelasan video).
