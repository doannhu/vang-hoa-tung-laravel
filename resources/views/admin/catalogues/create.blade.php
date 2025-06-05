@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Trang chủ
            </a>
        </div>
        <div class="flex items-center space-x-4">
            <h2 class="text-2xl font-bold text-gray-900">{{ isset($catalogue) ? 'Sửa catalog' : 'Thêm catalog mới' }}</h2>            
        </div>        
        <div class="flex items-center space-x-4">
            <h4 class="text-md font-bold text-gray-900">Tối đa 10 sản phẩm. Hãy xóa bớt bài cũ để thêm mới.</h4>
        </div>
        <!-- <div class="flex items-center space-x-4">
            <a href="{{ route('admin.gold_prices') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Quản lý giá vàng
            </a>
            <a href="{{ route('admin.featured_products.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Quản lý sản phẩm nổi bật
            </a>
        </div> -->
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ isset($catalogue) ? route('admin.catalogues.update', $catalogue) : route('admin.catalogues.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($catalogue))
                @method('PUT')
            @endif

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Tiêu đề</label>
                <input type="text" name="title" id="title" value="{{ old('title', $catalogue->title ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="subtitle" class="block text-sm font-medium text-gray-700">Phụ đề</label>
                <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $catalogue->subtitle ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                @error('subtitle')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
                <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description', $catalogue->description ?? '') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="features" class="block text-sm font-medium text-gray-700">Tính năng (mỗi dòng một tính năng)</label>
                <textarea name="features[]" id="features" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('features', isset($catalogue) ? implode("\n", $catalogue->features ?? []) : '') }}</textarea>
                @error('features')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Hình ảnh</label>
                @if(isset($catalogue) && $catalogue->image_path)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $catalogue->image_path) }}" alt="Current image" class="h-32 w-32 object-cover">
                    </div>
                @endif
                <input type="file" name="image" id="image" class="mt-1 block w-full" {{ !isset($catalogue) ? 'required' : '' }}>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="link" class="block text-sm font-medium text-gray-700">Link (tùy chọn)</label>
                <input type="url" name="link" id="link" value="{{ old('link', $catalogue->link ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('link')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="order" class="block text-sm font-medium text-gray-700">Thứ tự</label>
                <input type="number" name="order" id="order" value="{{ old('order', $catalogue->order ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ old('is_active', $catalogue->is_active ?? true) ? 'checked' : '' }}>
                    <span class="ml-2">Đang hiển thị</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('admin.catalogues.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Hủy</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ isset($catalogue) ? 'Cập nhật' : 'Thêm mới' }} catalog
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 