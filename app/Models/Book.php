<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    protected $fillable = [
        'cover',
        'title',
        'author',
        'formats',
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
        'formats' => 'array',
    ];

    protected $guarded = [];

    public function wishlistUsers()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'book_id', 'user_id')->withTimestamps();
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }
}
