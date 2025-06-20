<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
  public function create()
{
    return view('products.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'category'     => 'required|string|max:255',
        'name'         => 'required|string|max:255',
        'description'  => 'nullable|string',
        'price_list'   => 'required|numeric|min:0',
        'price_min'    => 'required|numeric|min:0',
        'img'          => 'nullable|image|max:2048', // max 2MB
    ]);

    // gestisci l'immagine
    if ($request->hasFile('img')) {
        $path = $request->file('img')->store('products', 'public');
        $validated['img'] = $path;
    }

    Product::create($validated);

    return redirect()->route('products.create')->with('success', 'Prodotto caricato con successo!');
}
}
// da rivedere e testare