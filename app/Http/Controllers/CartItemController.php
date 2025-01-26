<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Book;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    // Показване на всички елементи в кошницата
    public function index()
    {
        $cartItems = CartItem::with('book')->where('user_id', auth()->id())->get();
        return view('cart-items.index', compact('cartItems'));
    }

    // Добавяне на елемент в кошницата
    public function store(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        CartItem::create($request->all());
        return redirect()->route('cart.index');
    }

    // Редактиране на елемент в кошницата
    public function edit(CartItem $cartItem)
    {
        $books = Book::all();
        return view('cart-items.edit', compact('cartItem', 'books'));
    }

    // Актуализиране на елемент в кошницата
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update($request->all());
        return redirect()->route('cart.index');
    }

    // Изтриване на елемент от кошницата
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();
        return redirect()->route('cart.index');
    }
}
