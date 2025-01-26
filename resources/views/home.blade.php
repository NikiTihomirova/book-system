@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Стилове за картите, за да бъдат със същия размер */
        .card {
            height: 100%; /* Задава височина на картата */
            border-radius: 10px; /* Леко заоблени ъгли */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Лека сянка за картите */
            transition: transform 0.3s ease-in-out; /* Плавно увеличаване при hover */
        }

        .card:hover {
            transform: scale(1.05); /* Леко увеличение на картата при hover */
        }

        .card-img-top {
            object-fit: cover; /* Картината да запълни картата без да я изкривява */
            height: 250px; /* Фиксирана височина на картината */
            border-top-left-radius: 10px; /* Заоблени ъгли на картината */
            border-top-right-radius: 10px; /* Заоблени ъгли на картината */
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 15px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333; /* Тъмно сиво за текста */
        }

        .card-text {
            font-size: 0.875rem;
            color: #6c757d; /* Сиво за текста */
        }

        .card-container {
            margin-bottom: 30px; /* Разстояние между редовете */
        }
    </style>
</head>
<body>

    <div class="container my-5">
        <h1 class="display-4 text-center">Добре дошли в нашата Система за книги!</h1>
        <p class="lead text-center">Тук можете да намерите много интересни книги по различни теми. Прегледайте нашия списък с книги и направете своя избор.</p>

        <div class="text-center mt-4">
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg">Прегледай книги</a>
                <a href="{{ route('cart.index') }}" class="btn btn-secondary btn-lg">Кошница</a>
            </div>
        </div>

        <div class="mt-5">
            <h2 class="text-center">Последни 6 книги</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                @foreach($books as $book)
                    <div class="col card-container">
                        <div class="card">
                            <img src="{{ $book->image_url }}" class="card-img-top" alt="Book Image">
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->title }}</h5>
                                <p class="card-text">{{ Str::limit($book->description, 100) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</body>
</html>
@endsection
