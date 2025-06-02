<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GoldPriceHistory;
use Carbon\Carbon;

class GoldPriceHistorySeeder extends Seeder
{
    public function run()
    {
        $prices = [
            ['date' => '2025-05-02', 'buy_price' => 11810000, 'sell_price' => 12010000],
            ['date' => '2025-05-05', 'buy_price' => 11660000, 'sell_price' => 11880000],
            ['date' => '2025-05-06', 'buy_price' => 11900000, 'sell_price' => 12100000],
            ['date' => '2025-05-07', 'buy_price' => 11880000, 'sell_price' => 12080000],
            ['date' => '2025-05-08', 'buy_price' => 11730000, 'sell_price' => 11930000],
            ['date' => '2025-05-09', 'buy_price' => 11880000, 'sell_price' => 12080000],
            ['date' => '2025-05-12', 'buy_price' => 11600000, 'sell_price' => 11930000],
            ['date' => '2025-05-13', 'buy_price' => 11730000, 'sell_price' => 11730000],
            ['date' => '2025-05-15', 'buy_price' => 11430000, 'sell_price' => 11700000],
            ['date' => '2025-05-16', 'buy_price' => 11430000, 'sell_price' => 11730000],
            ['date' => '2025-05-18', 'buy_price' => 11560000, 'sell_price' => 11810000],
            ['date' => '2025-05-20', 'buy_price' => 11730000, 'sell_price' => 11980000],
            ['date' => '2025-05-21', 'buy_price' => 11730000, 'sell_price' => 11930000],
            ['date' => '2025-05-25', 'buy_price' => 11530000, 'sell_price' => 11780000],
            ['date' => '2025-05-26', 'buy_price' => 10350000, 'sell_price' => 10700000],
            ['date' => '2025-05-27', 'buy_price' => 10380000, 'sell_price' => 10610000],
            ['date' => '2025-05-28', 'buy_price' => 10420000, 'sell_price' => 10670000],
            ['date' => '2025-05-29', 'buy_price' => 10350000, 'sell_price' => 10600000],
            ['date' => '2025-05-30', 'buy_price' => 10400000, 'sell_price' => 10650000],
            ['date' => '2025-05-31', 'buy_price' => 10370000, 'sell_price' => 10620000],
            ['date' => '2025-06-01', 'buy_price' => 10350000, 'sell_price' => 10550000],
            ['date' => '2025-06-02', 'buy_price' => 11380000, 'sell_price' => 11580000],
        ];

        foreach ($prices as $price) {
            GoldPriceHistory::create([
                'gold_price_id' => 1, // Adjust as needed
                'type' => 'Nhẫn Tròn 99.99%',
                'buy_price' => $price['buy_price'],
                'sell_price' => $price['sell_price'],
                'date' => Carbon::parse($price['date']),
                'updated_by' => 1, // Adjust as needed
            ]);
        }
    }
} 