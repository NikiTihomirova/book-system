@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Списък с книги</h1>
    
    @auth
    <div class="mb-4">
        <a href="{{ route('books.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Добавяне на книга
        </a>
    </div>
    @endauth

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($books as $book)
            <div class="bg-white shadow rounded p-4">
                <h2 class="text-lg font-bold">{{ $book->title }}</h2>
                <p class="text-sm text-gray-600">{{ $book->description }}</p>
                <img src="{{ $book->image_url }}" alt="{{ $book->title }}" class="w-full h-48 object-cover mt-2">

                <!-- Добавяне в кошницата (видимо за всички влезли потребители) -->
                @auth
                    <form method="POST" action="{{ route('cart.add', $book->id) }}">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 mt-2 rounded hover:bg-green-600">
                            Добавяне в кошницата
                        </button>
                    </form>
                @endauth

                <!-- Бутони за редактиране и изтриване -->
                <div class="flex space-y-2 mt-4"> <!-- използваме space-y-2 за вертикално разстояние -->
                    <!-- Редактиране -->
                    <a href="{{ route('books.edit', $book->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                        Редактиране
                    </a>

                    <!-- Изтриване -->
                    <form method="POST" action="{{ route('books.destroy', $book->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Изтриване
                        </button>
                    </form>
                </div>
                    
            </div>
        @endforeach
    </div>
</div>
@endsection
