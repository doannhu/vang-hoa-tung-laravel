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
        $latestHistoryDate = GoldPriceHistory::where('type', $mainType)
        ->orderByDesc('date')
        ->value('date');

        // Get latest prices for each type
        $latestPrices = GoldPrice::select('id', 'type', 'buy_price', 'sell_price', 'date')
            ->whereIn('id', function($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('gold_prices')
                    ->groupBy('type');
            })
            ->orderBy('type')
            ->get();

        // Get previous day's price for each type (previous day = day before latest available date)
        $prevPrices = [];
        foreach ($latestPrices as $price) {
            // Find the latest date for this type
            $latestDate = GoldPriceHistory::where('type', $price->type)
                ->orderByDesc('date')
                ->value('date');
            // Find the previous date before the latest date
            $prevDate = GoldPriceHistory::where('type', $price->type)
                ->whereRaw('DATE(date) < DATE(?)', [$latestDate])
                ->orderByDesc('date')
                ->value('date');
            // Get the price for the previous date
            $prevPrice = GoldPriceHistory::where('type', $price->type)
                ->whereRaw('DATE(date) = DATE(?)', [$prevDate])
                ->orderByDesc('id')
                ->first();
            $prevPrices[$price->type] = $prevPrice;
        }

        // Prepare comparison array
        $compare = [];
        foreach ($latestPrices as $price) {
            $prevPrice = $prevPrices[$price->type] ?? null;
            if ($prevPrice) {
                $compare[$price->type] = [
                    'buyDiff' => $price->buy_price - $prevPrice->buy_price,
                    'sellDiff' => $price->sell_price - $prevPrice->sell_price,
                ];
            } else {
                $compare[$price->type] = null;
            }
        }

        // Get price history for chart (main type only) - latest price for each date
        $fromDate = $latestHistoryDate ? Carbon::parse($latestHistoryDate)->subDays($days)->startOfDay() : Carbon::now()->subDays($days - 1)->startOfDay();

        // Step 1: Get the IDs of the latest record for each date
        $latestIds = GoldPriceHistory::select(DB::raw('MAX(id) as id'))
        ->where('type', $mainType)
        ->where('date', '>=', $fromDate)
        ->groupBy(DB::raw('DATE(date)'))
        ->pluck('id');

        // Step 2: Get the full records for those IDs, ordered by date
        $history = GoldPriceHistory::whereIn('id', $latestIds)
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

        // --- Heat-bar data ---
        $monthFrom = $latestHistoryDate ? Carbon::parse($latestHistoryDate)->subDays(30)->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
        $monthHistory = GoldPriceHistory::where('type', $mainType)
            ->where('date', '>=', $monthFrom)
            ->orderBy('date')
            ->get();
        $minBuy = $monthHistory->min('buy_price');
        $maxBuy = $monthHistory->max('buy_price');
        $minSell = $monthHistory->min('sell_price');
        $maxSell = $monthHistory->max('sell_price');
        
        $today = $latestHistoryDate;
        $todayHistory = GoldPriceHistory::where('type', $mainType)
            ->whereDate('date', $today)
            ->orderByDesc('id')
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
        
        // 7d and 30d change -- compare latest price with 7 and 30 days before the latest available date
        if ($latestHistoryDate) {
            $sevenDaysAgo = Carbon::parse($latestHistoryDate)->subDays(7)->toDateString();
            $thirtyDaysAgo = Carbon::parse($latestHistoryDate)->subDays(30)->toDateString();

            // Get 7-day history for main type
            $sevenDayHistory = GoldPriceHistory::where('type', $mainType)
                ->whereDate('date', '<=', $sevenDaysAgo)
                ->orderByDesc('date')
                ->orderByDesc('id')
                ->first();

            $thirtyDayHistory = GoldPriceHistory::where('type', $mainType)
                ->whereDate('date', '<=', $thirtyDaysAgo)
                ->orderByDesc('date')
                ->orderByDesc('id')
                ->first();

            $change7d = ($currentBuy && $sevenDayHistory) ? round(($currentBuy - $sevenDayHistory->buy_price) / $sevenDayHistory->buy_price * 100, 2) : null;
            $change7dDir = ($change7d > 0) ? 'up' : (($change7d < 0) ? 'down' : 'flat');

            $change30d = ($currentBuy && $thirtyDayHistory) ? round(($currentBuy - $thirtyDayHistory->buy_price) / $thirtyDayHistory->buy_price * 100, 2) : null;
            $change30dDir = ($change30d > 0) ? 'up' : (($change30d < 0) ? 'down' : 'flat');
        } else {
            $change7d = $change30d = $change7dDir = $change30dDir = null;
        }
        
        // Sparklines (last 7 and 30 days) using latest available date as reference
        if ($latestHistoryDate) {
            $spark7dFrom = Carbon::parse($latestHistoryDate)->subDays(6)->startOfDay();
            $spark30dFrom = Carbon::parse($latestHistoryDate)->subDays(29)->startOfDay();

            // buy price for 7 days -- average buy price for each day
            $spark7d = GoldPriceHistory::select(
                DB::raw('DATE(date) as day'),
                DB::raw('AVG(buy_price) as avg_buy_price')
            )
            ->where('type', $mainType)
            ->where('date', '>=', $spark7dFrom)
            ->where('date', '<=', $latestHistoryDate)
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy('day')
            ->pluck('avg_buy_price')
            ->toArray();

            // buy price for 30 days -- average buy price for each day
            $spark30d = GoldPriceHistory::select(
                DB::raw('DATE(date) as day'),
                DB::raw('AVG(buy_price) as avg_buy_price')
            )
            ->where('type', $mainType)
            ->where('date', '>=', $spark30dFrom)
            ->where('date', '<=', $latestHistoryDate)
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy('day')
            ->pluck('avg_buy_price')
            ->toArray();   

            // sell price for 7 days -- average sell price for each day
            $sparkSell7d = GoldPriceHistory::select(
                DB::raw('DATE(date) as day'),
                DB::raw('AVG(sell_price) as avg_sell_price')
            )
            ->where('type', $mainType)
            ->where('date', '>=', $spark7dFrom)
            ->where('date', '<=', $latestHistoryDate)
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy('day')
            ->pluck('avg_sell_price')
            ->toArray();

            // sell price for 30 days -- average sell price for each day
            $sparkSell30d = GoldPriceHistory::select(
                DB::raw('DATE(date) as day'),
                DB::raw('AVG(sell_price) as avg_sell_price')
            )
            ->where('type', $mainType)
            ->where('date', '>=', $spark30dFrom)
            ->where('date', '<=', $latestHistoryDate)
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy('day')
            ->pluck('avg_sell_price')
            ->toArray();
        } else {
            $spark7d = $spark30d = $sparkSell7d = $sparkSell30d = [];
        }

        return view('admin.dashboard', compact(
            'latestPrices', 'chartData', 'range', 'compare',
            'minBuy', 'maxBuy', 'minSell', 'maxSell', 'todayBuy', 'todaySell',
            'currentBuy', 'currentSell', 'spreadAbs', 'spreadPct',
            'change7d', 'change7dDir', 'change30d', 'change30dDir',
            'spark7d', 'spark30d', 'sparkSell7d', 'sparkSell30d'
        ));
    }
} 