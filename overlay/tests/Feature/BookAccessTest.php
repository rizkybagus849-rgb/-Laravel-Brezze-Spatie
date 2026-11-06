<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    private function userRole(string $role): User
    {
        return User::where('email', strtolower($role).'@example.com')->firstOrFail();
    }

    private function payload(array $o = []): array
    {
        return array_merge(['judul' => 'Tes', 'penulis' => 'Penulis', 'isbn' => 'ISBN-'.uniqid()], $o);
    }

    public function test_guest_dialihkan_ke_login(): void
    {
        $this->get('/books')->assertRedirect('/login');
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_login_kredensial_salah_gagal(): void
    {
        $this->post('/login', ['email' => 'admin@example.com', 'password' => 'salah']);
        $this->assertGuest();
    }

    public function test_mahasiswa_hanya_boleh_lihat(): void
    {
        $u = $this->userRole('Mahasiswa');
        $book = Book::create($this->payload());

        $this->actingAs($u)->get('/books')->assertOk();
        $this->actingAs($u)->get('/books/create')->assertForbidden();
        $this->actingAs($u)->post('/books', $this->payload())->assertForbidden();
        $this->actingAs($u)->get("/books/{$book->id}/edit")->assertForbidden();
        $this->actingAs($u)->delete("/books/{$book->id}")->assertForbidden();
        $this->actingAs($u)->get('/admin/users')->assertForbidden();
    }

    public function test_dosen_bisa_tambah_edit_tapi_tidak_hapus(): void
    {
        $u = $this->userRole('Dosen');

        $this->actingAs($u)->post('/books', $this->payload(['isbn' => 'D-1']))->assertRedirect('/books');
        $book = Book::where('isbn', 'D-1')->firstOrFail();

        $this->actingAs($u)->put("/books/{$book->id}", $this->payload(['judul' => 'Baru', 'isbn' => 'D-1']))
            ->assertRedirect('/books');
        $this->actingAs($u)->delete("/books/{$book->id}")->assertForbidden();
        $this->actingAs($u)->get('/admin/users')->assertForbidden();
    }

    public function test_admin_bisa_semua(): void
    {
        $u = $this->userRole('Admin');

        $this->actingAs($u)->post('/books', $this->payload(['isbn' => 'A-1']))->assertRedirect('/books');
        $book = Book::where('isbn', 'A-1')->firstOrFail();
        $this->actingAs($u)->delete("/books/{$book->id}")->assertRedirect('/books');
        $this->assertDatabaseMissing('books', ['isbn' => 'A-1']);

        $this->actingAs($u)->get('/admin/users')->assertOk();
        $mhs = $this->userRole('Mahasiswa');
        $this->actingAs($u)->patch("/admin/users/{$mhs->id}/role", ['role' => 'Dosen'])->assertRedirect();
        $this->assertTrue($mhs->fresh()->hasRole('Dosen'));
    }

    public function test_registrasi_otomatis_role_mahasiswa(): void
    {
        $this->post('/register', [
            'name' => 'Baru', 'email' => 'baru@example.com',
            'password' => 'password123', 'password_confirmation' => 'password123',
        ])->assertRedirect('/dashboard');

        $this->assertTrue(User::where('email', 'baru@example.com')->first()->hasRole('Mahasiswa'));
    }
}
