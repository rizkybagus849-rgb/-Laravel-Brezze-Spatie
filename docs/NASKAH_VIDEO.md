# Naskah Alur Video Penjelasan (± 8–10 menit)

1. **Pembuka (30 dtk)** — Tujuan aplikasi, 3 role, stack (Laravel 11, Breeze, Spatie).
2. **Alur autentikasi Breeze (1,5 mnt)** — Buka `routes/auth.php` → `AuthenticatedSessionController` (login/logout) → `RegisteredUserController` (register + `assignRole('Mahasiswa')`). Demo login salah & benar.
3. **Model & database (1 mnt)** — `User` + trait `HasRoles`; tabel Spatie (`roles`, `permissions`, `model_has_roles`, dst.) & tabel `books` di migration.
4. **Seeder (1 mnt)** — `RolePermissionSeeder`: daftar permission → matriks role → 3 akun uji. Jalankan `php artisan migrate:fresh --seed`.
5. **Alur request CRUD (2 mnt)** — Ikuti satu request: browser → `routes/web.php` → middleware `auth` → `permission:book.create` (alias di `bootstrap/app.php`) → `BookController@store` → validasi → DB → redirect + flash message.
6. **Pembatasan hak akses (1,5 mnt)** — `@can` di `books/index.blade.php` (hanya UI) vs middleware di route (keamanan sebenarnya). Tunjukkan Mahasiswa mengetik `/books/create` → 403.
7. **Demo 3 role (2 mnt)** — Login Admin (semua fitur + kelola role), Dosen (tambah/edit, tanpa hapus), Mahasiswa (lihat saja). Jalankan `php artisan test`.
8. **Penutup (30 dtk)** — Ringkasan dan hasil pengujian.
