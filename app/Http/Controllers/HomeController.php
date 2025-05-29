<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoldPrice;
use App\Models\FeaturedProduct;
use App\Models\Catalogue;
use App\Models\Promotion;
use App\Models\BlogPost;

class HomeController extends Controller
{
    public function index()
    {
        $goldPrices = GoldPrice::orderBy('order')->get();
        $featuredProducts = FeaturedProduct::where('is_active', true)->orderBy('order')->get();
        $catalogues = Catalogue::where('is_active', true)->orderBy('order')->get();
        $promotions = Promotion::where('is_active', true)->orderBy('order')->get();
        $blogPosts = BlogPost::where('is_active', true)->orderBy('order')->get();

        return view('home', compact('goldPrices', 'featuredProducts', 'catalogues', 'promotions', 'blogPosts'));
    }
}
