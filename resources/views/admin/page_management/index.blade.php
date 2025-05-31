@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Quản lý hệ thống</h1>
        <p class="text-gray-600">Chào mừng đến với trang quản lý của Vàng Hoa Tùng</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <x-admin.button-link
            href="{{ route('admin.promotions.index') }}"
            icon="fa-gift"
            title="Quản lý khuyến mãi"
            description="Quản lý các chương trình khuyến mãi và ưu đãi"
        />

        <x-admin.button-link
            href="{{ route('admin.catalogues.index') }}"
            icon="fa-book"
            title="Quản lý catalog"
            description="Quản lý danh mục sản phẩm và bộ sưu tập"
        />

        <x-admin.button-link
            href="{{ route('admin.featured_products.index') }}"
            icon="fa-star"
            title="Quản lý sản phẩm nổi bật"
            description="Quản lý các sản phẩm được hiển thị nổi bật"
        />

        <x-admin.button-link
            href="{{ route('admin.blog_posts.index') }}"
            icon="fa-blog"
            title="Quản lý bài viết"
            description="Quản lý các bài viết và tin tức"
        />

        <x-admin.button-link
            href="{{ route('home') }}"
            icon="fa-home"
            title="Trang chủ"
            description="Xem trang chủ của website"
            color="gray"
            iconColor="gray"
        />
    </div>
</div>
@endsection 