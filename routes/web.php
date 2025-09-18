<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\HubController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ChatController;
use App\Models\Ad;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function (Request $request) {
    $query   = $request->input('inpProcurar');
    $orderBy = $request->input('orderBy');
    $categoryId = $request->input('inpCategoriaId');

    $ads = Ad::query()
        // Mostrar apenas anúncios ativos na página inicial
        ->where('is_active', true)
        // Aplicar filtro de categoria se selecionado
        ->when($categoryId && $categoryId > 0, function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        })
        // Aplicar busca por texto se houver
        ->when($query, function ($q) use ($query) {
            $q->where(function ($subQ) use ($query) {
                $subQ->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            });
        });

    $categories = Category::all();

    switch ($orderBy) {
        case 'preco_desc':
            $ads->orderBy('price', 'desc');
            break;
        case 'preco_asc':
            $ads->orderBy('price', 'asc');
            break;
        case 'data_desc':
            $ads->orderBy('created_at', 'desc');
            break;
        default:
            $ads->orderBy('price', 'asc');
            break;
    }

    // Implementar paginação com 20 anúncios por página
    $ads = $ads->paginate(20)->withQueryString();
    $user = Auth::user();

    return Inertia::render('Home', [
        'ads' => $ads,
        'filtro' => [
            'pesquisar' => $query,
            'orderBy'   => $orderBy,
        ],
        'categorias' => $categories,
    ]);
})->name('home');


Route::get('/profile', function () {
    $user = Auth::user();
    $userAds = Ad::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return Inertia::render('Profile', [
        'anuncios' => $userAds
    ]);
})->middleware(['auth'])->name('profile');

Route::get('/profile/{id}', function ($id) {
    // dd($id);
    $user = App\Models\User::findOrFail($id);

    
    $userAds = Ad::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return Inertia::render('Profile', [
        'anunciante' => $user,
        'anuncios' => $userAds
    ]);
})->name('profile.show');

Route::get('/AdsManager', function () {
    $categories = Category::all();
    return Inertia::render('AdsManager', [
        'categorias' => $categories
    ]);
})->middleware(['auth'])->name('AdsManager');

// Rota para editar anúncio específico
Route::get('/AdsManager/edit/{id}', function ($id) {
    $ad = Ad::with('category')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    
    // Verificar se o anúncio está ativo
    if (!$ad->is_active) {
        return redirect()->route('profile')->with('error', 'Só é possível editar anúncios ativos. Este anúncio está desativado.');
    }
    
    $categories = Category::all();
    
    return Inertia::render('AdsManager', [
        'categorias' => $categories,
        'adToEdit' => [
            'id' => $ad->id,
            'titulo' => $ad->name,
            'descricao' => $ad->description,
            'preco' => $ad->price,
            'estoque' => $ad->stock,
            'categoria_id' => $ad->category_id,
            'fotos' => is_string($ad->image_path) ? (json_decode($ad->image_path, true) ?: []) : (is_array($ad->image_path) ? $ad->image_path : [])
        ]
    ]);
})->middleware(['auth'])->name('AdsManager.edit');

Route::get('/chat', [ChatController::class, 'index'])->middleware(['auth'])->name('chat.index');
Route::post('/chat/create', [ChatController::class, 'create'])->middleware(['auth'])->name('chat.create');

// Rota para página de categoria específica
Route::get('/categoria/{categoria}', function (Request $request, $categoria) {
    $query = $request->input('inpProcurar');
    $orderBy = $request->input('orderBy');

    // Buscar categoria pelo nome
    $category = Category::where('name', $categoria)->first();

    if (!$category) {
        abort(404, 'Categoria não encontrada');
    }

    $ads = Ad::query()
        ->where('category_id', $category->id)
        ->when($query, function ($q) use ($query) {
            $q->where(function ($subQ) use ($query) {
                $subQ->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            });
        });

    switch ($orderBy) {
        case 'preco_desc':
            $ads->orderBy('price', 'desc');
            break;
        case 'preco_asc':
            $ads->orderBy('price', 'asc');
            break;
        case 'data_desc':
            $ads->orderBy('created_at', 'desc');
            break;
        default:
            $ads->orderBy('price', 'asc');
            break;
    }

    $ads = $ads->get();
    $categories = Category::all();
    $user = Auth::user();

    return Inertia::render('Category', [
        'ads' => $ads,
        'categoria' => $categoria,
        'filtro' => [
            'pesquisar' => $query,
            'orderBy' => $orderBy,
        ],
        'categorias' => $categories,
    ]);
})->name('categoria');

Route::post('/chat/message', [ChatController::class, 'storeMessage'])->middleware(['auth'])->name('chat.message.store');
Route::get('/chat/{chat}/messages', [ChatController::class, 'getMessages'])->middleware(['auth'])->name('chat.messages.get');

Route::post('/chat/{chat}/finalize', [ChatController::class, 'finalizeNegotiation'])->middleware(['auth'])->name('chat.finalize');
Route::post('/chat/{chat}/reactivate', [ChatController::class, 'reactivateNegotiation'])->middleware(['auth'])->name('chat.reactivate');

Route::post('/ads', [AdsController::class, 'store'])
    ->middleware(['auth'])
    ->name('ads.store');

Route::put('/ads/{id}', [AdsController::class, 'update'])
    ->middleware(['auth'])
    ->name('ads.update');

// Rota para visualizar produto específico
Route::get('/product/{ad}', function (Ad $ad) {
    // Carregar relacionamentos necessários
    $ad->load(['category', 'user']);

    // Buscar anúncios relacionados da mesma categoria (máximo 4)
    $relatedAds = Ad::where('category_id', $ad->category_id)
        ->where('id', '!=', $ad->id)
        ->where('is_active', true)
        ->limit(4)
        ->get();

    return Inertia::render('Product', [
        'ad' => $ad,
        'relatedAds' => $relatedAds
    ]);
})->name('product.show');

// Rotas para usuários gerenciarem seus próprios anúncios
Route::middleware(['auth'])->group(function () {
    Route::patch('/my-ads/{ad}', [AdsController::class, 'updateMyAd'])->name('my-ads.update');
    Route::delete('/my-ads/{ad}', [AdsController::class, 'destroyMyAd'])->name('my-ads.destroy');
});

Route::get('/dashboard', [HubController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dashboard');

# Update profile route
Route::put('/profile/update', function (Request $request) {
    $user = Auth::user();
    
    $request->validate([
        'nomeCompleto' => 'required|string|max:255',
        'nomeUsuario' => 'required|string|max:255|unique:users,nomeUsuario,' . $user->id,
        'email' => 'required|email|unique:users,email,' . $user->id,
        'cpf' => 'nullable|string|max:14',
        'telefone' => 'nullable|string|max:20',
        'cidade' => 'required|string|max:255',
        'uf' => 'required|string|max:2',
        'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ], [
        'nomeCompleto.required' => 'O nome completo é obrigatório.',
        'nomeUsuario.required' => 'O nome de usuário é obrigatório.',
        'nomeUsuario.unique' => 'Este nome de usuário já está em uso.',
        'email.required' => 'O email é obrigatório.',
        'email.email' => 'Email inválido.',
        'email.unique' => 'Este email já está em uso.',
        'cidade.required' => 'A cidade é obrigatória.',
        'uf.required' => 'O estado é obrigatório.',
        'image_path.image' => 'O arquivo deve ser uma imagem.',
        'image_path.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif ou webp.',
        'image_path.max' => 'A imagem deve ter no máximo 2MB.',
    ]);
    
    $updateData = [
        'nomeCompleto' => $request->nomeCompleto,
        'nomeUsuario' => $request->nomeUsuario,
        'email' => $request->email,
        'cpf' => $request->cpf,
        'telefone' => $request->telefone,
        'cidade' => $request->cidade,
        'uf' => $request->uf,
    ];
    
    // Upload da nova foto se fornecida
    if ($request->hasFile('image_path')) {
        $path = $request->file('image_path')->store('profile', 'public');
        $updateData['image_path'] = '/storage/' . $path;
    }
    
    $user->update($updateData);
    
    return redirect()->route('profile')->with('success', 'Perfil atualizado com sucesso!');
})->middleware(['auth'])->name('profile.update');

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/hub', [HubController::class, 'index'])->name('hub');
    Route::get('/metrics', [\App\Http\Controllers\Admin\MetricsController::class, 'index'])->name('metrics');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::put('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('ads/{ad}/toggle-status', [AdsController::class, 'toggleStatus'])->name('ads.toggleStatus');
    Route::resource('ads', AdsController::class);
    Route::resource('categories', CategoryController::class)->except(['show']);
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
