<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run()
    {
        Genre::insert([
            ['name' => 'Фентъзи'],
            ['name' => 'Ужаси'],
            ['name' => 'Роман'],
            ['name' => 'Драма'],
            ['name' => 'Психология'],
            ['name' => 'Криминални'],
            ['name' => 'Романтика']
        ]);
    }
}

