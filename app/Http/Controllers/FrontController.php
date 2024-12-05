<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class FrontController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('id', 'desc')->take(6)->get();
        $categories = Category::all();
        return view('front.index', compact('products', 'categories'));
    }

    public function details(Product $product)
    {
        return view('front.details', compact('product'));
    }
}
