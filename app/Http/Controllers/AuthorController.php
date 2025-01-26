<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Налагаме middleware, за да проверяваме достъпа.
     */
    public function __construct()
    {
        $this->middleware('auth'); // Изисква потребителят да е логнат
        $this->middleware('is_admin'); // Проверява дали потребителят е администратор
    }

    /**
     * Списък с всички автори.
     */
    public function index()
    {
        $authors = Author::all();
        return view('admin.authors.index', compact('authors'));
    }

    /**
     * Показва формата за добавяне на нов автор.
     */
    public function create()
    {
        return view('admin.authors.create');
    }

    /**
     * Съхранява новия автор в базата данни.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Author::create($request->only(['name'])); // Използваме само името
        return redirect()->route('admin.authors.index')->with('success', 'Авторът беше добавен успешно!');
    }

    /**
     * Показва формата за редакция на автор.
     */
    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    /**
     * Обновява данните за автора.
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author->update($request->only(['name'])); // Обновяваме само името
        return redirect()->route('admin.authors.index')->with('success', 'Авторът беше обновен успешно!');
    }

    /**
     * Изтрива автора от базата данни.
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('admin.authors.index')->with('success', 'Авторът беше изтрит успешно!');
    }
}