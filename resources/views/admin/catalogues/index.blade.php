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
            <h2 class="text-2xl font-semibold">Quản lý catalog</h2>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.gold_prices') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Quản lý giá vàng
            </a>
            <a href="{{ route('admin.featured_products.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Quản lý sản phẩm nổi bật
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <a href="{{ route('admin.catalogues.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Thêm catalog mới
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Hình ảnh</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Tiêu đề</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Phụ đề</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Thứ tự</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($catalogues as $catalogue)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                @if($catalogue->image_path)
                                    <img src="{{ asset('storage/' . $catalogue->image_path) }}" alt="{{ $catalogue->title }}" class="h-20 w-20 object-cover rounded">
                                @else
                                    <span class="text-gray-400">Không có hình</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                {{ $catalogue->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                {{ $catalogue->subtitle }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                {{ $catalogue->order }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                {{ $catalogue->is_active ? 'Đang hiển thị' : 'Đã ẩn' }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">
                                <a href="{{ route('admin.catalogues.edit', $catalogue) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Sửa</a>
                                <form action="{{ route('admin.catalogues.destroy', $catalogue) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Bạn có chắc chắn muốn xóa catalog này?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 