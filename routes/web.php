<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\HubController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Models\Ads;
use App\Models\Category;
use Illuminate\Http\Request;




Route::get('/', function (Request $request) {
    $query   = $request->input('inpProcurar');
    $orderBy = $request->input('orderBy');

    $ads = Ads::query()
        // aplica busca somente se houver pesquisa
        ->when($query, function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%");
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