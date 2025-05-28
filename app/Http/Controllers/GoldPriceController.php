<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoldPrice;
use App\Models\FeaturedProduct;

class GoldPriceController extends Controller
{
    // Show gold prices on homepage
    public function index()
    {
        $goldPrices = GoldPrice::all();
        $featuredProducts = FeaturedProduct::where('is_active', true)
            ->orderBy('order')
            ->get();
        return view('home', compact('goldPrices', 'featuredProducts'));
    }

    // Show admin page for editing gold prices
    public function adminIndex()
    {
        $goldPrices = GoldPrice::orderBy('order')->get();
        return view('admin.gold_prices', compact('goldPrices'));
    }

    // Update gold prices (admin only)
    public function update(Request $request)
    {
        $request->validate([
            'prices' => 'required|array',
            'prices.*.type' => 'required|string',
            'prices.*.buy_price' => 'required|numeric|min:0',
            'prices.*.sell_price' => 'required|numeric|min:0',
        ]);

        foreach ($request->prices as $priceData) {
            if (!empty($priceData['id'])) {
                // Update existing price
                $price = GoldPrice::find($priceData['id']);
                if ($price) {
                    $price->update([
                        'type' => $priceData['type'],
                        'buy_price' => $priceData['buy_price'],
                        'sell_price' => $priceData['sell_price'],
                    ]);
                }
            } else {
                // Create new price
                GoldPrice::create([
                    'type' => $priceData['type'],
                    'buy_price' => $priceData['buy_price'],
                    'sell_price' => $priceData['sell_price'],
                    'order' => GoldPrice::max('order') + 1,
                ]);
            }
        }

        return redirect()->route('admin.gold_prices')->with('success', 'Cập nhật giá vàng thành công');
    }

    public function destroy($id)
    {
        try {
            $price = GoldPrice::findOrFail($id);
            $price->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
} 