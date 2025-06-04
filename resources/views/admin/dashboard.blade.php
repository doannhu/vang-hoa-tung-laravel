@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-xl font-bold text-gray-900 mb-4">Phân tích giá Nhẫn Tròn 99.99%</h2>
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
        <!-- Buy Price Card -->
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Mua</div>
            <div class="text-3xl font-extrabold text-blue-700 mb-1">
                {{ $currentBuy !== null ? number_format($currentBuy, 0, ',', ' ') . ' ₫' : '-' }}
            </div>
            <div class="w-full flex justify-center">
                @if(count($spark7d) > 1)
                    <svg width="50" height="15">
                        @php $min = min($spark7d); $max = max($spark7d); $range = $max - $min ?: 1; @endphp
                        @foreach($spark7d as $i => $v)
                            @if($i > 0)
                                <line x1="{{ ($i-1)*8 }}" y1="{{ 15-($spark7d[$i-1]-$min)/$range*13 }}" x2="{{ $i*8 }}" y2="{{ 15-($v-$min)/$range*13 }}" stroke="#2563eb" stroke-width="2" />
                            @endif
                        @endforeach
                    </svg>
                @endif
            </div>
        </div>
        <!-- Sell Price Card -->
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Bán</div>
            <div class="text-3xl font-extrabold text-pink-700 mb-1">
                {{ $currentSell !== null ? number_format($currentSell, 0, ',', ' ') . ' ₫' : '-' }}
            </div>
            <div class="w-full flex justify-center">
                @if(count($sparkSell7d) > 1)
                    <svg width="50" height="15">
                        @php $min = min($sparkSell7d); $max = max($sparkSell7d); $range = $max - $min ?: 1; @endphp
                        @foreach($sparkSell7d as $i => $v)
                            @if($i > 0)
                                <line x1="{{ ($i-1)*8 }}" y1="{{ 15-($sparkSell7d[$i-1]-$min)/$range*13 }}" x2="{{ $i*8 }}" y2="{{ 15-($v-$min)/$range*13 }}" stroke="#be185d" stroke-width="2" />
                            @endif
                        @endforeach
                    </svg>
                @endif
            </div>
        </div>
        <!-- Spread Card -->
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Chênh lệch</div>
            <div class="text-3xl font-extrabold mb-1">
                {{ $spreadAbs !== null ? number_format($spreadAbs, 0, ',', ' ') . ' ₫' : '-' }}
            </div>
            <div class="text-xs text-gray-500">
                {{ $spreadPct !== null ? ($spreadPct > 0 ? '+' : '') . $spreadPct . '%' : '' }}
            </div>
        </div>
        <!-- 7d Change Card -->
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">So giá mua vào với 7 ngày trước</div>
            <div class="flex items-center mb-1">
                <span class="text-3xl font-extrabold {{ $change7dDir === 'up' ? 'text-green-600' : ($change7dDir === 'down' ? 'text-red-600' : 'text-gray-600') }}">
                    {{ $change7d !== null ? ($change7d > 0 ? '+' : '') . $change7d . '%' : '-' }}
                </span>
                @if($change7dDir === 'up')
                    <svg class="ml-1" width="16" height="16" fill="none"><path d="M8 12V4M8 4l-4 4M8 4l4 4" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                @elseif($change7dDir === 'down')
                    <svg class="ml-1" width="16" height="16" fill="none"><path d="M8 4v8M8 12l-4-4M8 12l4-4" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                @endif
            </div>
            <div class="w-full flex justify-center">
                @if(count($spark7d) > 1)
                    <svg width="50" height="15">
                        @php $min = min($spark7d); $max = max($spark7d); $range = $max - $min ?: 1; @endphp
                        @foreach($spark7d as $i => $v)
                            @if($i > 0)
                                <line x1="{{ ($i-1)*8 }}" y1="{{ 15-($spark7d[$i-1]-$min)/$range*13 }}" x2="{{ $i*8 }}" y2="{{ 15-($v-$min)/$range*13 }}" stroke="#2563eb" stroke-width="2" />
                            @endif
                        @endforeach
                    </svg>
                @endif
            </div>
        </div>
        <!-- 30d Change Card -->
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">So giá mua vào với 30 ngày trước</div>
            <div class="flex items-center mb-1">
                <span class="text-3xl font-extrabold {{ $change30dDir === 'up' ? 'text-green-600' : ($change30dDir === 'down' ? 'text-red-600' : 'text-gray-600') }}">
                    {{ $change30d !== null ? ($change30d > 0 ? '+' : '') . $change30d . '%' : '-' }}
                </span>
                @if($change30dDir === 'up')
                    <svg class="ml-1" width="16" height="16" fill="none"><path d="M8 12V4M8 4l-4 4M8 4l4 4" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                @elseif($change30dDir === 'down')
                    <svg class="ml-1" width="16" height="16" fill="none"><path d="M8 4v8M8 12l-4-4M8 12l4-4" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                @endif
            </div>
            <div class="w-full flex justify-center">
                @if(count($spark30d) > 1)
                    <svg width="50" height="15">
                        @php $min = min($spark30d); $max = max($spark30d); $range = $max - $min ?: 1; @endphp
                        @foreach($spark30d as $i => $v)
                            @if($i > 0)
                                <line x1="{{ ($i-1)*2 }}" y1="{{ 15-($spark30d[$i-1]-$min)/$range*13 }}" x2="{{ $i*2 }}" y2="{{ 15-($v-$min)/$range*13 }}" stroke="#2563eb" stroke-width="2" />
                            @endif
                        @endforeach
                    </svg>
                @endif
            </div>
        </div>
    </div>

    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Dashboard</h1>
        <p class="text-gray-600">Thống kê giá nhẫn tròn 99.99%</p>
            <!-- @if($range === '1m')
                1 tháng
            @elseif($range === '1w')
                1 tuần
            @else
                2 tuần
            @endif</p> -->
    </div>

    <!-- Time Range Buttons -->
    <div class="mb-6 flex justify-end space-x-2">
        <a href="{{ route('dashboard', ['range' => '1w']) }}" 
           class="px-4 py-2 rounded {{ $range === '1w' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            1 tuần
        </a>
        <a href="{{ route('dashboard', ['range' => '2w']) }}" 
           class="px-4 py-2 rounded {{ $range === '2w' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            2 tuần
        </a>
        <a href="{{ route('dashboard', ['range' => '1m']) }}" 
           class="px-4 py-2 rounded {{ $range === '1m' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            1 tháng
        </a>
    </div>

    <!-- Heat-bar Chart -->
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

        <!-- Gauge Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
            <!-- Buy Price Gauge -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Giá mua vào 30 ngày</h3>
                <div class="relative">
                    <canvas id="buyPriceGauge" height="200"></canvas>
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                        <div class="text-2xl font-bold text-blue-700">
                            ₫ {{ number_format($todayBuy, 0, ',', ' ') }}
                        </div>
                        <div class="text-sm text-gray-500">Giá hiện tại</div>
                    </div>
                </div>
                <div class="flex justify-between mt-2 text-sm text-gray-600">
                    <div>Thấp nhất: ₫ {{ number_format($minBuy, 0, ',', ' ') }}</div>
                    <div>Cao nhất: ₫ {{ number_format($maxBuy, 0, ',', ' ') }}</div>
                </div>
            </div>

            <!-- Sell Price Gauge -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Giá bán ra 30 ngày</h3>
                <div class="relative">
                    <canvas id="sellPriceGauge" height="200"></canvas>
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                        <div class="text-2xl font-bold text-pink-700">
                            ₫ {{ number_format($todaySell, 0, ',', ' ') }}
                        </div>
                        <div class="text-sm text-gray-500">Giá hiện tại</div>
                    </div>
                </div>
                <div class="flex justify-between mt-2 text-sm text-gray-600">
                    <div>Thấp nhất: ₫ {{ number_format($minSell, 0, ',', ' ') }}</div>
                    <div>Cao nhất: ₫ {{ number_format($maxSell, 0, ',', ' ') }}</div>
                </div>
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
                                <span class="flex items-center">
                                    @if($diff['buyDiff'] > 0)
                                        <svg class="mr-1" width="10" height="10" viewBox="0 0 10 10"><polygon points="5,2 9,8 1,8" fill="#16a34a"/></svg>
                                    @elseif($diff['buyDiff'] < 0)
                                        <svg class="mr-1" width="10" height="10" viewBox="0 0 10 10"><polygon points="5,8 9,2 1,2" fill="#dc2626"/></svg>
                                    @endif
                                    <span class="{{ $diff['buyDiff'] > 0 ? 'text-green-600' : ($diff['buyDiff'] < 0 ? 'text-red-600' : 'text-gray-600') }}">
                                        Mua: {{ $diff['buyDiff'] > 0 ? '+' : '' }}{{ number_format($diff['buyDiff'], 0, ',', '.') }}
                                    </span>
                                </span><br>
                                <span class="flex items-center">
                                    @if($diff['sellDiff'] > 0)
                                        <svg class="mr-1" width="10" height="10" viewBox="0 0 10 10"><polygon points="5,2 9,8 1,8" fill="#16a34a"/></svg>
                                    @elseif($diff['sellDiff'] < 0)
                                        <svg class="mr-1" width="10" height="10" viewBox="0 0 10 10"><polygon points="5,8 9,2 1,2" fill="#dc2626"/></svg>
                                    @endif
                                    <span class="{{ $diff['sellDiff'] > 0 ? 'text-green-600' : ($diff['sellDiff'] < 0 ? 'text-red-600' : 'text-gray-600') }}">
                                        Bán: {{ $diff['sellDiff'] > 0 ? '+' : '' }}{{ number_format($diff['sellDiff'], 0, ',', '.') }}
                                    </span>
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
document.addEventListener('DOMContentLoaded', function() {
    // Line Chart
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

    // // --- Gauge Needle Plugin ---
    // const gaugeNeedlePlugin = {
    //     id: 'gaugeNeedle',
    //     afterDraw(chart, args, options) {
    //         const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;
    //         const centerX = (left + right) / 2;
    //         const centerY = bottom;
    //         const radius = Math.min(width, height) * 0.4;
    //         let min, max, current, color;
    //         if (chart.canvas.id === 'buyPriceGauge') {
    //             min = {{ $minBuy }};
    //             max = {{ $maxBuy }};
    //             current = {{ $todayBuy }};
    //             color = 'rgb(59, 130, 246)'; // blue-500
    //         } else if (chart.canvas.id === 'sellPriceGauge') {
    //             min = {{ $minSell }};
    //             max = {{ $maxSell }};
    //             current = {{ $todaySell }};
    //             color = 'rgb(236, 72, 153)'; // pink-500
    //         } else {
    //             return;
    //         }
    //         if (max === min) return; // avoid division by zero
    //         const percentage = (current - min) / (max - min);
    //         const angle = Math.PI * (1 - percentage); // 180deg left (min) to right (max)
    //         ctx.save();
    //         ctx.translate(centerX, centerY);
    //         ctx.rotate(angle - Math.PI);
    //         ctx.beginPath();
    //         ctx.moveTo(0, 0);
    //         ctx.lineTo(radius, 0);
    //         ctx.lineWidth = 5;
    //         ctx.strokeStyle = color;
    //         ctx.shadowColor = color;
    //         ctx.shadowBlur = 6;
    //         ctx.stroke();
    //         ctx.restore();
    //     }
    // };
    // Chart.register(gaugeNeedlePlugin);

    // // Buy Price Gauge
    // const buyCtx = document.getElementById('buyPriceGauge').getContext('2d');
    // new Chart(buyCtx, {
    //     type: 'doughnut',
    //     data: {
    //         datasets: [{
    //             data: [1],
    //             backgroundColor: ['rgba(59, 130, 246, 0.1)'],
    //             borderWidth: 0
    //         }]
    //     },
    //     options: {
    //         circumference: 180,
    //         rotation: -90,
    //         cutout: '70%',
    //         plugins: {
    //             legend: { display: false },
    //             tooltip: { enabled: false }
    //         },
    //         responsive: true,
    //         maintainAspectRatio: false
    //     },
    //     plugins: ['gaugeNeedle']
    // });

    // // Sell Price Gauge
    // const sellCtx = document.getElementById('sellPriceGauge').getContext('2d');
    // new Chart(sellCtx, {
    //     type: 'doughnut',
    //     data: {
    //         datasets: [{
    //             data: [1],
    //             backgroundColor: ['rgba(236, 72, 153, 0.1)'],
    //             borderWidth: 0
    //         }]
    //     },
    //     options: {
    //         circumference: 180,
    //         rotation: -90,
    //         cutout: '70%',
    //         plugins: {
    //             legend: { display: false },
    //             tooltip: { enabled: false }
    //         },
    //         responsive: true,
    //         maintainAspectRatio: false
    //     },
    //     plugins: ['gaugeNeedle']
    // });
    // Buy Price Gauge
    const buyCtx = document.getElementById('buyPriceGauge').getContext('2d');
    new Chart(buyCtx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    {{ $todayBuy - $minBuy }},
                    {{ $maxBuy - $todayBuy }},
                    {{ $minBuy }}
                ],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',  // blue-500
                    'rgba(59, 130, 246, 0.2)',  // blue-200
                    'transparent'
                ],
                borderWidth: 0
            }]
        },
        options: {
            circumference: 180,
            rotation: -90,
            cutout: '80%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Sell Price Gauge
    const sellCtx = document.getElementById('sellPriceGauge').getContext('2d');
    new Chart(sellCtx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    {{ $todaySell - $minSell }},
                    {{ $maxSell - $todaySell }},
                    {{ $minSell }}
                ],
                backgroundColor: [
                    'rgba(236, 72, 153, 0.8)',  // pink-500
                    'rgba(236, 72, 153, 0.2)',  // pink-200
                    'transparent'
                ],
                borderWidth: 0
            }]
        },
        options: {
            circumference: 180,
            rotation: -90,
            cutout: '80%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
</script>
@endpush
@endsection 