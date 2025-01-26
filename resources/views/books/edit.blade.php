@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6 text-center">Редактиране на книга</h1>

    <!-- Показване на съобщения за грешки -->
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="list-disc pl-6 text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Потвърждение за успешно съхранение -->
    @if (session('status'))
        <div class="alert alert-success mb-4 p-4 bg-green-100 text-green-700 border border-green-400 rounded">
            {{ session('status') }}
        </div>
    @endif

    @if (Auth::check() && Auth::user()->is_admin)
    <!-- Показвайте само ако е администратор -->
    <form method="POST" action="{{ route('books.update', $book->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Заглавие (не-задължително) -->
        <div class="mb-4">
            <label for="title" class="block text-lg font-medium text-gray-700">Заглавие</label>
            <input type="text" name="title" class="form-control w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" id="title" value="{{ old('title', $book->title) }}" placeholder="Въведете заглавие">
        </div>

        <!-- Автор (не-задължително) -->
        <div class="mb-4">
            <label for="author_id" class="block text-lg font-medium text-gray-700">Автор</label>
            <select name="author_id" class="form-control w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" id="author_id">
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ $author->id == old('author_id', $book->author_id) ? 'selected' : '' }}>{{ $author->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Жанр (не-задължително) -->
        <div class="mb-4">
            <label for="genre_id" class="block text-lg font-medium text-gray-700">Жанр</label>
            <select name="genre_id" class="form-control w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" id="genre_id">
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ $genre->id == old('genre_id', $book->genre_id) ? 'selected' : '' }}>{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Цена (не-задължително) -->
        <div class="mb-4">
            <label for="price" class="block text-lg font-medium text-gray-700">Цена</label>
            <input type="number" name="price" class="form-control w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" id="price" value="{{ old('price', $book->price) }}" placeholder="Въведете цена">
        </div>

        <!-- Снимка на книгата (не-задължително) -->
        <div class="mb-4">
            <label for="image" class="block text-lg font-medium text-gray-700">Снимка на книгата</label>
            @if($book->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="w-32 h-32 object-cover mb-2 rounded-lg">
                    <small class="form-text text-gray-500">Ако качите ново изображение, съществуващото ще бъде заменено.</small>
                </div>
            @endif
            <input type="file" name="image" class="form-control w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" id="image" accept="image/*">
        </div>

        <!-- Запази бутон -->
        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Запази
        </button>
    </form>
    @else
        <p>Нямате права за редактиране на тази книга.</p>
    @endif
</div>
@endsection
