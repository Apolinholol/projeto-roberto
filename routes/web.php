<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\HubController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Models\Product;

Route::get('/', function () {
    $products = Product::all();
    return Inertia::render('Home', [
        'products' => $products,
    ]);
})->name('home');

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
