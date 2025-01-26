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
    // Контролер за създаване на книга
public function store(Request $request)
{
    // Валидация на входните данни
    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'genre' => 'required|string|max:255',
        'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
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
    $book->price = number_format($request->price, 2, '.', '');

    // Обработка на изображение
    if ($request->hasFile('image')) {
        // Преместваме изображението в публичната директория
        $imagePath = $request->file('image')->store('books', 'public');
        $book->image = $imagePath;
    }

    $book->save();

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

    // Контролер за редактиране на книга
public function update(Request $request, $id)
{   
    
    // Валидация на входните данни
    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'genre' => 'required|string|max:255',
        'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Намиране на книгата
    $book = Book::findOrFail($id);

    // Обновяване на полетата на книгата
    $book->title = $request->title;
    $book->author_id = Author::firstOrCreate(['name' => $request->author])->id;
    $book->genre_id = Genre::firstOrCreate(['name' => $request->genre])->id;
    $book->price = number_format($request->price, 2, '.', '');

    // Обработка на изображение
    if ($request->hasFile('image')) {
        // Премахваме старата снимка, ако има
        if ($book->image && file_exists(storage_path('app/public/' . $book->image))) {
            unlink(storage_path('app/public/' . $book->image)); // Изтриваме старата снимка
        }

        // Качване на новото изображение
        $imagePath = $request->file('image')->store('books', 'public');  // Пътят за качване
        $book->image = $imagePath;
    }

    $book->save();

    return redirect()->route('books.index')->with('status', 'Книгата беше актуализирана успешно!');
}


    // Изтриване на книга
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Книгата беше изтрита успешно!');
    }
}
