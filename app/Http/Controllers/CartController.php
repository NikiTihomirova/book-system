<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // За използване на модела Book

class CartController extends Controller
{
    // Показване на кошницата
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        // Пресмятаме общата цена
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Показваме кошницата на потребителя
        return view('cart.index', compact('cart', 'total'));
    }

    // Добавяне на книга в кошницата
    public function add($bookId)
    {
        // Вземаме информация за книгата от базата данни
        $book = Book::find($bookId);

        // Проверяваме дали книгата съществува и има цена
        if (!$book || !$book->price) {
            return redirect()->route('cart.index')->with('error', 'Няма цена за избраната книга.');
        }

        // Вземаме кошницата от сесията
        $cart = session()->get('cart', []);

        // Ако книгата вече е в кошницата, увеличаваме количеството
        if (isset($cart[$bookId])) {
            $cart[$bookId]['quantity']++;
        } else {
            // Ако не е в кошницата, добавяме я
            $cart[$bookId] = [
                'name' => $book->name,  // Записваме името на книгата
                'price' => $book->price, // Записваме цената на книгата
                'quantity' => 1, // Поставяме начална бройка
            ];
        }

        // Записваме актуализираната кошница в сесията
        session()->put('cart', $cart);

        // Пренасочваме обратно към кошницата
        return redirect()->route('cart.index');
    }

    // Премахване на книга от кошницата
    public function remove($bookId)
    {
        // Вземаме кошницата от сесията
        $cart = session()->get('cart', []);

        // Премахваме книгата от кошницата, ако съществува
        if (isset($cart[$bookId])) {
            unset($cart[$bookId]);
        }

        // Записваме актуализираната кошница в сесията
        session()->put('cart', $cart);

        // Пренасочваме обратно към кошницата
        return redirect()->route('cart.index');
    }

    // Актуализиране на количеството на книга в кошницата
    public function update(Request $request, $bookId)
    {
        // Вземаме кошницата от сесията
        $cart = session()->get('cart', []);

        // Проверяваме дали книгата съществува в кошницата
        if (isset($cart[$bookId])) {
            // Актуализираме количеството на книгата
            $cart[$bookId]['quantity'] = $request->quantity;
        }

        // Записваме актуализираната кошница в сесията
        session()->put('cart', $cart);

        // Пренасочваме обратно към кошницата
        return redirect()->route('cart.index');
    }

    // Изпразване на кошницата
    public function clear()
    {
        // Изтриваме кошницата от сесията
        session()->forget('cart');

        // Пренасочваме обратно към кошницата
        return redirect()->route('cart.index');
    }
}
