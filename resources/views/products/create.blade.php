<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
       @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <x-layout title="Carica Prodotto">
    <h1 class="text-xl font-bold mb-4">Carica un nuovo prodotto</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div class="col-md-6">
            <select id="category" class ="form-control" name="category" required>
                <option selected>Categoria</option>
                @foreach($categories as $category)
                    <option value="{{$category->ID}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="name" class="block font-medium">Nome</label>
            <input type="text" name="name" id="name" class="border p-2 w-full" value="{{ old('name') }}">
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block font-medium">Descrizione</label>
            <textarea name="description" id="description" class="border p-2 w-full">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="price_list" class="block font-medium">Prezzo di listino</label>
            <input type="number" step="0.01" name="price_list" id="price_list" class="border p-2 w-full" value="{{ old('price_list') }}">
            @error('price_list') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="price_min" class="block font-medium">Prezzo minimo</label>
            <input type="number" step="0.01" name="price_min" id="price_min" class="border p-2 w-full" value="{{ old('price_min') }}">
            @error('price_min') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="img" class="block font-medium">Immagine</label>
            <input type="file" name="img" id="img" accept="image/*" required class="border p-2 w-full">
            @error('img') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Carica prodotto</button>
    </form>
</x-layout>
</body>
</html>