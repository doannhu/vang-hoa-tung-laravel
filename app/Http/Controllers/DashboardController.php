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

        // --- Heat-bar data ---
        $monthFrom = Carbon::now()->subDays(30)->startOfDay();
        $monthHistory = GoldPriceHistory::where('type', $mainType)
            ->where('date', '>=', $monthFrom)
            ->orderBy('date')
            ->get();
        $minBuy = $monthHistory->min('buy_price');
        $maxBuy = $monthHistory->max('buy_price');
        $minSell = $monthHistory->min('sell_price');
        $maxSell = $monthHistory->max('sell_price');
        $today = Carbon::now()->toDateString();
        $todayHistory = GoldPriceHistory::where('type', $mainType)
            ->whereDate('date', $today)
            ->first();
        $todayBuy = $todayHistory ? $todayHistory->buy_price : null;
        $todaySell = $todayHistory ? $todayHistory->sell_price : null;

        // --- Summary Cards ---
        // Current
        $currentBuy = $todayBuy;
        $currentSell = $todaySell;
        // Spread
        $spreadAbs = ($currentBuy && $currentSell) ? $currentSell - $currentBuy : null;
        $spreadPct = ($currentBuy && $currentSell && $currentBuy > 0) ? round(($currentSell - $currentBuy) / $currentBuy * 100, 2) : null;
        // 7d change
        $sevenDaysAgo = Carbon::now()->subDays(7)->toDateString();
        $sevenDayHistory = GoldPriceHistory::where('type', $mainType)
            ->whereDate('date', $sevenDaysAgo)
            ->first();
        $change7d = ($currentBuy && $sevenDayHistory) ? round(($currentBuy - $sevenDayHistory->buy_price) / $sevenDayHistory->buy_price * 100, 2) : null;
        $change7dDir = ($change7d > 0) ? 'up' : (($change7d < 0) ? 'down' : 'flat');
        // 30d change
        $thirtyDaysAgo = Carbon::now()->subDays(30)->toDateString();
        $thirtyDayHistory = GoldPriceHistory::where('type', $mainType)
            ->whereDate('date', $thirtyDaysAgo)
            ->first();
        $change30d = ($currentBuy && $thirtyDayHistory) ? round(($currentBuy - $thirtyDayHistory->buy_price) / $thirtyDayHistory->buy_price * 100, 2) : null;
        $change30dDir = ($change30d > 0) ? 'up' : (($change30d < 0) ? 'down' : 'flat');
        // Sparklines (last 7 and 30 days)
        $spark7d = GoldPriceHistory::where('type', $mainType)
            ->where('date', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->orderBy('date')
            ->pluck('buy_price')
            ->toArray();
        $spark30d = GoldPriceHistory::where('type', $mainType)
            ->where('date', '>=', Carbon::now()->subDays(29)->startOfDay())
            ->orderBy('date')
            ->pluck('buy_price')
            ->toArray();
        $sparkSell7d = GoldPriceHistory::where('type', $mainType)
            ->where('date', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->orderBy('date')
            ->pluck('sell_price')
            ->toArray();
        $sparkSell30d = GoldPriceHistory::where('type', $mainType)
            ->where('date', '>=', Carbon::now()->subDays(29)->startOfDay())
            ->orderBy('date')
            ->pluck('sell_price')
            ->toArray();

        return view('admin.dashboard', compact(
            'latestPrices', 'chartData', 'range', 'compare',
            'minBuy', 'maxBuy', 'minSell', 'maxSell', 'todayBuy', 'todaySell',
            'currentBuy', 'currentSell', 'spreadAbs', 'spreadPct',
            'change7d', 'change7dDir', 'change30d', 'change30dDir',
            'spark7d', 'spark30d', 'sparkSell7d', 'sparkSell30d'
        ));
    }
} 