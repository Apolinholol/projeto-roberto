<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\HubController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ChatController;
use App\Models\Ads;
use App\Models\Category;
use Illuminate\Http\Request;




Route::get('/', function (Request $request) {
    $query   = $request->input('inpProcurar');
    $orderBy = $request->input('orderBy');
    $categoryId = $request->input('inpCategoriaId');
    
    $ads = Ads::query()
        // aplica busca somente se houver pesquisa
        ->when($query, function ($q) use ($query, $categoryId) {
            $q->where(function ($subQ) use ($query) {
                $subQ->where('name', 'like', "%{$query}%")
                     ->orWhere('description', 'like', "%{$query}%");
            })
            ->where('is_active', true);

            if ($categoryId > 0) {
                $q->where('category_id', $categoryId);
            }
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

    return Inertia::render('Home', [
        'ads' => $ads,
        'filtro' => [
            'pesquisar' => $query,
            'orderBy'   => $orderBy,
        ],
        'categorias' => $categories
    ]);
})->name('home');


Route::get('/profile', function () {
    return Inertia::render('Profile');
})->middleware(['auth'])->name('profile');

Route::get('/AdsManager', function () {
    return Inertia::render('AdsManager');
})->middleware(['auth'])->name('AdsManager');

Route::get('/chat', [ChatController::class, 'index'])->middleware(['auth'])->name('chat');

Route::post('/chat/message', [ChatController::class, 'storeMessage'])->middleware(['auth'])->name('chat.message.store');
Route::get('/chat/{chat}/messages', [ChatController::class, 'getMessages'])->middleware(['auth'])->name('chat.messages.get');

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