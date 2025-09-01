<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class AdsController extends Controller
{
    public function index()
{
    return Inertia::render('Admin/Ads/Index', [
        'ads' => Ad::with('category')->get()->map(function ($ad) {
            return [
                'id' => $ad->id,
                'name' => $ad->name,
                'price' => $ad->price,
                'stock' => $ad->stock,
                'is_active' => $ad->is_active,
                'category_id' => $ad->category_id
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
        'description' => 'required|string|max:500',
        'price' => 'required|numeric|min:0.01',
        'stock' => 'required|integer|min:1',
        'category_id' => 'required|exists:categories,id',
        'fotos' => 'required|array|min:1|max:10',
        'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB por foto
    ], [
        'name.required' => 'O título é obrigatório.',
        'description.required' => 'A descrição é obrigatória.',
        'description.max' => 'A descrição deve ter no máximo 500 caracteres.',
        'price.required' => 'O preço é obrigatório.',
        'price.min' => 'O preço deve ser maior que zero.',
        'stock.required' => 'O estoque é obrigatório.',
        'stock.min' => 'O estoque deve ser pelo menos 1.',
        'category_id.required' => 'A categoria é obrigatória.',
        'category_id.exists' => 'Categoria inválida.',
        'fotos.required' => 'Pelo menos uma foto é obrigatória.',
        'fotos.min' => 'Pelo menos uma foto é obrigatória.',
        'fotos.max' => 'Máximo de 10 fotos permitidas.',
        'fotos.*.image' => 'Todos os arquivos devem ser imagens.',
        'fotos.*.mimes' => 'As imagens devem ser do tipo: jpeg, png, jpg, gif ou webp.',
        'fotos.*.max' => 'Cada imagem deve ter no máximo 5MB.',
    ]);

    // Upload das fotos
    $imagePaths = [];
    if ($request->hasFile('fotos')) {
        foreach ($request->file('fotos') as $foto) {
            $path = $foto->store('ads', 'public');
            $imagePaths[] = $path;
        }
    }

    // Criar anúncio
    Ad::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'stock' => $request->stock,
        'category_id' => $request->category_id,
        'image_paths' => json_encode($imagePaths), // Armazenar como JSON
        'is_active' => true,
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('AdsManager')->with('success', 'Anúncio criado com sucesso!');
}


    public function edit(Ad $ad)
{
    $categories = Category::all();
    return Inertia::render('Admin/Ads/Edit', [
        'ads' => $ad,
        'categories' => $categories
    ]);
}

    public function update(Request $request, Ad $ad)
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
            $ad->is_active = $request->is_active;
            $ad->save();
        } else {
            $ad->update($request->all());
        }

        return redirect('/admin/ads');
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();

        return redirect('/admin/ads');
    }
}