<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    // public function __construct()
    // {
    //     // Добавете middleware за администратори
    //     $this->middleware(IsAdmin::class)->except(['index', 'show']);
    // }
    
    public function index()
    {
        // Вземи всички книги от базата
        $books = Book::all();

        return view('books.index', compact('books'));
    }

    // Създаване на нова книга
    public function create()
{
    $authors = Author::all(); // Взимаме всички автори от базата данни
    $genres = Genre::all(); // Взимаме всички жанрове

    return view('books.create', compact('authors', 'genres'));
}

    // Съхраняване на нова книга
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'author_id' => 'required|exists:authors,id', // Използвайте author_id
        'genre_id' => 'required|exists:genres,id',  // Използвайте genre_id
        'price' => 'required|numeric|min:0',
    ]);

    // Създайте нова книга
    Book::create([
        'title' => $request->title,
        'author_id' => $request->author_id, // Записвайте author_id
        'genre_id' => $request->genre_id,   // Записвайте genre_id
        'price' => $request->price,
    ]);

    return redirect()->route('admin.books.index')->with('success', 'Книгата е добавена успешно!');
}



    // Редактиране на книга
    public function edit($id)
    {
        // Вземи книгата с ID-то
        $book = Book::findOrFail($id);

        // Вземи всички автори и жанрове
        $authors = Author::all();
        $genres = Genre::all();

        return view('books.edit', compact('book', 'authors', 'genres'));
    }

    public function update(Request $request, $id)
{
    // Валидиране на входа
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'author_id' => 'required|exists:authors,id',
        'genre_id' => 'required|exists:genres,id',
        'price' => 'required|numeric',
        'image' => 'nullable|image|max:1024',
    ]);

    // Вземи книгата с ID-то
    $book = Book::findOrFail($id);

    // Актуализирай данните
    $book->title = $validated['title'];
    $book->author_id = $validated['author_id'];
    $book->genre_id = $validated['genre_id'];
    $book->price = $validated['price'];

    // Ако има ново изображение
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('public/books');
        $book->image = basename($imagePath);
    }

    $book->save();

    return redirect()->route('admin.books.index')->with('status', 'Книгата е успешно актуализирана!');
}

    // Изтриване на книга
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Книгата беше изтрита успешно!');
    }
}
