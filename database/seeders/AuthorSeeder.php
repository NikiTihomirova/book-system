<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        Author::insert([
            ['name' => 'Стивън Кинг'],
            ['name' => 'Джон Грейн'],
            ['name' => 'Джей К. Роулинг'],
            ['name' => 'Чарлс Дикенс'],
            ['name' => 'Фьодор М. Достоевски'],
            ['name' => 'Агата Кристи'],
            ['name' => 'Марк Твен'],
            ['name' => 'Робин Шарма'],
            ['name' => 'Джейн Остин'],
            ['name' => 'Сара Дж. Мааз'],
        ]);
    }
}

