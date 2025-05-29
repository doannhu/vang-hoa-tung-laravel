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
            <h2 class="text-2xl font-semibold">Cập nhật bảng giá vàng</h2>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.promotions.index') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                Quản lý khuyến mãi
            </a>
            <a href="{{ route('admin.catalogues.index') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                Quản lý catalog
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
    <form method="POST" action="{{ route('admin.gold_prices.update') }}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-400">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-400 px-4 py-2">Loại vàng</th>
                        <th class="border border-gray-400 px-4 py-2">Mua vào</th>
                        <th class="border border-gray-400 px-4 py-2">Bán ra</th>
                        <th class="border border-gray-400 px-4 py-2">Cập nhật lúc</th>
                        <th class="border border-gray-400 px-4 py-2">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="gold-prices-body">
                    @foreach($goldPrices as $price)
                    <tr>
                        <td class="border border-gray-400 px-4 py-2">
                            <input type="text" name="prices[{{ $loop->index }}][type]" value="{{ $price->type }}" class="w-full px-2 py-1 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <input type="hidden" name="prices[{{ $loop->index }}][id]" value="{{ $price->id }}">
                        </td>
                        <td class="border border-gray-400 px-4 py-2">
                            <input type="number" step="0.01" name="prices[{{ $loop->index }}][buy_price]" value="{{ $price->buy_price }}" class="w-full px-2 py-1 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </td>
                        <td class="border border-gray-400 px-4 py-2">
                            <input type="number" step="0.01" name="prices[{{ $loop->index }}][sell_price]" value="{{ $price->sell_price }}" class="w-full px-2 py-1 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </td>
                        <td class="border border-gray-400 px-4 py-2 text-center">{{ $price->updated_at ? $price->updated_at->format('d/m/Y H:i') : 'Chưa cập nhật' }}</td>
                        <td class="border border-gray-400 px-4 py-2 text-center">
                            <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="deleteRow(this)" data-id="{{ $price->id }}">Xóa</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between mt-4">
            <button type="button" id="add-row" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">Thêm dòng</button>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-green-500">Cập nhật</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tbody = document.querySelector('#gold-prices-body');
        const addRowBtn = document.querySelector('#add-row');
        let rowCount = {{ count($goldPrices) }};

        // Add row
        addRowBtn.addEventListener('click', function() {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="border border-gray-400 px-4 py-2">
                    <input type="text" name="prices[${rowCount}][type]" class="w-full px-2 py-1 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <input type="hidden" name="prices[${rowCount}][id]" value="">
                </td>
                <td class="border border-gray-400 px-4 py-2">
                    <input type="number" step="0.01" name="prices[${rowCount}][buy_price]" class="w-full px-2 py-1 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </td>
                <td class="border border-gray-400 px-4 py-2">
                    <input type="number" step="0.01" name="prices[${rowCount}][sell_price]" class="w-full px-2 py-1 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </td>
                <td class="border border-gray-400 px-4 py-2 text-center">Chưa cập nhật</td>
                <td class="border border-gray-400 px-4 py-2 text-center">
                    <button type="button" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded focus:outline-none focus:ring-2 focus:ring-red-500" onclick="deleteRow(this)">Xóa</button>
                </td>
            `;
            tbody.appendChild(newRow);
            rowCount++;
        });

        // Delete row
        function deleteRow(button) {
            const row = button.closest('tr');
            const id = button.dataset.id;

            if (id) {
                // If row has an ID, send DELETE request
                fetch(`/admin/gold-prices/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        row.remove();
                    } else {
                        alert('Có lỗi xảy ra khi xóa giá vàng');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi xóa giá vàng');
                });
            } else {
                // If row has no ID, just remove it from DOM
                row.remove();
            }
        }

        // Make deleteRow function globally available
        window.deleteRow = deleteRow;
    });
</script>
@endsection