<?php

namespace Database\Seeders;

use App\Models\GoldPrice;
use Illuminate\Database\Seeder;

class GoldPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GoldPrice::create([
            'type' => 'Nhẫn Tròn 99.99%',
            'buy_price' => 10540000,
            'sell_price' => 10940000,
            'date' => now(),
            'order' => 1,
        ]);

        GoldPrice::create([
            'type' => 'Nữ Trang 99.9% (SG)',
            'buy_price' => 10400000,
            'sell_price' => 10910000,
            'date' => now(),
            'order' => 2,
        ]);

        GoldPrice::create([
            'type' => 'Nữ Trang 98.0% (SG)',
            'buy_price' => 10270000,
            'sell_price' => 10690000,
            'date' => now(),
            'order' => 3,
        ]);

        GoldPrice::create([
            'type' => 'Nhẫn Tròn 97.0%',
            'buy_price' => 10220000,
            'sell_price' => 10660000,
            'date' => now(),
            'order' => 4,
        ]);
    }
} 