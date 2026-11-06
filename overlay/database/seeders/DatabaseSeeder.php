<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        $books = [
            ['Pemrograman Web dengan Laravel', 'Budi Santoso', 'Informatika', 2023, '978-602-0000-001', 'Dasar-dasar Laravel.'],
            ['Basis Data Relasional', 'Siti Aminah', 'Andi Offset', 2021, '978-602-0000-002', 'Konsep ERD dan SQL.'],
            ['Algoritma dan Struktur Data', 'Rudi Hartono', 'Erlangga', 2020, '978-602-0000-003', 'Algoritma klasik.'],
        ];
        foreach ($books as [$judul, $penulis, $penerbit, $tahun, $isbn, $desk]) {
            Book::firstOrCreate(['isbn' => $isbn], [
                'judul' => $judul, 'penulis' => $penulis, 'penerbit' => $penerbit,
                'tahun_terbit' => $tahun, 'deskripsi' => $desk,
            ]);
        }
    }
}
