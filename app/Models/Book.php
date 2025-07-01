<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'cover',
        'judul',
        'author',
        'format',
        'deskripsi',
        'penerbit',
        'isbn',
        'bahasa',
        'panjang',
        'lebar',
        'berat',
        'halaman',
        'tanggal_terbit',
    ];
}
