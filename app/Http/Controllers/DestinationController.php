<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    /**
     * PUBLIC: Show all published destinations (index page)
     */
    public function index()
    {
        $destinations = Destination::published()
            ->latest()
            ->paginate(12);

        return view('destinations.index', compact('destinations'));
    }

    /**
     * PUBLIC: Show a single destination page by slug
     */
    public function show($slug)
    {
        $destination = Destination::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('destinations.show', compact('destination'));
    }

    /**
     * ADMIN: List all destinations (with unpublished)
     */
    public function adminIndex()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $destinations = Destination::with('creator')
            ->latest()
            ->paginate(15);

        return view('admin.destinations.index', compact('destinations'));
    }

    /**
     * ADMIN: Show create form
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.destinations.create');
    }

    /**
     * ADMIN: Store new destination
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:destinations,name',
            'type' => 'required|in:city,region,beach,historical_place,island,desert_area,village',
            'overview' => 'nullable|string',
            'history' => 'nullable|string',
            'things_to_do' => 'nullable|string',
            'best_restaurants' => 'nullable|string',
            'hotels' => 'nullable|string',
            'weather' => 'nullable|string',
            'transportation' => 'nullable|string',
            'best_season' => 'nullable|string|max:255',
            'local_foods' => 'nullable|string',
            'budget_estimate' => 'nullable|string|max:255',
            'safety_info' => 'nullable|string',
            'map_url' => 'nullable|url',
            'photo_gallery' => 'nullable|array',
            'photo_gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'faqs' => 'nullable|array',
            'nearby_attractions' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        // Handle multiple images for photo gallery
        $galleryPaths = [];
        if ($request->hasFile('photo_gallery')) {
            foreach ($request->file('photo_gallery') as $image) {
                $path = $image->store('destination_gallery', 'public');
                $galleryPaths[] = $path;
            }
        }
        $validated['photo_gallery'] = $galleryPaths;

        // Handle FAQs as JSON
        if ($request->has('faqs')) {
            $faqs = [];
            $questions = $request->input('faq_question', []);
            $answers = $request->input('faq_answer', []);
            for ($i = 0; $i < count($questions); $i++) {
                if (!empty($questions[$i]) && !empty($answers[$i])) {
                    $faqs[] = ['question' => $questions[$i], 'answer' => $answers[$i]];
                }
            }
            $validated['faqs'] = $faqs;
        }

        $validated['slug'] = Str::slug($validated['name']);
        $validated['created_by'] = Auth::id();
        $validated['is_published'] = $request->has('is_published');

        Destination::create($validated);

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination created successfully!');
    }

    /**
     * ADMIN: Show edit form
     */
    public function edit(Destination $destination)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.destinations.edit', compact('destination'));
    }

    /**
     * ADMIN: Update destination
     */
    public function update(Request $request, Destination $destination)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:destinations,name,' . $destination->id,
            'type' => 'required|in:city,region,beach,historical_place,island,desert_area,village',
            'overview' => 'nullable|string',
            'history' => 'nullable|string',
            'things_to_do' => 'nullable|string',
            'best_restaurants' => 'nullable|string',
            'hotels' => 'nullable|string',
            'weather' => 'nullable|string',
            'transportation' => 'nullable|string',
            'best_season' => 'nullable|string|max:255',
            'local_foods' => 'nullable|string',
            'budget_estimate' => 'nullable|string|max:255',
            'safety_info' => 'nullable|string',
            'map_url' => 'nullable|url',
            'photo_gallery' => 'nullable|array',
            'photo_gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'faqs' => 'nullable|array',
            'nearby_attractions' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        // Handle new gallery images (append to existing)
        $existingGallery = $destination->photo_gallery ?? [];
        if ($request->hasFile('photo_gallery')) {
            foreach ($request->file('photo_gallery') as $image) {
                $path = $image->store('destination_gallery', 'public');
                $existingGallery[] = $path;
            }
        }
        $validated['photo_gallery'] = $existingGallery;

        // Handle FAQs
        if ($request->has('faqs')) {
            $faqs = [];
            $questions = $request->input('faq_question', []);
            $answers = $request->input('faq_answer', []);
            for ($i = 0; $i < count($questions); $i++) {
                if (!empty($questions[$i]) && !empty($answers[$i])) {
                    $faqs[] = ['question' => $questions[$i], 'answer' => $answers[$i]];
                }
            }
            $validated['faqs'] = $faqs;
        }

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_published'] = $request->has('is_published');

        $destination->update($validated);

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination updated successfully!');
    }

    /**
     * ADMIN: Delete destination
     */
    public function destroy(Destination $destination)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Optional: delete images from storage
        if ($destination->photo_gallery) {
            foreach ($destination->photo_gallery as $image) {
                \Storage::disk('public')->delete($image);
            }
        }

        $destination->delete();

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination deleted successfully!');
    }

    /**
     * ADMIN: Remove a single image from gallery
     */
    public function removeImage(Request $request, Destination $destination)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $imagePath = $request->input('image');
        $gallery = $destination->photo_gallery ?? [];

        if (($key = array_search($imagePath, $gallery)) !== false) {
            unset($gallery[$key]);
            $destination->photo_gallery = array_values($gallery);
            $destination->save();
            \Storage::disk('public')->delete($imagePath);
        }

        return back()->with('success', 'Image removed.');
    }
}