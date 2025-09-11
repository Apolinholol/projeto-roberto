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

    $ads = $ads->get();
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

Route::get('/AdsManager', function () {
    $categories = Category::all();
    return Inertia::render('AdsManager', [
        'categorias' => $categories
    ]);
})->middleware(['auth'])->name('AdsManager');

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
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/hub', [HubController::class, 'index'])->name('hub');
    Route::resource('users', UserController::class)->only(['index', 'update', 'destroy']);
    Route::resource('ads', AdsController::class);
    Route::resource('categories', CategoryController::class)->except(['show']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';