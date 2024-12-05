<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('id', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'about' => 'required|string',
            'photo' => 'required|image|mimes:png,jpg,jpeg,svg',
        ]);
        DB::beginTransaction();
        try {
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('product_photo', 'public');
                $validated['photo'] = $photoPath;
            }
            $validated['slug'] = Str::slug($validated['name']);
            $newProduct = Product::create($validated);

            DB::commit();
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'system_error' => ('Something went wrong'.$e->getMessage())
            ]);
        }
    }

    public function show($id)
    {
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'about' => 'required|string',
            'photo' => 'sometimes|image|mimes:png,jpg,jpeg,svg',
        ]);
        DB::beginTransaction();
        try {
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('product_photo', 'public');
                $validated['photo'] = $photoPath;
            }
            $validated['slug'] = Str::slug($validated['name']);
            $product->update($validated);

            DB::commit();
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'system_error' => ('Something went wrong'.$e->getMessage())
            ]);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->back();
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'system_error' => ('Something went wrong'.$e->getMessage())
            ]);
        }
    }
}
