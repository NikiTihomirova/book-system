<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Вземи последните 6 книги
        $books = Book::latest()->take(6)->get();  // Използваме `latest()` за да вземем книгите по дата на създаване

        // Преминаваме тези книги в view-то
        return view('home', compact('books'));  // Уверете се, че използвате 'compact('books')' за подаване на данните
    }
}