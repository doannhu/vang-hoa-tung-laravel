@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Quản lý hệ thống</h1>
        <p class="text-gray-600">Chào mừng đến với trang quản lý của Vàng Hoa Tùng</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Gold Prices Management -->
        <a href="{{ route('admin.gold_prices') }}" class="block bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-center h-16 w-16 bg-blue-100 rounded-full mx-auto mb-4">
                <i class="fas fa-coins text-2xl text-blue-600"></i>
            </div>
            <h2 class="text-xl font-semibold text-center text-gray-900 mb-4">Quản lý giá vàng</h2>
            <p class="text-gray-600 text-center mb-6">Cập nhật và quản lý giá vàng hàng ngày</p>
            <div class="text-center">
                <span class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Truy cập
                </span>
            </div>
        </a>

        <!-- Promotions Management -->
        <a href="{{ route('admin.promotions.index') }}" class="block bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-center h-16 w-16 bg-cyan-100 rounded-full mx-auto mb-4">
                <i class="fas fa-gift text-2xl text-cyan-600"></i>
            </div>
            <h2 class="text-xl font-semibold text-center text-gray-900 mb-4">Quản lý khuyến mãi</h2>
            <p class="text-gray-600 text-center mb-6">Quản lý các chương trình khuyến mãi và ưu đãi</p>
            <div class="text-center">
                <span class="inline-flex items-center px-4 py-2 bg-cyan-600 text-white rounded-md">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Truy cập
                </span>
            </div>
        </a>

        <!-- Catalogues Management -->
        <a href="{{ route('admin.catalogues.index') }}" class="block bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-center h-16 w-16 bg-cyan-100 rounded-full mx-auto mb-4">
                <i class="fas fa-book text-2xl text-cyan-600"></i>
            </div>
            <h2 class="text-xl font-semibold text-center text-gray-900 mb-4">Quản lý catalog</h2>
            <p class="text-gray-600 text-center mb-6">Quản lý danh mục sản phẩm và bộ sưu tập</p>
            <div class="text-center">
                <span class="inline-flex items-center px-4 py-2 bg-cyan-600 text-white rounded-md">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Truy cập
                </span>
            </div>
        </a>

        <!-- Featured Products Management -->
        <a href="{{ route('admin.featured_products.index') }}" class="block bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-center h-16 w-16 bg-cyan-100 rounded-full mx-auto mb-4">
                <i class="fas fa-star text-2xl text-cyan-600"></i>
            </div>
            <h2 class="text-xl font-semibold text-center text-gray-900 mb-4">Quản lý sản phẩm nổi bật</h2>
            <p class="text-gray-600 text-center mb-6">Quản lý các sản phẩm được hiển thị nổi bật</p>
            <div class="text-center">
                <span class="inline-flex items-center px-4 py-2 bg-cyan-600 text-white rounded-md">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Truy cập
                </span>
            </div>
        </a>

        <!-- Blog Posts Management -->
        <a href="{{ route('admin.blog_posts.index') }}" class="block bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-center h-16 w-16 bg-cyan-100 rounded-full mx-auto mb-4">
                <i class="fas fa-blog text-2xl text-cyan-600"></i>
            </div>
            <h2 class="text-xl font-semibold text-center text-gray-900 mb-4">Quản lý bài viết</h2>
            <p class="text-gray-600 text-center mb-6">Quản lý các bài viết và tin tức</p>
            <div class="text-center">
                <span class="inline-flex items-center px-4 py-2 bg-cyan-600 text-white rounded-md">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Truy cập
                </span>
            </div>
        </a>

        <!-- Home Page -->
        <a href="{{ route('home') }}" class="block bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
            <div class="flex items-center justify-center h-16 w-16 bg-gray-100 rounded-full mx-auto mb-4">
                <i class="fas fa-home text-2xl text-gray-600"></i>
            </div>
            <h2 class="text-xl font-semibold text-center text-gray-900 mb-4">Trang chủ</h2>
            <p class="text-gray-600 text-center mb-6">Xem trang chủ của website</p>
            <div class="text-center">
                <span class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Truy cập
                </span>
            </div>
        </a>
    </div>
</div>
@endsection 