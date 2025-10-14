<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
{
    $products = Product::all();
    return view('home', compact('products'));
}
  public function create()
{
    $categories = Category::all();
    return view('products.create', compact('categories'));
}

public function store(Request $request)
{
    
    $validated = $request->validate([
        'category'     => 'required|integer|exists:categories,ID',
        'name'         => 'required|string|max:255',
        'description'  => 'nullable|string',
        'price_list'   => 'required|numeric|min:0',
        'price_min'    => 'required|numeric|min:0',
        'img'          => 'nullable|image|max:2048', // max 2MB
    ]);

    $product = new Product();
    $product->category = $request->input('category');
    $product->name = $request->input('name');
    $product->description = $request->input('description');
    $product->price_list = $request->input('price_list');
    $product->price_min = $request->input('price_min');

    // gestisci l'immagine
    if ($request->hasFile('img')) {
    $path = $request->file('img')->store('products', 'public');
    $product->img = $path; // 
}
    else {
    // debug temporaneo
    dd('Nessun file ricevuto');
}

    $product->save();

    return redirect()->route('products.create');
}
}
// da rivedere e testare