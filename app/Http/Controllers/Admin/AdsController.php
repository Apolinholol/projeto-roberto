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
                'name' => $ad->name ?? 'Sem nome',
                'price' => $ad->price ?? 0,
                'stock' => $ad->stock ?? 0,
                'cidade' => $ad->cidade ?? 'Sem cidade',
                'uf' => $ad->uf ?? 'Sem UF',
                'is_active' => (bool) $ad->is_active,
                'category' => $ad->category ? [ 'name' => $ad->category->name ] : null
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

    // Obter dados do usuário logado
    $user = Auth::user();
    
    // Verificar se o usuário tem cidade e UF configurados
    if (!$user->cidade || !$user->uf) {
        return back()->withErrors([
            'user_location' => 'Para criar anúncios, você precisa ter cidade e UF configurados no seu perfil. Atualize suas informações pessoais primeiro.'
        ]);
    }
    
    // Upload das fotos
    $imagePaths = [];
    if ($request->hasFile('fotos')) {
        foreach ($request->file('fotos') as $foto) {
            $path = $foto->store('ads', 'public');
            $imagePaths[] = $path;
        }
    }

    // Criar anúncio usando cidade e UF do usuário logado
    Ad::create([
        'name' => $request->titulo,
        'description' => $request->descricao,
        'price' => $request->preco,
        'stock' => $request->estoque,
        'cidade' => $user->cidade,
        'uf' => $user->uf,
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

    public function update(Request $request, $id)
    {
        // Buscar anúncio do usuário logado
        $ad = Ad::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        // Validação similar ao store
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string|max:500',
            'preco' => 'required|numeric|min:0.01',
            'estoque' => 'required|integer|min:1',
            'categoria_id' => 'required|exists:categories,id',
            'fotos' => 'nullable|array|max:10',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
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
            'fotos.max' => 'Máximo de 10 fotos permitidas.',
            'fotos.*.image' => 'Todos os arquivos devem ser imagens.',
            'fotos.*.mimes' => 'As imagens devem ser do tipo: jpeg, png, jpg, gif ou webp.',
            'fotos.*.max' => 'Cada imagem deve ter no máximo 5MB.',
        ]);

        // Obter dados do usuário logado
        $user = Auth::user();
        
        // Verificar se o usuário tem cidade e UF configurados
        if (!$user->cidade || !$user->uf) {
            return back()->withErrors([
                'user_location' => 'Para editar anúncios, você precisa ter cidade e UF configurados no seu perfil.'
            ]);
        }
        
        // Upload das novas fotos se houver
        $imagePaths = [];
        if ($request->hasFile('fotos')) {
            // Manter fotos existentes se não enviou novas
            $existingImages = is_string($ad->image_path) ? json_decode($ad->image_path, true) : $ad->image_path;
            if (is_array($existingImages)) {
                $imagePaths = $existingImages;
            }
            
            // Adicionar novas fotos
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('ads', 'public');
                $imagePaths[] = $path;
            }
        } else {
            // Manter fotos existentes
            $imagePaths = is_string($ad->image_path) ? json_decode($ad->image_path, true) : $ad->image_path;
            if (!is_array($imagePaths)) {
                $imagePaths = [];
            }
        }

        // Atualizar anúncio
        $ad->update([
            'name' => $request->titulo,
            'description' => $request->descricao,
            'price' => $request->preco,
            'stock' => $request->estoque,
            'cidade' => $user->cidade,
            'uf' => $user->uf,
            'category_id' => $request->categoria_id,
            'image_path' => json_encode($imagePaths),
        ]);

        return redirect()->route('profile')->with('success', 'Anúncio atualizado com sucesso!');
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();

        return redirect('/admin/ads');
    }

    public function toggleStatus(Request $request, Ad $ad)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $ad->update([
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('success', 'Status do anúncio atualizado com sucesso!');
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