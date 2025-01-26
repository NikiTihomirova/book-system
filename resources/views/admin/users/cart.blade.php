@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Вашата количка</h1>

    @if($cartItems->isEmpty())
        <p>Количката е празна. <a href="{{ route('books.index') }}" class="btn btn-info">Прегледай книги</a></p>
    @else
        <ul class="list-group">
            @foreach($cartItems as $item)
                <li class="list-group-item d-flex align-items-center">
                    <!-- Изображение на книгата -->
                    @if($item->book->image)
                        <img src="{{ asset('storage/' . $item->book->image) }}" alt="{{ $item->book->title }}" style="width: 50px; height: 75px; margin-right: 10px;">
                    @endif
                    <strong>{{ $item->book->title }}</strong> - {{ $item->quantity }} бр.

                    <!-- Обновяване на количеството -->
                    <form method="POST" action="{{ route('user.cart.update', $item->id) }}" class="d-inline ms-3">
                        @csrf
                        @method('PUT')
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control d-inline" style="width: 60px;">
                        <button type="submit" class="btn btn-sm btn-primary ms-2">Обнови</button>
                    </form>

                    <!-- Премахване на елемента -->
                    <form method="POST" action="{{ route('user.cart.remove', $item->id) }}" class="d-inline ms-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Премахни</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <!-- Общата стойност на количката -->
        <div class="mt-3">
            <h4>Обща стойност: {{ number_format($totalPrice, 2) }} лв</h4>
        </div>

        <!-- Бутон за продължаване към поръчката -->
        <a href="{{ route('user.checkout') }}" class="btn btn-success mt-3">Продължи към поръчката</a>
    @endif
</div>
@endsection