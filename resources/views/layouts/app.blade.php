<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
        /* Стилове за footer */
        /* Стилове за хоризонтален footer */
        footer {
            background-color: #f8f9fa;
            padding: 10px 20px;
            border-top: 1px solid #ddd;
            text-align: right;
            margin-top: 20px; /* Добавяме малко разстояние над footer-а */
        }

        footer .footer-text {
            font-size: 0.9rem;
            color: #333;
        }

        /* Премахваме излишния margin, който може да води до ненужни ленти */
        .container-fluid {
            padding: 0; /* Премахваме padding-а от .container-fluid, ако има такъв */
        }
    </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <div class="container my-5">
        @yield('content') 
    </div>

    <footer>
        <div class="footer-text">
            <p>Автор: Николета Карчева | Ф.№: 2309013491 | Специалност: Софтуерно инженерство | Година: 2025</p>
        </div>
    </footer>

    </body>
</html>
