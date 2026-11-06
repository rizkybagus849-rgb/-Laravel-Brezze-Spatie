<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['judul', 'penulis', 'penerbit', 'tahun_terbit', 'isbn', 'deskripsi'];
}
