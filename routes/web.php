<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\HubController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Models\Product;
use Illuminate\Http\Request;



Route::get('/', function (Request $request) {
    $query   = $request->input('inpProcurar');
    $orderBy = $request->input('orderBy');

    $products = Product::query()
        // aplica busca somente se houver pesquisa
        ->when($query, function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%");
        });

    switch ($orderBy) {
        case 'preco_desc':
            $products->orderBy('price', 'desc');
            break;
        case 'preco_asc':
            $products->orderBy('price', 'asc');
            break;
        case 'data_desc':
            $products->orderBy('created_at', 'desc');
            break;
        default:
            $products->orderBy('price', 'asc');
            break;
    }

    $products = $products->get();

    return Inertia::render('Home', [
        'products' => $products,
        'filtro' => [
            'pesquisar' => $query,
            'orderBy'   => $orderBy,
        ]
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
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
