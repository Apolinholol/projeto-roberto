<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ads;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Category/Index', [
            'categories' => Category::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Category/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories'
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Admin/Category/Edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Category $category)
    {
        // Check if category has ads
        if (Ads::where('category_id', $category->id)->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Não é possível excluir uma categoria que possui anúncios!');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}