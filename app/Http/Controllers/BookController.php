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
    // Валидация на входните данни
    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'genre' => 'required|string|max:255',
        'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/', // Позволява само до 2 десетични места
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Проверка дали авторът съществува
    $author = Author::firstOrCreate(['name' => $request->author]);

    // Проверка дали жанрът съществува
    $genre = Genre::firstOrCreate(['name' => $request->genre]);

    // Създаване на нова книга
    $book = new Book();
    $book->title = $request->title;
    $book->author_id = $author->id;
    $book->genre_id = $genre->id;
    $book->price = number_format($request->price, 2, '.', ''); // Форматираме цената до 2 десетични места

    // Обработка на изображение
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('books', 'public');
        $book->image = $imagePath;
    }

    $book->save();

    // Успешно съхранение
    return redirect()->route('books.index')->with('status', 'Книгата беше добавена успешно!');
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
