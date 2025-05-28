<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogueController extends Controller
{
    public function index()
    {
        $catalogues = Catalogue::orderBy('order')->get();
        return view('admin.catalogues.index', compact('catalogues'));
    }

    public function create()
    {
        return view('admin.catalogues.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $imagePath = $request->file('image')->store('catalogues', 'public');

        Catalogue::create([
            'title' => $request->title,
            'image_path' => $imagePath,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'features' => $request->features,
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'is_active' => $request->is_active ?? true
        ]);

        return redirect()->route('admin.catalogues.index')
            ->with('success', 'Catalogue created successfully.');
    }

    public function edit(Catalogue $catalogue)
    {
        return view('admin.catalogues.edit', compact('catalogue'));
    }

    public function update(Request $request, Catalogue $catalogue)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($catalogue->image_path);
            // Store new image
            $imagePath = $request->file('image')->store('catalogues', 'public');
            $catalogue->image_path = $imagePath;
        }

        $catalogue->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'features' => $request->features,
            'link' => $request->link,
            'order' => $request->order ?? $catalogue->order,
            'is_active' => $request->is_active ?? $catalogue->is_active
        ]);

        return redirect()->route('admin.catalogues.index')
            ->with('success', 'Catalogue updated successfully.');
    }

    public function destroy(Catalogue $catalogue)
    {
        Storage::disk('public')->delete($catalogue->image_path);
        $catalogue->delete();

        return redirect()->route('admin.catalogues.index')
            ->with('success', 'Catalogue deleted successfully.');
    }
} 