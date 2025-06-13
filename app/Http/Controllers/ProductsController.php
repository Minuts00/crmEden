<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
       // da riscrivere tutto secondo PRODUCTS
    public function all()
    {
        $products = Product::all();
        return view('catalog', compact('products'));
    }
    public function searchProduct(Request $request)
    {
        $products = Product::where("name", "LIKE", "%{$request->get('nome')}%")->get();
        $search = $request->get('name');

        return view('prodotti.cerca', compact('products', 'search'));
    }

    public function seeProduct(Request $request, int $ID)
    {
        $product = Product::find($ID);

        return view('catalog', compact('product'));
    }

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
            $product->save();
            //PMA 
            // $prodotto = Prodotto::create([
            //     'nome'->$request->nome,
            //     'prezzo'->$request->prezzo,
            //     'descrizione'->$request->descrizione,
            //     'stock'->$request->stock,
            //     'immagine'->$request->file('img')->store('public/media'),
            //     'id_categoria'->$request->categoria,
            //     'id_utente'->Auth::id(),
            // ]);

        }
    
    public function destroy(Product $product)
    {
        $product->delete();
        return to_route('dashboard');
    }
}
// da rivedere e testare