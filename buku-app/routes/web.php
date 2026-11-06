<?php

use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ---------- CRUD Buku (auth + permission, dicek di server) ----------
    // Rute /books/create harus didefinisikan SEBELUM /books/{book}
    Route::get('/books', [BookController::class, 'index'])
        ->middleware('permission:book.view')->name('books.index');

    Route::get('/books/create', [BookController::class, 'create'])
        ->middleware('permission:book.create')->name('books.create');
    Route::post('/books', [BookController::class, 'store'])
        ->middleware('permission:book.create')->name('books.store');

    Route::get('/books/{book}/edit', [BookController::class, 'edit'])
        ->middleware('permission:book.edit')->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])
        ->middleware('permission:book.edit')->name('books.update');

    Route::delete('/books/{book}', [BookController::class, 'destroy'])
        ->middleware('permission:book.delete')->name('books.destroy');

    // ---------- Kelola role (hanya Admin) ----------
    Route::middleware('role:Admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserRoleController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/role', [UserRoleController::class, 'update'])->name('users.role');
    });
});

require __DIR__.'/auth.php';
