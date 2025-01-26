@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Списък с книги</h1>

    <!-- Форма за търсене и филтриране -->
    <form method="GET" action="{{ route('books.index') }}" class="mb-4">
        <div class="flex space-x-4">
            <!-- Поле за търсене по заглавие -->
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Търсене по заглавие" class="px-4 py-2 rounded border border-gray-300 w-1/3">

            <!-- Поле за филтриране по жанр -->
            <input type="text" name="genre" value="{{ request('genre') }}" placeholder="Жанр" class="px-4 py-2 rounded border border-gray-300 w-1/3">

            <!-- Поле за филтриране по цена -->
            <select name="price" class="px-4 py-2 rounded border border-gray-300">
                <option value="">Изберете ценови диапазон</option>
                <option value="low" {{ request('price') == 'low' ? 'selected' : '' }}>До 20 лв</option>
                <option value="medium" {{ request('price') == 'medium' ? 'selected' : '' }}>20 - 50 лв</option>
                <option value="high" {{ request('price') == 'high' ? 'selected' : '' }}>Над 50 лв</option>
            </select>

            <!-- Бутон за търсене -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Търсене
            </button>
        </div>
    </form>

    @auth
    <div class="mb-4">
        <a href="{{ route('books.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Добавяне на книга
        </a>
    </div>
    @endauth

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($books as $book)
            <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col h-[500px]"> <!-- Фиксирана височина на кутийката -->
                <h2 class="text-lg font-bold">{{ $book->title }}</h2>

                <!-- Добавяне на жанр и цена в описанието на книгата -->
                <p class="text-sm text-gray-600 mb-2"><strong>Жанр:</strong> {{ ucfirst($book->genre->name) }}</p>
                <p class="text-sm text-gray-600 mb-2"><strong>Цена:</strong> {{ number_format($book->price, 2) }} лв</p>
                <p class="text-sm text-gray-600 mb-4">{{ $book->description }}</p>

                <!-- Проверка дали има изображение и показване само ако съществува -->
                <div class="flex-1">
                    @if ($book->image)
                        <img src="{{ asset('storage/' . $book->image) }}" class="w-full h-64 object-cover rounded-lg shadow-md mt-2" alt="{{ $book->title }}">
                    @else
                        <div class="w-full h-64 bg-gray-200 flex justify-center items-center rounded-lg mt-2">
                            <p class="text-center text-gray-500">Няма снимка</p>
                        </div>
                    @endif
                </div>

                <!-- Добавяне в кошницата (видимо за всички влезли потребители) -->
                @auth
                    <form method="POST" action="{{ route('cart.add', $book->id) }}">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 mt-2 rounded hover:bg-green-600">
                            Добавяне в кошницата
                        </button>
                    </form>
                @endauth

                <!-- Бутони за редактиране и изтриване - тези ще бъдат на дъното благодарение на flexbox -->
                @if (Auth::check() && Auth::user()->is_admin)
                    <!-- Ако потребителят е администратор, показваме бутоните за редактиране и изтриване -->
                    <div class="flex space-x-4 mt-4 mt-auto">
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
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
