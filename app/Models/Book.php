<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'cover',
        'title',
        'author',
        'format',
        'description',
        'publisher',
        'isbn',
        'language',
        'length',
        'width',
        'weight',
        'page',
        'release_date',
        'price',
    ];

    protected $casts = [
        'release_date' => 'date',
        'length' => 'float',
        'width' => 'float',
        'weight' => 'float',
        'price' => 'integer',
    ];
}
