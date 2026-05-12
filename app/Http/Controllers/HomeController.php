<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Blog;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Featured destinations – latest 6 trips
        $featuredTrips = Trip::with('user')->latest()->take(6)->get();

        // Popular experiences – trips with price between 50 and 200 TND (example)
        $popularExperiences = Trip::whereBetween('price', [50, 200])
            ->latest()
            ->take(4)
            ->get();

        // Best beaches – trips that mention "beach" in title or destination
        $beaches = Trip::where('title', 'like', '%beach%')
            ->orWhere('destination', 'like', '%beach%')
            ->latest()
            ->take(3)
            ->get();

        // Sahara tours – trips mentioning "sahara" or "desert"
        $saharaTours = Trip::where('title', 'like', '%sahara%')
            ->orWhere('destination', 'like', '%sahara%')
            ->orWhere('description', 'like', '%desert%')
            ->latest()
            ->take(3)
            ->get();

        // Food experiences – trips about food/cuisine
        $foodExperiences = Trip::where('title', 'like', '%food%')
            ->orWhere('description', 'like', '%cuisine%')
            ->orWhere('description', 'like', '%restaurant%')
            ->latest()
            ->take(3)
            ->get();

        // Latest travel tips from blog
        $travelTips = Blog::with('user')
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        // Static testimonials (can be moved to a database later)
        $testimonials = [
            [
                'name' => 'Sarah Johnson',
                'country' => 'USA',
                'text' => 'Tunisia exceeded all my expectations! The hospitality was incredible and every corner tells a story. I already booked my next trip.',
                'rating' => 5,
            ],
            [
                'name' => 'Mohamed Al Farsi',
                'country' => 'UAE',
                'text' => 'The Sahara desert overnight tour was a life‑changing experience. Professional guides and breathtaking landscapes.',
                'rating' => 5,
            ],
            [
                'name' => 'Emma Laurent',
                'country' => 'France',
                'text' => 'From the blue‑and‑white streets of Sidi Bou Said to the ancient ruins of Carthage – Tunisia is a hidden gem.',
                'rating' => 5,
            ],
        ];

        return view('home', compact(
            'featuredTrips',
            'popularExperiences',
            'beaches',
            'saharaTours',
            'foodExperiences',
            'travelTips',
            'testimonials'
        ));
    }
}