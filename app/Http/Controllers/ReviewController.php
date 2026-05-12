<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Store a newly created review.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reviewable_type' => 'required|string',
            'reviewable_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Map the type string to the actual model class
        $typeMap = [
            'trip' => 'App\\Models\\Trip',
            'activity' => 'App\\Models\\Activity',
            'destination' => 'App\\Models\\Destination',
            'establishment' => 'App\\Models\\Establishment',
        ];

        if (!isset($typeMap[$validated['reviewable_type']])) {
            return back()->with('error', 'Invalid review type.');
        }

        $reviewableType = $typeMap[$validated['reviewable_type']];
        $reviewable = $reviewableType::findOrFail($validated['reviewable_id']);

        // Prevent duplicate reviews from same user on same item
        $existing = Review::where('user_id', Auth::id())
            ->where('reviewable_type', $reviewableType)
            ->where('reviewable_id', $reviewable->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this item.');
        }

        // Create the review
        $review = Review::create([
            'user_id' => Auth::id(),
            'reviewable_id' => $reviewable->id,
            'reviewable_type' => $reviewableType,
            'rating' => $validated['rating'],
            'title' => $validated['title'] ?? null,
            'content' => $validated['content'] ?? null,
            'is_verified' => Auth::user()->hasVerifiedTravel(), // auto-verify if user has trips
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('review_images', 'public');
                ReviewImage::create([
                    'review_id' => $review->id,
                    'image_path' => $path,
                ]);
            }
        }

        return back()->with('success', 'Thank you for your review!');
    }

    /**
     * Delete a review (only owner or admin).
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Delete associated images from storage
        foreach ($review->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }

    /**
     * Admin: Verify a review (mark as verified traveler).
     */
    public function verify(Review $review)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $review->update(['is_verified' => true]);

        return back()->with('success', 'Review verified.');
    }
}