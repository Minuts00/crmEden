<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

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
            'img'          => 'nullable|image|max:10240',
            'stock'        => 'nullable|boolean',
        ]);

        $product = new Product();
        $product->category = $validated['category'];
        $product->name = $validated['name'];
        $product->description = $validated['description'] ?? null;
        $product->price_list = $validated['price_list'];
        $product->price_min = $validated['price_min'];
        $product->stock = $request->has('stock') ? 1 : 0;

        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('products', 'public');
            $product->img = $path;
        }

        $product->save();

        return redirect()->route('products.create')->with('success', 'Prodotto creato con successo!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_list' => 'nullable|numeric',
            'price_min' => 'nullable|numeric',
            'category' => 'nullable|exists:categories,ID',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'nullable|boolean',
        ]);

        $product->name = $validated['name'];
        $product->description = $validated['description'] ?? null;
        $product->price_list = $validated['price_list'] ?? null;
        $product->price_min = $validated['price_min'] ?? null;
        $product->category = $validated['category'] ?? $product->category;
        $product->stock = $request->has('stock') ? 1 : 0;

        if ($request->hasFile('img')) {
            if ($product->img && Storage::disk('public')->exists($product->img)) {
                Storage::disk('public')->delete($product->img);
            }
            $path = $request->file('img')->store('products', 'public');
            $product->img = $path;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Prodotto aggiornato con successo!');
    }

    public function show($id)
{
    $product = Product::findOrFail($id);
    return view('products.show', compact('product'));
}
}
