<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <nav class="bg-gray-800 h-screen text-white p-4 space-y-4 overflow-y-auto">

    <h2 class="text-lg font-semibold mb-4">Navigazione</h2>

    <a href="{{ route('dashboard') }}" class="block p-2 rounded hover:bg-gray-700">Dashboard</a>
    <a href="{{ route('orders.index') }}" class="block p-2 rounded hover:bg-gray-700">Lista Ordini</a>
    <a href="{{ route('products.index') }}" class="block p-2 rounded hover:bg-gray-700">Prodotti</a>

    <hr class="my-4 border-gray-600">

    <h2 class="text-lg font-semibold mb-4">Nuovo Ordine Rapido</h2>

    <form action="{{ route('orders.store') }}" method="POST" class="space-y-2">
        @csrf

        <!-- Utente -->
        <div>
            <label class="block text-sm">Utente:</label>
            <select name="id_user" class="text-black p-1 w-full">
                @foreach(\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Nome Ordine -->
        <div>
            <label class="block text-sm">Nome:</label>
            <input type="text" name="name" class="text-black p-1 w-full" required>
        </div>

        <!-- Prezzo -->
        <div>
            <label class="block text-sm">Prezzo:</label>
            <input type="number" step="0.01" name="price" class="text-black p-1 w-full" required>
        </div>

        <!-- Descrizione (facoltativa, ridotta) -->
        <div>
            <label class="block text-sm">Descrizione:</label>
            <textarea name="description" class="text-black p-1 w-full" rows="2"></textarea>
        </div>

        <button type="submit" class="bg-green-500 w-full py-1 rounded">Crea</button>
    </form>

</nav>

</body>
</html>