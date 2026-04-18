<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Product::class);
        $products = Product::with([
            'category:ID,name',
            'images' => function ($query) {
                $query->where('is_active', true)->ordered();
            },
        ])->get();

        $frontendProducts = $this->formatProducts($products);

        return view('home', compact('products', 'frontendProducts'));
    }

    public function create()
    {
         $this->authorize('create', Product::class);
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
         $this->authorize('create', Product::class);
        $validated = $request->validate([
            'category_id'     => 'required|integer|exists:categories,ID',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price_list'   => 'required|numeric|min:0',
            'price_min'    => 'required|numeric|min:0',
            'img'          => 'nullable|image|max:10240',
            'stock'        => 'nullable|boolean',
        ]);

        $product = new Product();
        $product->category_id = $validated['category_id'];
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
        $this->authorize('update', $product);
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_list' => 'nullable|numeric',
            'price_min' => 'nullable|numeric',
            'category_id' => 'nullable|exists:categories,ID',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'nullable|boolean',
        ]);

        $product->name = $validated['name'];
        $product->description = $validated['description'] ?? null;
        $product->price_list = $validated['price_list'] ?? null;
        $product->price_min = $validated['price_min'] ?? null;
        $product->category_id = $validated['category_id'] ?? $product->category_id;
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
    $this->authorize('view', $product);

    return view('products.show', compact('product'));
}
    private function formatProducts(Collection $products): array
    {
        return $products->map(function (Product $product) {
            $activeImages = $product->images;
            $primaryImage = $activeImages->firstWhere('is_primary', true) ?? $activeImages->first();

            $mainImage = $this->toPublicUrl($primaryImage?->img_path ?? $product->img);

            $gallery = $activeImages
                ->pluck('img_path')
                ->map(fn (?string $path) => $this->toPublicUrl($path))
                ->filter()
                ->values();

            if ($mainImage && !$gallery->contains($mainImage)) {
                $gallery->prepend($mainImage);
            }

            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'category_name' => $product->category?->name ?? 'Senza categoria',
                'price_list' => $product->price_list,
                'price_min' => $product->price_min,
                'stock' => (bool) $product->stock,
                'main_image' => $mainImage,
                'images' => $gallery->all(),
            ];
        })->all();
    }

    private function toPublicUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}
