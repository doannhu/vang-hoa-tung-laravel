<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoldPriceController;
use App\Http\Controllers\FeaturedProductController;
use App\Http\Controllers\CatalogueController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GoldPriceController::class, 'index'])->name('home');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin/gold-prices', [GoldPriceController::class, 'adminIndex'])->name('admin.gold_prices');
    Route::post('/admin/gold-prices/update', [GoldPriceController::class, 'update'])->name('admin.gold_prices.update');
    Route::delete('/admin/gold-prices/{id}', [GoldPriceController::class, 'destroy'])->name('admin.gold_prices.destroy');
    
    // Featured Products Routes
    Route::resource('admin/featured-products', FeaturedProductController::class)->names([
        'index' => 'admin.featured_products.index',
        'create' => 'admin.featured_products.create',
        'store' => 'admin.featured_products.store',
        'edit' => 'admin.featured_products.edit',
        'update' => 'admin.featured_products.update',
        'destroy' => 'admin.featured_products.destroy',
    ]);

    // Catalogue Routes
    Route::resource('admin/catalogues', CatalogueController::class)->names([
        'index' => 'admin.catalogues.index',
        'create' => 'admin.catalogues.create',
        'store' => 'admin.catalogues.store',
        'edit' => 'admin.catalogues.edit',
        'update' => 'admin.catalogues.update',
        'destroy' => 'admin.catalogues.destroy',
    ]);
});

require __DIR__.'/auth.php';
