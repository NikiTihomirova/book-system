@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактиране на потребител: {{ $user->name }}</h1>

    <!-- Показване на съобщения за успех или грешки -->
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Формуляр за редактиране на потребител -->
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Това указва, че формата е за update -->

        <div class="form-group">
            <label for="name">Име:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="email">Имейл:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="role">Роля:</label>
            <select id="role" name="role" class="form-control" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Администратор</option>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Потребител</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Запази промените</button>
        </div>
    </form>

    <!-- Връщане към списъка с потребители -->
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Назад към потребители</a>
</div>
@endsection