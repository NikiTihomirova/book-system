<!-- Форма за добавяне на книга в кошницата -->
<form action="{{ route('cart.store') }}" method="POST">
    @csrf
    <!-- Скрита стойност на book_id -->
    <input type="hidden" name="book_id" value="{{ $book->id }}">

    <!-- Поле за въвеждане на количество -->
    <div class="mb-3">
        <label for="quantity" class="form-label">Количество</label>
        <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control">
    </div>

    <!-- Бутон за добавяне -->
    <button type="submit" class="btn btn-primary">Добави в кошницата</button>

    <!-- Съобщение за успех или грешка -->
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
</form>