<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    // A cart has many items (CartItem)
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // A cart belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // If you want to calculate the total price of the cart:
    public function totalPrice()
    {
        return $this->items->sum(fn($item) => $item->book->price * $item->quantity);
    }
}
