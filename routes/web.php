<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoldPriceController;
use App\Http\Controllers\FeaturedProductController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\GoldPriceController as AdminGoldPriceController;
use App\Http\Controllers\Admin\PromotionController as AdminPromotionController;
use App\Http\Controllers\Admin\CatalogueController as AdminCatalogueController;
use App\Http\Controllers\Admin\FeaturedProductController as AdminFeaturedProductController;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

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

    // Promotion Routes
    Route::resource('admin/promotions', PromotionController::class)->names([
        'index' => 'admin.promotions.index',
        'create' => 'admin.promotions.create',
        'store' => 'admin.promotions.store',
        'edit' => 'admin.promotions.edit',
        'update' => 'admin.promotions.update',
        'destroy' => 'admin.promotions.destroy',
    ]);

    // Blog Post Routes
    Route::resource('admin/blog-posts', BlogPostController::class)->names([
        'index' => 'admin.blog_posts.index',
        'create' => 'admin.blog_posts.create',
        'store' => 'admin.blog_posts.store',
        'edit' => 'admin.blog_posts.edit',
        'update' => 'admin.blog_posts.update',
        'destroy' => 'admin.blog_posts.destroy',
    ]);
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gold Prices
    Route::get('/gold-prices', [AdminGoldPriceController::class, 'index'])->name('gold_prices');
    Route::post('/gold-prices', [AdminGoldPriceController::class, 'update'])->name('gold_prices.update');
    
    // Promotions
    Route::resource('promotions', AdminPromotionController::class);
    
    // Catalogues
    Route::resource('catalogues', AdminCatalogueController::class);
    
    // Featured Products
    Route::resource('featured_products', AdminFeaturedProductController::class);
    
    // Blog Posts
    Route::resource('blog_posts', AdminBlogPostController::class);
});

require __DIR__.'/auth.php';
