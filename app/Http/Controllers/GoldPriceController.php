<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoldPrice;
use App\Models\GoldPriceHistory;
use App\Models\FeaturedProduct;
use App\Models\Catalogue;
use Illuminate\Support\Facades\DB;

class GoldPriceController extends Controller
{
    // Show gold prices on homepage
    public function index()
    {
        $goldPrices = GoldPrice::select('id', 'type', 'buy_price', 'sell_price', 'date')
            ->whereIn('id', function($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('gold_prices')
                    ->groupBy('type');
            })
            ->orderBy('type')
            ->get();

        $featuredProducts = FeaturedProduct::where('is_active', true)
            ->orderBy('order')
            ->get();
        $catalogues = Catalogue::where('is_active', true)
            ->orderBy('order')
            ->get();
        return view('home', compact('goldPrices', 'featuredProducts', 'catalogues'));
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

        DB::beginTransaction();
        try {
            foreach ($request->prices as $priceData) {
                if (!empty($priceData['id'])) {
                    // Update existing price
                    $price = GoldPrice::find($priceData['id']);
                    if ($price) {
                        // Update the price
                        $price->update([
                            'type' => $priceData['type'],
                            'buy_price' => $priceData['buy_price'],
                            'sell_price' => $priceData['sell_price'],
                            'date' => now()
                        ]);

                        // Save new prices to history after updating
                        GoldPriceHistory::create([
                            'gold_price_id' => $price->id,
                            'type' => $priceData['type'],
                            'buy_price' => $priceData['buy_price'],
                            'sell_price' => $priceData['sell_price'],
                            'date' => now(),
                            'updated_by' => auth()->id()
                        ]);
                    }
                } else {
                    // Create new price
                    $price = GoldPrice::create([
                        'type' => $priceData['type'],
                        'buy_price' => $priceData['buy_price'],
                        'sell_price' => $priceData['sell_price'],
                        'order' => GoldPrice::max('order') + 1,
                        'date' => now()
                    ]);

                    // Save initial price to history
                    GoldPriceHistory::create([
                        'gold_price_id' => $price->id,
                        'type' => $price->type,
                        'buy_price' => $price->buy_price,
                        'sell_price' => $price->sell_price,
                        'date' => $price->date,
                        'updated_by' => auth()->id()
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('admin.gold_prices')->with('success', 'Cập nhật giá vàng thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.gold_prices')->with('error', 'Có lỗi xảy ra khi cập nhật giá vàng: ' . $e->getMessage());
        }
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