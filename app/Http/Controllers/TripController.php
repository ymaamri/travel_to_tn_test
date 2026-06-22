<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    /**
     * Display a public listing of all trips (optionally filtered by destination).
     */
    public function index(Request $request)
    {
        $query = Trip::with('user');

        // Filter by destination if provided
        if ($request->filled('destination')) {
            $destination = $request->input('destination');
            $query->where('destination', 'like', '%' . $destination . '%');
        }

        $trips = $query->latest('date')->paginate(12);

        // Keep the search term in the pagination links
        $trips->appends(['destination' => $request->input('destination')]);

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
     * Show the dashboard with trips (admin sees all, regular users see only theirs).
     */
    public function myTrips()
    {
        if (Auth::user()->role === 'admin') {
            $trips = Trip::with('user')->latest('date')->paginate(10);
        } else {
            $trips = Trip::where('user_id', Auth::id())
                ->latest('date')
                ->paginate(10);
        }
        return view('dashboard', compact('trips'));
    }

    /**
     * Show the form to edit an existing trip (owner or admin can edit).
     */
    public function edit(Trip $trip)
    {
        // Allow if user is the owner OR is an admin
        if ($trip->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('trips.edit', compact('trip'));
    }

    /**
     * Update the trip in the database (owner or admin can update).
     */
    public function update(Request $request, Trip $trip)
    {
        // Allow if user is the owner OR is an admin
        if ($trip->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
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
     * Delete a trip (owner or admin can delete).
     */
    public function destroy(Trip $trip)
    {
        // Allow if user is the owner OR is an admin
        if ($trip->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $trip->delete();

        return redirect()->route('dashboard')->with('success', 'Trip deleted successfully!');
    }

    /**
     * Show a single trip (public).
     */
    public function show(Trip $trip)
    {
        return view('trips.show', compact('trip'));
    }
}