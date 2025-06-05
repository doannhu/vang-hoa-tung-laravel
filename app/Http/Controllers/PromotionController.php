<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::orderBy('order')->get();
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        if (\App\Models\Promotion::count() >= 5) {
            return redirect()->back()->with('error', 'Bạn chỉ có thể có tối đa 5 khuyến mãi. Hãy xóa bớt để thêm mới.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('promotions', 'public');
            $validated['image_path'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');

        Promotion::create($validated);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Khuyến mãi đã được thêm thành công.');
    }

    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($promotion->image_path) {
                Storage::disk('public')->delete($promotion->image_path);
            }
            $path = $request->file('image')->store('promotions', 'public');
            $validated['image_path'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');

        $promotion->update($validated);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Khuyến mãi đã được cập nhật thành công.');
    }

    public function destroy(Promotion $promotion)
    {
        if ($promotion->image_path) {
            Storage::disk('public')->delete($promotion->image_path);
        }
        
        $promotion->delete();

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Khuyến mãi đã được xóa thành công.');
    }
} 