<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <x-layout title="Crea Ordine">
    <form method="POST" action="{{ route('orders.store') }}" enctype="multipart/form-data">
    @csrf

    <input type="text" name="name" placeholder="Nome prodotto" required>
    <textarea name="description" placeholder="Descrizione" required></textarea>
    <input type="number" name="price" step="0.01" placeholder="Prezzo" required>

    <input type="file" name="payment_proof" accept="image/*">

    <button type="submit">Invia Ordine</button>
</form>
</x-layout>
</body>
</html>