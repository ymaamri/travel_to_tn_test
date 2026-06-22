<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Establishment;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Return all markers for the interactive map from database.
     */
    public function markers()
    {
        $markers = [];

        // 1. Get all destinations with coordinates
        $destinations = Destination::published()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        foreach ($destinations as $dest) {
            $rating = $dest->reviews->avg('rating') ?? 0;
            $reviewCount = $dest->reviews->count();
            $photo = $dest->photo_gallery ? (asset('storage/' . $dest->photo_gallery[0])) : null;

            $markers[] = [
                'id' => $dest->id,
                'type' => 'destination',
                'category' => $dest->type,
                'name' => $dest->name,
                'lat' => (float) $dest->latitude,
                'lng' => (float) $dest->longitude,
                'rating' => round($rating, 1),
                'review_count' => $reviewCount,
                'photo' => $photo,
                'slug' => $dest->slug,
            ];
        }

        // 2. Get all establishments (hotels, restaurants, cafes) with coordinates
        $establishments = Establishment::published()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        foreach ($establishments as $est) {
            $rating = $est->rating ?? 0;
            $reviewCount = $est->review_count ?? 0;
            $photo = $est->photos ? (asset('storage/' . $est->photos[0])) : null;

            $markers[] = [
                'id' => $est->id,
                'type' => 'establishment',
                'category' => $est->category,
                'name' => $est->name,
                'lat' => (float) $est->latitude,
                'lng' => (float) $est->longitude,
                'rating' => round($rating, 1),
                'review_count' => $reviewCount,
                'photo' => $photo,
                'slug' => $est->slug,
            ];
        }

        // If no markers in database, return some default markers so map isn't empty
        if (empty($markers)) {
            return response()->json([
                [
                    'id' => 1,
                    'type' => 'destination',
                    'category' => 'city',
                    'name' => 'Tunis',
                    'lat' => 36.8065,
                    'lng' => 10.1815,
                    'rating' => 4.5,
                    'review_count' => 0,
                    'photo' => null,
                    'slug' => 'tunis'
                ],
                [
                    'id' => 2,
                    'type' => 'destination',
                    'category' => 'city',
                    'name' => 'Sidi Bou Said',
                    'lat' => 36.8689,
                    'lng' => 10.3415,
                    'rating' => 4.8,
                    'review_count' => 0,
                    'photo' => null,
                    'slug' => 'sidi-bou-said'
                ],
                [
                    'id' => 3,
                    'type' => 'destination',
                    'category' => 'beach',
                    'name' => 'Hammamet',
                    'lat' => 36.3981,
                    'lng' => 10.5624,
                    'rating' => 4.3,
                    'review_count' => 0,
                    'photo' => null,
                    'slug' => 'hammamet'
                ],
                [
                    'id' => 4,
                    'type' => 'destination',
                    'category' => 'historical_place',
                    'name' => 'El Jem Amphitheatre',
                    'lat' => 35.2950,
                    'lng' => 10.7140,
                    'rating' => 4.9,
                    'review_count' => 0,
                    'photo' => null,
                    'slug' => 'el-jem'
                ],
                [
                    'id' => 5,
                    'type' => 'destination',
                    'category' => 'desert_area',
                    'name' => 'Douz (Sahara Gate)',
                    'lat' => 33.4639,
                    'lng' => 9.0204,
                    'rating' => 4.7,
                    'review_count' => 0,
                    'photo' => null,
                    'slug' => 'douz'
                ],
            ]);
        }

        return response()->json($markers);
    }
}