@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Dashboard</h1>
        <p class="text-gray-600">Thống kê giá vàng
            @if($range === '1m')
                1 tháng
            @elseif($range === '1w')
                1 tuần
            @else
                2 tuần
            @endif gần nhất</p>
    </div>

    <!-- Time Range Dropdown -->
    <div class="mb-6 flex justify-end">
        <form id="rangeForm" method="get">
            <label for="range" class="mr-2 font-medium">Kỳ thời gian:</label>
            <select name="range" id="range" class="border rounded px-2 py-1">
                <option value="1w" {{ $range === '1w' ? 'selected' : '' }}>1 tuần</option>
                <option value="2w" {{ $range === '2w' ? 'selected' : '' }}>2 tuần</option>
                <option value="1m" {{ $range === '1m' ? 'selected' : '' }}>1 tháng</option>
            </select>
        </form>
    </div>

    <!-- Line Chart -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Biểu đồ giá vàng</h2>
        <canvas id="goldPriceChart" height="100"></canvas>
        <!-- Heat-bar for Buy Price -->
        <div class="mt-8">
            <div class="mb-2 font-medium">Mua vào (30 ngày) thấp nhất - cao nhất:</div>
            <div class="relative w-full h-6 rounded-full bg-gradient-to-r from-blue-200 to-blue-500">
                @if(!is_null($todayBuy) && $maxBuy > $minBuy)
                    @php
                        $buyPercent = ($todayBuy - $minBuy) / ($maxBuy - $minBuy) * 100;
                    @endphp
                    <div class="absolute top-1/2 left-0" style="transform: translateX({{ $buyPercent }}%) translateY(-50%);">
                        <div class="w-4 h-4 bg-blue-700 rounded-full border-2 border-white shadow"></div>
                    </div>
                @endif
                <div class="absolute left-0 top-full mt-1 text-xs text-gray-700">₫ {{ number_format($minBuy, 0, ',', ' ') }}</div>
                <div class="absolute right-0 top-full mt-1 text-xs text-gray-700">₫ {{ number_format($maxBuy, 0, ',', ' ') }}</div>
            </div>
        </div>
        <!-- Heat-bar for Sell Price -->
        <div class="mt-8">
            <div class="mb-2 font-medium">Bán ra (30 ngày) thấp nhất - cao nhất:</div>
            <div class="relative w-full h-6 rounded-full bg-gradient-to-r from-pink-200 to-pink-500">
                @if(!is_null($todaySell) && $maxSell > $minSell)
                    @php
                        $sellPercent = ($todaySell - $minSell) / ($maxSell - $minSell) * 100;
                    @endphp
                    <div class="absolute top-1/2 left-0" style="transform: translateX({{ $sellPercent }}%) translateY(-50%);">
                        <div class="w-4 h-4 bg-pink-700 rounded-full border-2 border-white shadow"></div>
                    </div>
                @endif
                <div class="absolute left-0 top-full mt-1 text-xs text-gray-700">₫ {{ number_format($minSell, 0, ',', ' ') }}</div>
                <div class="absolute right-0 top-full mt-1 text-xs text-gray-700">₫ {{ number_format($maxSell, 0, ',', ' ') }}</div>
            </div>
        </div>
    </div>

    <!-- Price Table -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Giá vàng hôm nay</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loại vàng</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá mua</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá bán</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">So với hôm qua</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cập nhật lúc</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($latestPrices as $price)
                    @php
                        $diff = $compare[$price->type] ?? null;
                    @endphp
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $price->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($price->buy_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($price->sell_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($diff)
                                <span class="{{ $diff['buyDiff'] > 0 ? 'text-green-600' : ($diff['buyDiff'] < 0 ? 'text-red-600' : 'text-gray-600') }}">
                                    Mua: {{ $diff['buyDiff'] > 0 ? '+' : '' }}{{ number_format($diff['buyDiff'], 0, ',', '.') }}
                                </span><br>
                                <span class="{{ $diff['sellDiff'] > 0 ? 'text-green-600' : ($diff['sellDiff'] < 0 ? 'text-red-600' : 'text-gray-600') }}">
                                    Bán: {{ $diff['sellDiff'] > 0 ? '+' : '' }}{{ number_format($diff['sellDiff'], 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $price->date ? \Carbon\Carbon::parse($price->date)->format('d/m/Y') : 'Chưa cập nhật' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.getElementById('range').addEventListener('change', function() {
    document.getElementById('rangeForm').submit();
});
document.addEventListener('DOMContentLoaded', function() {
    const chartData = {
        labels: {!! json_encode($chartData['labels']) !!},
        buyPrices: {!! json_encode($chartData['buyPrices'], JSON_NUMERIC_CHECK) !!},
        sellPrices: {!! json_encode($chartData['sellPrices'], JSON_NUMERIC_CHECK) !!}
    };
    console.log('Chart Data:', chartData);

    const ctx = document.getElementById('goldPriceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Giá mua',
                data: chartData.buyPrices,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }, {
                label: 'Giá bán',
                data: chartData.sellPrices,
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + ' đ';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection 