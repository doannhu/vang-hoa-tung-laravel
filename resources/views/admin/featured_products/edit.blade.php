@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Chỉnh sửa sản phẩm nổi bật</h2>
        <a href="{{ route('admin.featured_products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Quay lại
        </a>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('admin.featured_products.update', $featuredProduct) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Tiêu đề
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror"
                    id="title" type="text" name="title" value="{{ old('title', $featuredProduct->title) }}" required>
                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">
                    Hình ảnh
                </label>
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $featuredProduct->image_path) }}" alt="{{ $featuredProduct->title }}" class="w-32 h-32 object-cover">
                </div>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('image') border-red-500 @enderror"
                    id="image" type="file" name="image" accept="image/*">
                <p class="text-gray-600 text-xs mt-1">Để trống nếu không muốn thay đổi hình ảnh</p>
                @error('image')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Mô tả
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror"
                    id="description" name="description" rows="3" required>{{ old('description', $featuredProduct->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="link">
                    Link (tùy chọn)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('link') border-red-500 @enderror"
                    id="link" type="url" name="link" value="{{ old('link', $featuredProduct->link) }}">
                @error('link')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="order">
                    Thứ tự hiển thị
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('order') border-red-500 @enderror"
                    id="order" type="number" name="order" value="{{ old('order', $featuredProduct->order) }}">
                @error('order')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $featuredProduct->is_active) ? 'checked' : '' }}>
                    Hiển thị sản phẩm
                </label>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Cập nhật sản phẩm
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 