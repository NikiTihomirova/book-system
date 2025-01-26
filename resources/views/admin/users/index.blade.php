@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Списък с потребители</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Добави нов потребител</a>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Име</th>
                    <th>Имейл</th>
                    <th>Роля</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Редактиране</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Изтриване</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
