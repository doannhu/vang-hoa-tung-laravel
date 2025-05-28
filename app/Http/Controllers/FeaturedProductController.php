<?php

namespace App\Http\Controllers;

use App\Models\FeaturedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeaturedProductController extends Controller
{
    public function index()
    {
        $products = FeaturedProduct::orderBy('order')->get();
        return view('admin.featured_products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.featured_products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $imagePath = $request->file('image')->store('featured-products', 'public');

        FeaturedProduct::create([
            'title' => $request->title,
            'image_path' => $imagePath,
            'description' => $request->description,
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'is_active' => $request->is_active ?? true
        ]);

        return redirect()->route('admin.featured_products.index')
            ->with('success', 'Featured product created successfully.');
    }

    public function edit(FeaturedProduct $featuredProduct)
    {
        return view('admin.featured_products.edit', compact('featuredProduct'));
    }

    public function update(Request $request, FeaturedProduct $featuredProduct)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($featuredProduct->image_path);
            // Store new image
            $imagePath = $request->file('image')->store('featured-products', 'public');
            $featuredProduct->image_path = $imagePath;
        }

        $featuredProduct->update([
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'order' => $request->order ?? $featuredProduct->order,
            'is_active' => $request->is_active ?? $featuredProduct->is_active
        ]);

        return redirect()->route('admin.featured_products.index')
            ->with('success', 'Featured product updated successfully.');
    }

    public function destroy(FeaturedProduct $featuredProduct)
    {
        Storage::disk('public')->delete($featuredProduct->image_path);
        $featuredProduct->delete();

        return redirect()->route('admin.featured_products.index')
            ->with('success', 'Featured product deleted successfully.');
    }
}
