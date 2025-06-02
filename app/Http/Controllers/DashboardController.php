<?php

namespace App\Http\Controllers;

use App\Models\GoldPrice;
use App\Models\GoldPriceHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->query('range', '2w');
        if ($range === '1m') {
            $days = 31;
        } elseif ($range === '1w') {
            $days = 7;
        } else {
            $days = 14;
        }
        $mainType = 'Nhẫn Tròn 99.99%';

        // Get latest prices for each type
        $latestPrices = GoldPrice::select('id', 'type', 'buy_price', 'sell_price', 'date')
            ->whereIn('id', function($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('gold_prices')
                    ->groupBy('type');
            })
            ->orderBy('type')
            ->get();

        // Get previous day's price for main type
        $yesterday = Carbon::now()->subDay()->toDateString();
        $prevPrice = GoldPriceHistory::where('type', $mainType)
            ->whereDate('date', $yesterday)
            ->first();

        // Get price history for chart (main type only)
        $fromDate = Carbon::now()->subDays($days - 1)->startOfDay();
        $history = GoldPriceHistory::where('type', $mainType)
            ->where('date', '>=', $fromDate)
            ->orderBy('date')
            ->get();

        // Prepare chart data
        $chartData = [
            'labels' => [],
            'buyPrices' => [],
            'sellPrices' => []
        ];
        foreach ($history as $record) {
            $chartData['labels'][] = Carbon::parse($record->date)->format('d/m');
            $chartData['buyPrices'][] = $record->buy_price;
            $chartData['sellPrices'][] = $record->sell_price;
        }

        // Prepare comparison array: only main type has value
        $compare = [];
        foreach ($latestPrices as $price) {
            if ($price->type === $mainType && $prevPrice) {
                $compare[$price->type] = [
                    'buyDiff' => $price->buy_price - $prevPrice->buy_price,
                    'sellDiff' => $price->sell_price - $prevPrice->sell_price,
                ];
            } else {
                $compare[$price->type] = null;
            }
        }

        return view('admin.dashboard', compact('latestPrices', 'chartData', 'range', 'compare'));
    }
} 