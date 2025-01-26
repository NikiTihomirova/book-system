@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6 text-center">Добавяне на нова книга</h1>

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

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Заглавие -->
        <div class="mb-4">
            <label for="title" class="block text-lg font-medium text-gray-700">Заглавие</label>
            <input type="text" name="title" class="form-control w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" id="title" value="{{ old('title') }}" placeholder="Въведете заглавие" required>
        </div>

        <!-- Автор -->
        <div class="form-group mb-3">
            <label for="author">Автор</label>
            <input type="text" name="author" class="form-control" id="author" value="{{ old('author') }}" placeholder="Въведете име на автора" required>
        </div>

        <div class="form-group mb-3">
            <label for="genre">Жанр</label>
            <input type="text" name="genre" class="form-control" id="genre" value="{{ old('genre') }}" placeholder="Въведете жанр" required>
        </div>

        <!-- Цена -->
        <div class="mb-4">
            <label for="price" class="block text-lg font-medium text-gray-700">Цена</label>
            <input type="number" name="price" class="form-control w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" id="price" value="{{ old('price') }}" placeholder="Въведете цена" required>
        </div>

        <!-- Снимка на книгата -->
        <div class="mb-4">
            <label for="image" class="block text-lg font-medium text-gray-700">Снимка на книгата</label>
            <input type="file" name="image" class="form-control w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" id="image" accept="image/*">
        </div>

        <!-- Запази бутон -->
        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Добави
        </button>
    </form>
</div>
@endsection
