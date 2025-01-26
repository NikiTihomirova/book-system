<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Конструктор с middleware за проверка на достъпа.
     */
    public function __construct()
    {
        $this->middleware('auth');

        // Ограничаваме достъпа само за администратори
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Нямате достъп до тази страница.');
            }
            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Списък с всички жанрове.
     */
    public function index()
    {
        $genres = Genre::all();
        return view('admin.genres.index', compact('genres'));
    }

    /**
     * Форма за създаване на нов жанр.
     */
    public function create()
    {
        return view('admin.genres.create');
    }

    /**
     * Създаване на нов жанр.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
        ]);

        Genre::create($validatedData);

        return redirect()->route('admin.genres.index')->with('success', 'Жанрът е добавен успешно!');
    }

    /**
     * Форма за редактиране на съществуващ жанр.
     */
    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    /**
     * Актуализиране на данни за жанр.
     */
    public function update(Request $request, Genre $genre)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
        ]);

        $genre->update($validatedData);

        return redirect()->route('admin.genres.index')->with('success', 'Данните за жанра са обновени успешно!');
    }

    /**
     * Изтриване на жанр.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return redirect()->route('admin.genres.index')->with('success', 'Жанрът е изтрит успешно!');
    }
}