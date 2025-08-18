<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;

class AdsController extends Controller
{
    public function index()
{
    return Inertia::render('Admin/Ads/Index', [
        'ads' => Ads::with('category')->get()->map(function ($ads) {
            return [
                'id' => $ads->id,
                'name' => $ads->name,
                'price' => $ads->price,
                'stock' => $ads->stock,
                'is_active' => $ads->is_active,
                'category' => $ads->category ? $ads->category->name : null,
            ];
        }),
    ]);
}


   public function create()
{
    $categories = Category::all(); 
    return Inertia::render('Admin/Ads/Create', [
        'categories' => $categories
    ]);
}


    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'is_active' => 'sometimes|boolean',
        'category_id' => 'required|exists:categories,id',
    ]);

    Ads::create($request->all());

    return redirect('/admin/ads');
}


    public function edit(Ads $ads)
{
    $categories = Category::all();
    return Inertia::render('Admin/Ads/Edit', [
        'ads' => $ads,
        'categories' => $categories
    ]);
}

    public function update(Request $request, Ads $ads)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->has('is_active')) {
            $ads->is_active = $request->is_active;
            $ads->save();
        } else {
            $ads->update($request->all());
        }

        return redirect('/admin/ads');
    }

    public function destroy(Ads $ads)
    {
        $ads->delete();

        return redirect('/admin/ads');
    }
}