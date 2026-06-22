<?php

namespace App\Http\Controllers;

use App\Models\SavedItinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ItineraryController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('=== ITINERARY SAVE ATTEMPT ===');
            Log::info('User ID: ' . Auth::id());

            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Not authenticated'], 401);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'itinerary_data' => 'required|array',
                'total_cost' => 'nullable|numeric',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ]);

            $saved = SavedItinerary::create([
                'user_id' => Auth::id(),
                'name' => $validated['name'],
                'itinerary_data' => $validated['itinerary_data'],
                'total_cost' => $validated['total_cost'] ?? 0,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ]);

            Log::info('Itinerary saved with ID: ' . $saved->id);

            return response()->json([
                'message' => 'Itinerary saved successfully!',
                'id' => $saved->id
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . json_encode($e->errors()));
            return response()->json(['error' => 'Validation failed: ' . json_encode($e->errors())], 422);
        } catch (\Exception $e) {
            Log::error('Save error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $itineraries = SavedItinerary::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'start_date', 'end_date', 'total_cost', 'created_at']);
        return response()->json($itineraries);
    }

    public function show($id)
    {
        $itinerary = SavedItinerary::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($itinerary);
    }

    public function destroy($id)
    {
        $itinerary = SavedItinerary::where('user_id', Auth::id())->findOrFail($id);
        $itinerary->delete();
        return response()->json(['message' => 'Itinerary deleted']);
    }
}