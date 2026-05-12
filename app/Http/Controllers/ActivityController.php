<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    /**
     * PUBLIC: Show all published activities (index page)
     */
    public function index()
    {
        $activities = Activity::published()
            ->latest()
            ->paginate(12);

        return view('activities.index', compact('activities'));
    }

    /**
     * PUBLIC: Show a single activity page by slug
     */
    public function show($slug)
    {
        $activity = Activity::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('activities.show', compact('activity'));
    }

    /**
     * ADMIN: List all activities (with unpublished)
     */
    public function adminIndex()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $activities = Activity::with('creator')
            ->latest()
            ->paginate(15);

        return view('admin.activities.index', compact('activities'));
    }

    /**
     * ADMIN: Show create form
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.activities.create');
    }

    /**
     * ADMIN: Store new activity
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:activities,title',
            'category' => 'required|in:beaches,desert_tours,museums,roman_ruins,hiking,diving,nightlife,shopping,traditional_markets,food_tours,festivals',
            'price_range' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'difficulty' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'booking_info' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        // Handle multiple images
        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $image) {
                $path = $image->store('activity_photos', 'public');
                $photoPaths[] = $path;
            }
        }
        $validated['photos'] = $photoPaths;

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = Auth::id();
        $validated['is_published'] = $request->has('is_published');

        Activity::create($validated);

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity created successfully!');
    }

    /**
     * ADMIN: Show edit form
     */
    public function edit(Activity $activity)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.activities.edit', compact('activity'));
    }

    /**
     * ADMIN: Update activity
     */
    public function update(Request $request, Activity $activity)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:activities,title,' . $activity->id,
            'category' => 'required|in:beaches,desert_tours,museums,roman_ruins,hiking,diving,nightlife,shopping,traditional_markets,food_tours,festivals',
            'price_range' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'difficulty' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'booking_info' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        // Append new images to existing ones
        $existingPhotos = $activity->photos ?? [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $image) {
                $path = $image->store('activity_photos', 'public');
                $existingPhotos[] = $path;
            }
        }
        $validated['photos'] = $existingPhotos;

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');

        $activity->update($validated);

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity updated successfully!');
    }

    /**
     * ADMIN: Delete activity
     */
    public function destroy(Activity $activity)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Delete images from storage
        if ($activity->photos) {
            foreach ($activity->photos as $photo) {
                \Storage::disk('public')->delete($photo);
            }
        }

        $activity->delete();

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity deleted successfully!');
    }

    /**
     * ADMIN: Remove a single image from activity gallery
     */
    public function removeImage(Request $request, Activity $activity)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $imagePath = $request->input('image');
        $photos = $activity->photos ?? [];

        if (($key = array_search($imagePath, $photos)) !== false) {
            unset($photos[$key]);
            $activity->photos = array_values($photos);
            $activity->save();
            \Storage::disk('public')->delete($imagePath);
        }

        return back()->with('success', 'Image removed.');
    }
}