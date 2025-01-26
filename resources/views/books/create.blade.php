@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Добавяне на нова книга</h1>

    <!-- Показване на съобщения за грешки -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Потвърждение за успешно съхранение -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Заглавие</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}" placeholder="Въведете заглавие" required>
        </div>

        <div class="form-group">
            <label for="author">Автор</label>
            <input type="text" name="author" class="form-control" id="author" value="{{ old('author') }}" placeholder="Въведете име на автора" required>
        </div>

        <div class="form-group">
            <label for="genre">Жанр</label>
            <input type="text" name="genre" class="form-control" id="genre" value="{{ old('genre') }}" placeholder="Въведете жанр" required>
        </div>

        <div class="form-group">
            <label for="price">Цена</label>
            <input type="number" step="0.01" name="price" class="form-control" id="price" value="{{ old('price') }}" placeholder="Въведете цена" required>
        </div>

        <div class="form-group">
            <label for="image">Снимка на книгата (незадължително)</label>
            <input type="file" name="image" class="form-control" id="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Добави</button>
    </form>
</div>
@endsection
