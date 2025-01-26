@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 text-center">Кошница</h1>

    @if(count($cart) > 0)
        <!-- Таблица за кошницата -->
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
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
                            <strong>{{ $item['name'] }}</strong> <!-- Името на книгата -->
                        </td>
                        <td>
                            <!-- Формуляр за актуализиране на количеството -->
                            <form action="{{ route('cart.update', $bookId) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="d-flex">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control w-50" required>
                                    <button type="submit" class="btn btn-info btn-sm ml-2 mt-2">Актуализирай</button>
                                </div>
                            </form>
                        </td>
                        <td>{{ number_format($item['price'], 2) }} лв.</td>
                        <td>{{ number_format($item['price'] * $item['quantity'], 2) }} лв.</td>
                        <td>
                            <!-- Премахване на книгата от кошницата -->
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
            <h3>Обща цена: <strong>{{ number_format($total, 2) }} лв.</strong></h3>
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-warning btn-lg">Изпразни кошницата</button>
            </form>
        </div>

    @else
        <p class="alert alert-warning text-center">Кошницата ви е празна.</p>
    @endif
</div>

<!-- Включване на стилове за Bootstrap 5 (ако не сте го включили в layout) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection
