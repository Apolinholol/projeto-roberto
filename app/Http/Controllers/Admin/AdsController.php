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
        'titulo' => 'required|string|max:255',
        'descricao' => 'required|string|max:500',
        'preco' => 'required|numeric|min:0.01',
        'estoque' => 'required|integer|min:1',
        'categoria_id' => 'required|exists:categories,id',
        'fotos' => 'required|array|min:1|max:10',
        'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB por foto
    ], [
        'titulo.required' => 'O título é obrigatório.',
        'descricao.required' => 'A descrição é obrigatória.',
        'descricao.max' => 'A descrição deve ter no máximo 500 caracteres.',
        'preco.required' => 'O preço é obrigatório.',
        'preco.min' => 'O preço deve ser maior que zero.',
        'estoque.required' => 'O estoque é obrigatório.',
        'estoque.min' => 'O estoque deve ser pelo menos 1.',
        'categoria_id.required' => 'A categoria é obrigatória.',
        'categoria_id.exists' => 'Categoria inválida.',
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
        'name' => $request->titulo,
        'description' => $request->descricao,
        'price' => $request->preco,
        'stock' => $request->estoque,
        'category_id' => $request->categoria_id,
        'image_path' => json_encode($imagePaths), // Salvar todas as imagens como JSON
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

    // Métodos para usuários gerenciarem seus próprios anúncios
    public function updateMyAd(Request $request, Ad $ad)
    {
        // Verificar se o anúncio pertence ao usuário logado
        if ($ad->user_id !== Auth::id()) {
            abort(403, 'Não autorizado');
        }

        // Permitir apenas atualização de status
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $ad->update([
            'is_active' => $request->is_active
        ]);

        return redirect()->back()->with('success', 'Status do anúncio atualizado com sucesso!');
    }

    public function destroyMyAd(Ad $ad)
    {
        // Verificar se o anúncio pertence ao usuário logado
        if ($ad->user_id !== Auth::id()) {
            abort(403, 'Não autorizado');
        }

        $ad->delete();

        return redirect()->back()->with('success', 'Anúncio excluído com sucesso!');
    }
}