<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

// Рутове за книги
Route::resource('books', BookController::class);
Route::post('books/create', [BookController::class, 'store'])->name('books.store');
Route::get('books/{book}', [BookController::class, 'show'])->name('books.show');
Route::post('/books', [BookController::class, 'store'])->name('books.store');

// Променяме 'admin' на 'isAdmin' в middleware за администраторските рутове
Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('books', BookController::class);
});

// Рутове за кошница (само ако потребителят е влязъл)
Route::middleware(['auth'])->group(function () {
    // Рут за показване на книгите
    Route::get('/books', [BookController::class, 'index'])->name('books.index');

    // Рут за показване на кошницата
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    // Рут за добавяне на книга в кошницата
    Route::post('/cart/add/{bookId}', [CartController::class, 'add'])->name('cart.add');

    // Рут за премахване на книга от кошницата
    Route::delete('/cart/remove/{bookId}', [CartController::class, 'remove'])->name('cart.remove');

    // Рут за актуализиране на количеството на книга в кошницата
    Route::patch('/cart/update/{bookId}', [CartController::class, 'update'])->name('cart.update');

    // Рут за изпразване на кошницата
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// Група с администраторски рутове (изисква middleware 'isAdmin')
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/books', [BookController::class, 'index'])->name('admin.books.index');
    Route::get('/admin/books/{book}/edit', [BookController::class, 'edit'])->name('admin.books.edit');
    Route::put('/admin/books/{book}', [BookController::class, 'update'])->name('admin.books.update');
});

// Рутове, свързани с профила на потребителя
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Пътя за профила, с middleware за проверка на логнатия потребител
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Администраторски рутове за управление на потребителите
Route::prefix('admin')->name('admin.')->middleware('can:admin')->group(function () {
    Route::resource('users', UserController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
