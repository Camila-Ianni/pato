<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->with('categories')
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', [
            'products' => $products,
        ]);
    }
}
