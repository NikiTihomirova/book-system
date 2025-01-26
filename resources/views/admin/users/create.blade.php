@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Добавяне на нов потребител</h1>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Име</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Имейл</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Парола</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Потвърдете паролата</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="role">Роля</label>
            <select name="role" id="role" class="form-control" required>
                <option value="user">Потребител</option>
                <option value="admin">Администратор</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Създай потребител</button>
    </form>
</div>
@endsection
