<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EstablishmentController extends Controller
{
    /**
     * PUBLIC: Show all published establishments (index page)
     */
    public function index()
    {
        $category = request('category');
        $query = Establishment::published();

        if (
            $category && in_array($category, [
                'hotel',
                'resort',
                'hostel',
                'guest_house',
                'cafe',
                'traditional_restaurant',
                'luxury_dining'
            ])
        ) {
            $query->where('category', $category);
        }

        $establishments = $query->latest()->paginate(12);

        return view('directory.index', compact('establishments'));
    }

    /**
     * PUBLIC: Show a single establishment page by slug
     */
    public function show($slug)
    {
        $establishment = Establishment::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('directory.show', compact('establishment'));
    }

    /**
     * ADMIN: List all establishments (with unpublished)
     */
    public function adminIndex()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $establishments = Establishment::with('creator')
            ->latest()
            ->paginate(15);

        return view('admin.establishments.index', compact('establishments'));
    }

    /**
     * ADMIN: Show create form
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.establishments.create');
    }

    /**
     * ADMIN: Store new establishment
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:establishments,name',
            'category' => 'required|in:hotel,resort,hostel,guest_house,cafe,traditional_restaurant,luxury_dining',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'price_range' => 'nullable|string|max:255',
            'amenities' => 'nullable|array',
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'map_url' => 'nullable|url',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_published' => 'boolean',
        ]);

        // Handle multiple images
        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $image) {
                $path = $image->store('establishment_photos', 'public');
                $photoPaths[] = $path;
            }
        }
        $validated['photos'] = $photoPaths;

        $validated['slug'] = Str::slug($validated['name']);
        $validated['created_by'] = Auth::id();
        $validated['is_published'] = $request->has('is_published');
        $validated['review_count'] = 0;

        Establishment::create($validated);

        return redirect()->route('admin.establishments.index')
            ->with('success', 'Establishment created successfully!');
    }

    /**
     * ADMIN: Show edit form
     */
    public function edit(Establishment $establishment)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.establishments.edit', compact('establishment'));
    }

    /**
     * ADMIN: Update establishment
     */
    public function update(Request $request, Establishment $establishment)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:establishments,name,' . $establishment->id,
            'category' => 'required|in:hotel,resort,hostel,guest_house,cafe,traditional_restaurant,luxury_dining',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'price_range' => 'nullable|string|max:255',
            'amenities' => 'nullable|array',
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'map_url' => 'nullable|url',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_published' => 'boolean',
        ]);

        // Append new images to existing ones
        $existingPhotos = $establishment->photos ?? [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $image) {
                $path = $image->store('establishment_photos', 'public');
                $existingPhotos[] = $path;
            }
        }
        $validated['photos'] = $existingPhotos;

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_published'] = $request->has('is_published');

        $establishment->update($validated);

        return redirect()->route('admin.establishments.index')
            ->with('success', 'Establishment updated successfully!');
    }

    /**
     * ADMIN: Delete establishment
     */
    public function destroy(Establishment $establishment)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Delete images from storage
        if ($establishment->photos) {
            foreach ($establishment->photos as $photo) {
                \Storage::disk('public')->delete($photo);
            }
        }

        $establishment->delete();

        return redirect()->route('admin.establishments.index')
            ->with('success', 'Establishment deleted successfully!');
    }

    /**
     * ADMIN: Remove a single image from gallery
     */
    public function removeImage(Request $request, Establishment $establishment)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $imagePath = $request->input('image');
        $photos = $establishment->photos ?? [];

        if (($key = array_search($imagePath, $photos)) !== false) {
            unset($photos[$key]);
            $establishment->photos = array_values($photos);
            $establishment->save();
            \Storage::disk('public')->delete($imagePath);
        }

        return back()->with('success', 'Image removed.');
    }
}