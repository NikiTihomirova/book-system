<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    // Показване на всички книги с филтри
    public function index(Request $request)
    {
        $books = Book::query();
    
        // Филтриране по жанр и цена
        if ($request->filled('genre')) {
            $books->whereHas('genre', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->genre . '%');
            });
        }
        if ($request->filled('price')) {
            if ($request->price == 'low') {
                $books->where('price', '<', 20);
            } elseif ($request->price == 'medium') {
                $books->whereBetween('price', [20, 50]);
            } elseif ($request->price == 'high') {
                $books->where('price', '>', 50);
            }
        }

        if ($request->filled('search')) {
            $books->where('title', 'like', '%' . $request->search . '%');
        }
    
        $books = $books->paginate(8);

        // Декодиране на жанра
        foreach ($books as $book) {
            if (is_string($book->genre)) {
                $book->genre = json_decode($book->genre);
            }
        }
    
        return view('books.index', compact('books'));
    }

    // Създаване на нова книга
    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all();

        return view('books.create', compact('authors', 'genres'));
    }

    // Съхраняване на нова книга
    public function store(Request $request)
    {
        // Валидация
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Проверка за съществуването на автор и жанр
        $author = Author::firstOrCreate(['name' => $request->author]);
        $genre = Genre::firstOrCreate(['name' => $request->genre]);

        // Създаване на новата книга
        $book = new Book();
        $book->title = $request->title;
        $book->author_id = $author->id;
        $book->genre_id = $genre->id;
        $book->price = number_format($request->price, 2, '.', '');

        // Обработка на изображение
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $book->image = $imagePath;
        }

        $book->save();

        return redirect()->route('books.index')->with('status', 'Книгата беше добавена успешно!');
    }

    // Редактиране на книга
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $authors = Author::all();
        $genres = Genre::all();

        return view('books.edit', compact('book', 'authors', 'genres'));
    }

    // Актуализиране на книга
    public function update(Request $request, $id)
    {
        // Валидация
        $request->validate([
            'title' => 'nullable|string|max:255',
            'author_id' => 'nullable|exists:authors,id',
            'genre_id' => 'nullable|exists:genres,id',
            'price' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $book = Book::findOrFail($id);

        if ($request->filled('title')) {
            $book->title = $request->title;
        }

        if ($request->filled('author_id')) {
            $book->author_id = $request->author_id;
        }

        if ($request->filled('genre_id')) {
            $book->genre_id = $request->genre_id;
        }

        if ($request->filled('price')) {
            $book->price = number_format($request->price, 2, '.', '');
        }

        // Обработка на новото изображение
        if ($request->hasFile('image')) {
            // Премахваме старата снимка
            if ($book->image && file_exists(storage_path('app/public/' . $book->image))) {
                unlink(storage_path('app/public/' . $book->image)); // Изтриваме старата снимка
            }

            // Качване на новото изображение
            $imagePath = $request->file('image')->store('books', 'public');
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
