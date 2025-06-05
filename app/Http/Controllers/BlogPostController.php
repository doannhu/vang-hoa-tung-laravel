<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    public function index()
    {
        $blogPosts = BlogPost::orderBy('order')->get();
        return view('admin.blog_posts.index', compact('blogPosts'));
    }

    public function create()
    {
        return view('admin.blog_posts.create');
    }

    public function store(Request $request)
    {
        if (\App\Models\BlogPost::count() >= 5) {
            return redirect()->back()->with('error', 'Bạn chỉ có thể có tối đa 5 bài viết. Hãy xóa bớt bài viết cũ để thêm mới.');
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
            $path = $request->file('image')->store('blog_posts', 'public');
            $validated['image_path'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');

        BlogPost::create($validated);

        return redirect()->route('admin.blog_posts.index')
            ->with('success', 'Bài viết đã được thêm thành công.');
    }

    public function edit(BlogPost $blogPost)
    {
        return view('admin.blog_posts.edit', compact('blogPost'));
    }

    public function update(Request $request, BlogPost $blogPost)
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
            if ($blogPost->image_path) {
                Storage::disk('public')->delete($blogPost->image_path);
            }
            $path = $request->file('image')->store('blog_posts', 'public');
            $validated['image_path'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');

        $blogPost->update($validated);

        return redirect()->route('admin.blog_posts.index')
            ->with('success', 'Bài viết đã được cập nhật thành công.');
    }

    public function destroy(BlogPost $blogPost)
    {
        if ($blogPost->image_path) {
            Storage::disk('public')->delete($blogPost->image_path);
        }
        
        $blogPost->delete();

        return redirect()->route('admin.blog_posts.index')
            ->with('success', 'Bài viết đã được xóa thành công.');
    }
} 