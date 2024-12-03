<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|image|mimes:png,jpg,jpeg,svg',
        ]);
        DB::beginTransaction();
        try {
            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('category_icons', 'public');
                $validated['icon'] = $iconPath;
            }
            $validated['slug'] = \Str::slug($validated['name']);
            $newCategory = Category::create($validated);

            DB::commit();
            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'system_error' => ('Something went wrong' . $e->getMessage())
            ]);
        }
    }

    public function show($id) {}

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'sometimes|image|mimes:png,jpg,jpeg,svg',
        ]);
        DB::beginTransaction();
        try {
            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('category_icons', 'public');
                $validated['icon'] = $iconPath;
            }
            $validated['slug'] = \Str::slug($validated['name']);
            $category->update($validated);

            DB::commit();
            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'system_error' => ('Something went wrong' . $e->getMessage())
            ]);
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()->back();
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'system_error' => ('Something went wrong' . $e->getMessage())
            ]);
        }
    }
}
