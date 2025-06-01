<?php

namespace App\Http\Controllers;

use App\Models\GoldPrice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get today's prices
        $todayPrices = GoldPrice::whereDate('created_at', Carbon::today())->get();

        // Get last 7 days of prices
        $last7Days = GoldPrice::where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('d/m');
            });

        // Prepare chart data
        $chartData = [
            'labels' => [],
            'buyPrices' => [],
            'sellPrices' => []
        ];

        foreach ($last7Days as $date => $prices) {
            $chartData['labels'][] = $date;
            // Get average buy and sell prices for each day
            $chartData['buyPrices'][] = $prices->avg('buy_price');
            $chartData['sellPrices'][] = $prices->avg('sell_price');
        }

        return view('admin.dashboard', compact('todayPrices', 'chartData'));
    }
} 