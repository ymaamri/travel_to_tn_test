<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TripPlannerController extends Controller
{
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'budget' => 'required|in:budget,moderate,luxury',
            'interests' => 'array',
            'cities' => 'required|array|min:1',
        ]);

        $cities = $validated['cities'];
        $budget = $validated['budget'];
        $interests = $validated['interests'] ?? [];
        $startDate = $validated['startDate'];
        $endDate = $validated['endDate'];
        $days = (new \DateTime($startDate))->diff(new \DateTime($endDate))->days + 1;

        if ($days > 14) {
            return response()->json([
                'error' => 'Maximum trip duration is 14 days. Please select a shorter date range.'
            ], 422);
        }

        $itinerary = [];
        $totalCost = 0;
        $cityIndex = 0;
        $numCities = count($cities);
        $previousCity = null;

        for ($day = 1; $day <= $days; $day++) {
            $city = $cities[$cityIndex % $numCities];
            $cityIndex++;

            $activities = $this->getActivitiesForCity($city, $interests, $budget);
            $hotel = $this->getHotelForCity($city, $budget);
            $transport = $this->getTransportBetweenCities($city, $previousCity);
            $transportCost = $this->getTransportCost($transport, $budget);

            $dailyCost = $activities->sum('estimated_cost') + ($hotel['estimated_cost'] ?? 50) + $transportCost;
            $totalCost += $dailyCost;

            $itinerary[] = [
                'day' => $day,
                'city' => $city,
                'activities' => $activities->map(fn($a) => [
                    'title' => $a->title,
                    'description' => $a->description ?? '',
                    'cost' => $a->estimated_cost,
                ])->toArray(),
                'hotel' => $hotel['name'],
                'hotel_link' => $hotel['link'] ?? null,
                'transport' => $transport,
                'estimatedCost' => round($dailyCost, 2),
            ];

            $previousCity = $city;
        }

        // Simple weather forecast (static, you can later replace with API)
        $weather = $this->getWeatherForCity($cities[0]);

        return response()->json([
            'days' => $itinerary,
            'totalCost' => round($totalCost, 2),
            'weather' => $weather,
        ]);
    }

    /**
     * Get real activities from database, filtered by city and interests.
     */
    private function getActivitiesForCity($city, $interests, $budget): Collection
    {
        $query = Activity::published()
            ->where(function ($q) use ($city) {
                $q->where('location', 'like', "%{$city}%")
                    ->orWhere('title', 'like', "%{$city}%");
            });

        // Map interests to activity categories
        $interestCategories = [
            'History & Culture' => ['museums', 'roman_ruins'],
            'Beaches' => ['beaches'],
            'Sahara Desert' => ['desert_tours'],
            'Food & Cuisine' => ['food_tours', 'traditional_markets'],
            'Shopping' => ['shopping', 'traditional_markets'],
            'Roman Ruins' => ['roman_ruins'],
        ];

        $categories = [];
        foreach ($interests as $interest) {
            if (isset($interestCategories[$interest])) {
                $categories = array_merge($categories, $interestCategories[$interest]);
            }
        }
        if (!empty($categories)) {
            $query->whereIn('category', array_unique($categories));
        }

        $activities = $query->inRandomOrder()->limit(rand(2, 3))->get();

        // If nothing found, fallback to default activities (hardcoded but still realistic)
        if ($activities->count() < 2) {
            $defaults = [
                'Tunis' => ['Medina Walking Tour', 'Bardo Museum', 'Souk Shopping'],
                'Hammamet' => ['Beach Relaxation', 'Medina Visit', 'Yasmine Hammamet'],
                'Sidi Bou Said' => ['Blue & White Streets', 'Café des Délices', 'Art Galleries'],
                'Sousse' => ['Medina & Ribat', 'Port El Kantaoui', 'Museum'],
                'Kairouan' => ['Great Mosque', 'Aghlabid Basins', 'Carpet Shops'],
                'El Jem' => ['Amphitheatre', 'Archaeological Museum'],
                'Douz' => ['Camel Trekking', 'Sahara Dunes', 'Sunset Tour'],
                'Djerba' => ['Houmt Souk', 'Guellala Museum', 'Flamingo Island'],
            ];
            $defaultList = $defaults[$city] ?? ['Local Tour', 'Sightseeing', 'Shopping'];
            foreach ($defaultList as $title) {
                $act = new Activity();
                $act->title = $title;
                $act->estimated_cost = $this->getCostByBudget($budget, 20, 50, 100);
                $activities->push($act);
            }
        }

        // Assign estimated cost based on budget and price_range (if real activity)
        foreach ($activities as $activity) {
            if (!isset($activity->estimated_cost)) {
                $activity->estimated_cost = $this->estimateActivityCost($activity, $budget);
            }
        }

        return $activities;
    }

    /**
     * Estimate cost for a real activity using its price_range and budget.
     */
    private function estimateActivityCost($activity, $budget): int
    {
        $priceRange = $activity->price_range ?? '';
        if (strpos($priceRange, '$$$') !== false) {
            return $budget === 'luxury' ? 150 : ($budget === 'moderate' ? 100 : 80);
        }
        if (strpos($priceRange, '$$') !== false) {
            return $budget === 'luxury' ? 100 : ($budget === 'moderate' ? 70 : 40);
        }
        if (strpos($priceRange, '$') !== false) {
            return $budget === 'luxury' ? 60 : ($budget === 'moderate' ? 40 : 20);
        }
        // fallback
        return $this->getCostByBudget($budget, 25, 60, 120);
    }

    private function getCostByBudget($budget, $budgetCost, $moderateCost, $luxuryCost): int
    {
        if ($budget === 'budget')
            return $budgetCost;
        if ($budget === 'moderate')
            return $moderateCost;
        return $luxuryCost;
    }

    /**
     * Get a real hotel from establishments table (type hotel/resort/guest_house).
     */
    private function getHotelForCity($city, $budget): array
    {
        $query = Establishment::published()
            ->whereIn('category', ['hotel', 'resort', 'guest_house'])
            ->where(function ($q) use ($city) {
                $q->where('city', 'like', "%{$city}%")
                    ->orWhere('address', 'like', "%{$city}%");
            });

        // Filter by price_range according to budget
        if ($budget === 'budget') {
            $query->where('price_range', 'like', '%$%')
                ->whereNot('price_range', 'like', '$$$');
        } elseif ($budget === 'moderate') {
            $query->where('price_range', 'like', '%$$%');
        } else {
            $query->where('price_range', 'like', '%$$$%');
        }

        $hotel = $query->first();

        if (!$hotel) {
            // Fallback if no hotel found
            return [
                'name' => "Standard Hotel in {$city}",
                'estimated_cost' => $this->getCostByBudget($budget, 40, 80, 150),
                'link' => null,
            ];
        }

        $cost = $this->estimateHotelCost($hotel->price_range, $budget);
        return [
            'name' => $hotel->name,
            'estimated_cost' => $cost,
            'link' => $hotel->website ?? null,
        ];
    }

    private function estimateHotelCost($priceRange, $budget): int
    {
        if (strpos($priceRange, '$$$') !== false) {
            return $budget === 'luxury' ? 180 : ($budget === 'moderate' ? 120 : 90);
        }
        if (strpos($priceRange, '$$') !== false) {
            return $budget === 'luxury' ? 110 : ($budget === 'moderate' ? 80 : 50);
        }
        if (strpos($priceRange, '$') !== false) {
            return $budget === 'luxury' ? 70 : ($budget === 'moderate' ? 50 : 30);
        }
        return $this->getCostByBudget($budget, 45, 85, 160);
    }

    private function getTransportBetweenCities($currentCity, $previousCity = null): string
    {
        if (!$previousCity) {
            return 'Arrival at ' . $currentCity;
        }
        $routes = [
            'Tunis-Sidi Bou Said' => '🚆 Train (20 min)',
            'Tunis-Hammamet' => '🚐 Louage (1 hour)',
            'Tunis-Sousse' => '🚆 Train (1.5 hours)',
            'Sousse-El Jem' => '🚐 Louage (45 min)',
            'Sousse-Kairouan' => '🚌 Bus (1 hour)',
            'Kairouan-Douz' => '🚗 Private car (4 hours)',
            'Douz-Djerba' => '🚌 Bus (2 hours)',
        ];
        $key = $previousCity . '-' . $currentCity;
        return $routes[$key] ?? '🚕 Local transport';
    }

    private function getTransportCost($transport, $budget): int
    {
        if (strpos($transport, 'Train') !== false)
            return 5;
        if (strpos($transport, 'Louage') !== false)
            return 8;
        if (strpos($transport, 'Bus') !== false)
            return 10;
        if (strpos($transport, 'Private car') !== false)
            return $budget === 'budget' ? 30 : 60;
        return 0;
    }

    private function getWeatherForCity($city): string
    {
        // Simple static map – you can later integrate a real weather API
        $map = [
            'Tunis' => '☀️ Sunny, 22-28°C',
            'Sidi Bou Said' => '☀️ Sunny, 20-26°C',
            'Hammamet' => '☀️ Sunny, 23-29°C',
            'Sousse' => '☀️ Sunny, 24-30°C',
            'Kairouan' => '🔥 Hot, 30-38°C',
            'Douz' => '🌵 Very hot, 35-45°C',
            'Djerba' => '🌊 Sunny, 25-32°C',
        ];
        return $map[$city] ?? '🌤️ Pleasant weather';
    }
}