<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Product::where('name', 'like', "%$keyword%")->get();

        return view('front.search', compact('products', 'keyword'));
    }

    public function category(Category $category)
    {
        $products = Product::where('category_id', $category->id)->with('category')->get();
        return view('front.category', compact('products', 'category'));
    }
}
