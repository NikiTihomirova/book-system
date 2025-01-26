<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;

class Genre extends Model
{
    use HasFactory;

    /**
     * Масив от атрибути, които могат да бъдат попълвани (fillable).
     */
    protected $fillable = ['name'];

    /**
     * Връзка: жанрът има много книги.
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}