<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    /**
     * Display a public listing of all trips.
     */
    public function index()
    {
        $trips = Trip::with('user')->latest('date')->paginate(12);
        return view('trips.index', compact('trips'));
    }

    /**
     * Show the form to create a new trip.
     */
    public function create()
    {
        return view('trips.create');
    }

    /**
     * Store a newly created trip in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'destination' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
            'departure_time' => 'required',
            'return_time' => 'required',
            'available_seats' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('trip_images', 'public');
        }

        $validated['user_id'] = Auth::id();

        Trip::create($validated);

        return redirect()->route('dashboard')->with('success', 'Trip posted successfully!');
    }

    /**
     * Show the dashboard with the current user's trips (agency espace).
     */
    public function myTrips()
    {
        $trips = Trip::where('user_id', Auth::id())
            ->latest('date')
            ->paginate(10);
        return view('dashboard', compact('trips'));
    }

    /**
     * Show the form to edit an existing trip (only the owner can edit).
     */
    public function edit(Trip $trip)
    {
        if ($trip->user_id !== Auth::id()) {
            abort(403);
        }
        return view('trips.edit', compact('trip'));
    }

    /**
     * Update the trip in the database.
     */
    public function update(Request $request, Trip $trip)
    {
        if ($trip->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'destination' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
            'departure_time' => 'required',
            'return_time' => 'required',
            'available_seats' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('trip_images', 'public');
        }

        $trip->update($validated);

        return redirect()->route('dashboard')->with('success', 'Trip updated successfully!');
    }

    /**
     * Delete a trip (only the owner can delete).
     */
    public function destroy(Trip $trip)
    {
        if ($trip->user_id !== Auth::id()) {
            abort(403);
        }

        $trip->delete();

        return redirect()->route('dashboard')->with('success', 'Trip deleted successfully!');
    }
}