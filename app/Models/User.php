<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Релация с таблица roles
    public function roles()
    {
        return $this->belongsToMany(Role::class); // Много към много релация
    }

    // Проверка за роля
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }
    public function isAdmin()
{
    return $this->is_admin; // Или какъвто и да е начин за проверка на ролята
}
}

