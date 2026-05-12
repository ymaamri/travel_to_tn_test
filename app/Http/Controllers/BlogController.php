<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display public list of published blog posts
     */
    public function index()
    {
        $blogs = Blog::with('user')
            ->published()
            ->latest('published_at')
            ->paginate(9);
        return view('blogs.index', compact('blogs'));
    }

    /**
     * Display a single blog post
     */
    public function show($slug)
    {
        $blog = Blog::with('user')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->firstOrFail();

        return view('blogs.show', compact('blog'));
    }

    /**
     * Admin: list all blog posts
     */
    public function adminIndex()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $blogs = Blog::with('user')->latest()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Admin: show create form
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('admin.blogs.create');
    }

    /**
     * Admin: store new blog post
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog_images', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->has('is_published') && $request->is_published) {
            $validated['published_at'] = now();
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created!');
    }

    /**
     * Admin: show edit form
     */
    public function edit(Blog $blog)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Admin: update blog post
     */
    public function update(Request $request, Blog $blog)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog_images', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->has('is_published') && $request->is_published && !$blog->is_published) {
            $validated['published_at'] = now();
        } elseif (!$request->has('is_published') && $blog->is_published) {
            $validated['is_published'] = false;
            $validated['published_at'] = null;
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated!');
    }

    /**
     * Admin: delete blog post
     */
    public function destroy(Blog $blog)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted!');
    }
}