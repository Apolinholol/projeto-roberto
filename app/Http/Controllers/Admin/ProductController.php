<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Product/Index', [
            'products' => Product::all()->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'is_active' => $product->is_active,
                ];
            }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Product/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        Product::create($request->all());

        return redirect('/admin/products');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Admin/Product/Edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($request->has('is_active')) {
            $product->is_active = $request->is_active;
            $product->save();
        } else {
            $product->update($request->all());
        }

        return redirect('/admin/products');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('/admin/products');
    }
}
