<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $categorySlug = $request->string('category')->toString();

        $products = Product::query()
            ->with('categories')
            ->where('is_active', true)
            ->when($categorySlug !== '', function ($query) use ($categorySlug): void {
                $query->whereHas('categories', function ($categoryQuery) use ($categorySlug): void {
                    $categoryQuery->where('slug', $categorySlug);
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return view('catalog.index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $categorySlug,
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);
        $product->load('categories');

        return view('catalog.show', [
            'product' => $product,
        ]);
    }
}
