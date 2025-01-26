<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * Масив от атрибути, които могат да бъдат попълвани (fillable).
     */
    protected $fillable = ['title', 'author_id', 'genre_id', 'price','image'];

    /**
     * Връзка: книгата принадлежи на автор.
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Връзка: книгата принадлежи на жанр.
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}