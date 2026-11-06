# Catatan Hasil Pengujian

Isi kolom **Hasil Aktual** & tempel screenshot saat menguji manual (`php artisan serve`).
Pengujian otomatis: `php artisan test` (file `tests/Feature/BookAccessTest.php`).

## A. Autentikasi
| No | Skenario | Hasil Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|
| 1 | Register data valid | Akun dibuat, role Mahasiswa, masuk dashboard | | |
| 2 | Login benar (admin@example.com / password) | Masuk dashboard | | |
| 3 | Login password salah | Gagal, muncul pesan "credentials do not match" | | |
| 4 | Logout | Kembali ke halaman login | | |
| 5 | Buka `/dashboard` tanpa login | Redirect ke `/login` | | |

## B. Akses via UI dan URL langsung
| No | Role | Aksi / URL | Diharapkan | Aktual | Status |
|---|---|---|---|---|---|
| 1 | Mahasiswa | GET `/books` | 200 (tampil, tanpa tombol aksi) | | |
| 2 | Mahasiswa | GET `/books/create` | **403** | | |
| 3 | Mahasiswa | GET `/books/{id}/edit` | **403** | | |
| 4 | Mahasiswa | DELETE `/books/{id}` | **403** | | |
| 5 | Mahasiswa | GET `/admin/users` | **403** | | |
| 6 | Dosen | GET `/books/create` + simpan | 200 / redirect sukses | | |
| 7 | Dosen | Edit buku | Berhasil | | |
| 8 | Dosen | DELETE `/books/{id}` | **403** | | |
| 9 | Dosen | GET `/admin/users` | **403** | | |
| 10 | Admin | Tambah, edit, hapus buku | Berhasil | | |
| 11 | Admin | GET `/admin/users`, ubah role user | Berhasil | | |
| 12 | Admin | Ubah role dirinya sendiri ke non-Admin | Ditolak (pesan error) | | |

> Tip menguji DELETE via URL langsung sebagai Mahasiswa: buka DevTools → Console, lalu jalankan
> `fetch('/books/1',{method:'POST',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content,'Content-Type':'application/x-www-form-urlencoded'},body:'_method=DELETE'}).then(r=>console.log(r.status))` → harus `403`.
