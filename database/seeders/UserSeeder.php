<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Добавяме примерен администратор
        $adminRole = Role::where('name', 'admin')->first();
        User::create([
            'name' => 'Admin',
            'email' => 'admin@php.com',
            'password' => Hash::make('Admin1!'),
            'role_id' => $adminRole->id,
        ]);

        // Добавяме примерен потребител
        $userRole = Role::where('name', 'user')->first();
        User::create([
            'name' => 'User',
            'email' => 'user@php.com',
            'password' => Hash::make('User1!'),
            'role_id' => $userRole->id,
        ]);
    }
}

