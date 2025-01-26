<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run()
    {
        Book::insert([
            [
                'title' => 'Двор от рози и бодли ',
                'author_id' => 10,
                'genre_id' => 1,
                'price' => 24.90,
            ],
            [
                'title' => 'Гордост и предрасъдъци',
                'author_id' => 9, 
                'genre_id' => 3,
                'price' => 19.90,
            ],
            [
                'title' => 'Клуб 5 сутринта',
                'author_id' => 8, 
                'genre_id' => 5,  
                'price' => 15.90,
            ], 
            [
                'title' => 'Приключенията на Том Сойер',
                'author_id' => 7, 
                'genre_id' => 3,  
                'price' => 19.90,
            ],
            [
                'title' => 'Смърт край Нил',
                'author_id' => 6, 
                'genre_id' => 6,  
                'price' => 16.99,
            ],
            [
                'title' => 'Идиот',
                'author_id' => 5,
                'genre_id' => 3,  
                'price' => 30.00,
            ],
            [
                'title' => 'Старият антикварен магазин',
                'author_id' => 4, 
                'genre_id' => 3, 
                'price' => 40.00,
            ],
            [
                'title' => 'Хари Потър и философския камък',
                'author_id' => 3,
                'genre_id' => 1,
                'price' => 24.90,
            ],
            [
                'title' => 'Къде си Аляска',
                'author_id' => 2, 
                'genre_id' => 3, 
                'price' => 22.90,
            ],
            [
                'title' => 'Зеленият път',
                'author_id' => 1,
                'genre_id' => 6,
                'price' => 19.99,
            ]
        ]);
    }
}

