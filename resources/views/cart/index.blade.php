@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Кошница</h1>

    @if(count($cart) > 0)
        <!-- Таблица за кошницата -->
        <table class="table table-striped table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Продукт</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Обща цена</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $bookId => $item)
                    <tr>
                        <td>
                                {{ $item['name'] }}

                        </td>
                        <td>
                            <form action="{{ route('cart.update', $bookId) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control w-50" required>
                                <button type="submit" class="btn btn-primary btn-sm mt-2">Актуализирай</button>
                            </form>
                        </td>
                        <td>{{ $item['price'] }} лв.</td>
                        <td>{{ $item['price'] * $item['quantity'] }} лв.</td>
                        <td>
                            <form action="{{ route('cart.remove', $bookId) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Премахни</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Обща цена и бутон за изпразване -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h3>Обща цена: <strong>{{ $total }} лв.</strong></h3>
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-warning btn-lg">Изпразни кошницата</button>
            </form>
        </div>

    @else
        <p class="alert alert-warning">Кошницата ви е празна.</p>
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</div>
@endsection
