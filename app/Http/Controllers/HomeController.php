<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
$products = Product::with([
            'category:id,name',
            'images' => function ($query) {
                $query->where('is_active', true)->ordered();
            },
        ])->get();

        $frontendProducts = $this->formatProducts($products);

        return view('home', compact('products', 'frontendProducts'));
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

        return asset('storage/' . ltrim($path, '/'));    }
}
