<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoldPriceController;
use App\Http\Controllers\FeaturedProductController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GoldPriceController as AdminGoldPriceController;
use App\Http\Controllers\PromotionController as AdminPromotionController;
use App\Http\Controllers\CatalogueController as AdminCatalogueController;
use App\Http\Controllers\FeaturedProductController as AdminFeaturedProductController;
use App\Http\Controllers\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard Routes
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Management Routes
    Route::get('/admin/management', [ManagementController::class, 'index'])->name('admin.management');

    // Gold Prices Routes
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

    // User Management Routes
    Route::resource('admin/users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
});

require __DIR__.'/auth.php';
