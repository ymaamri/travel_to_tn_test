<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransportInfoController extends Controller
{
    /**
     * Display a listing of transport info items.
     */
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $transports = TransportInfo::with('creator')
            ->latest()
            ->paginate(15);

        return view('admin.transport.index', compact('transports'));
    }

    /**
     * Show the form for creating a new transport info.
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.transport.create');
    }

    /**
     * Store a newly created transport info.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:transport_infos,title',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'map_url' => 'nullable|url',
            'contact_info' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('transport_images', 'public');
        }

        // Handle gallery images
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('transport_gallery', 'public');
                $galleryPaths[] = $path;
            }
        }
        $validated['gallery'] = $galleryPaths;

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = Auth::id();
        $validated['is_published'] = $request->has('is_published');

        TransportInfo::create($validated);

        return redirect()->route('admin.transport.index')
            ->with('success', 'Transport information created successfully!');
    }

    /**
     * Show the form for editing the specified transport info.
     */
    public function edit(TransportInfo $transportInfo)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.transport.edit', compact('transportInfo'));
    }

    /**
     * Update the specified transport info.
     */
    public function update(Request $request, TransportInfo $transportInfo)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:transport_infos,title,' . $transportInfo->id,
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'map_url' => 'nullable|url',
            'contact_info' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            // Delete old if exists
            if ($transportInfo->featured_image) {
                \Storage::disk('public')->delete($transportInfo->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('transport_images', 'public');
        }

        // Handle new gallery images (append to existing)
        $existingGallery = $transportInfo->gallery ?? [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('transport_gallery', 'public');
                $existingGallery[] = $path;
            }
        }
        $validated['gallery'] = $existingGallery;

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');

        $transportInfo->update($validated);

        return redirect()->route('admin.transport.index')
            ->with('success', 'Transport information updated successfully!');
    }

    /**
     * Remove the specified transport info.
     */
    public function destroy(TransportInfo $transportInfo)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Delete images from storage
        if ($transportInfo->featured_image) {
            \Storage::disk('public')->delete($transportInfo->featured_image);
        }
        if ($transportInfo->gallery) {
            foreach ($transportInfo->gallery as $image) {
                \Storage::disk('public')->delete($image);
            }
        }

        $transportInfo->delete();

        return redirect()->route('admin.transport.index')
            ->with('success', 'Transport information deleted successfully!');
    }

    /**
     * Remove a single gallery image.
     */
    public function removeImage(Request $request, TransportInfo $transportInfo)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $imagePath = $request->input('image');
        $gallery = $transportInfo->gallery ?? [];

        if (($key = array_search($imagePath, $gallery)) !== false) {
            unset($gallery[$key]);
            $transportInfo->gallery = array_values($gallery);
            $transportInfo->save();
            \Storage::disk('public')->delete($imagePath);
        }

        return back()->with('success', 'Image removed.');
    }
}