<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        // Get admin user (the first admin created in UserSeeder)
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $this->command->info('Admin user not found. Run UserSeeder first.');
            return;
        }

        $destinations = [
            [
                'name' => 'Tunis',
                'type' => 'city',
                'overview' => 'The capital of Tunisia, blending modern Arab and European architecture with a rich history.',
                'history' => 'Founded by the Berbers in the 2nd millennium BC, later a major center under the Almohads and Hafsid dynasties.',
                'things_to_do' => "Visit the Bardo Museum (mosaics), wander the Medina (UNESCO), explore the Cathedral of St Vincent de Paul, and stroll along Avenue Habib Bourguiba.",
                'best_restaurants' => "Dar El Jeld (traditional), Le Grand Café (French-Tunisian), El Ali (local cuisine).",
                'hotels' => "Hotel Africa, Laico Tunis, Dar Ben Gacem (traditional riad).",
                'weather' => 'Mediterranean climate – hot summers (30-35°C), mild winters (10-15°C).',
                'transportation' => 'Metro léger, TGM train to Carthage/Sidi Bou Said, taxis, bus.',
                'best_season' => 'March to June and September to November.',
                'local_foods' => "Lablabi (chickpea soup), merguez sandwiches, bambalouni (sweet donut), makroudh (date pastry).",
                'budget_estimate' => 'Budget: 30-50 TND/day, Mid-range: 80-150 TND/day.',
                'safety_info' => 'Generally safe, watch for pickpockets in crowded medina areas.',
                'map_url' => null,
                'photo_gallery' => [],
                'faqs' => [
                    ['question' => 'Is Tunis safe for solo travelers?', 'answer' => 'Yes, but keep valuables secure and avoid empty streets at night.'],
                    ['question' => 'What language is spoken?', 'answer' => 'Arabic and French, with some English in tourist areas.']
                ],
                'nearby_attractions' => 'Carthage ruins (15 min), Sidi Bou Said (20 min), La Marsa beach.',
                'latitude' => 36.8065,
                'longitude' => 10.1815,
                'meta_title' => 'Tunis Travel Guide – Things to Do, Hotels, Food',
                'meta_description' => 'Discover Tunis: medina, Bardo Museum, restaurants, and day trips to Carthage.',
                'is_published' => true,
            ],
            [
                'name' => 'Sousse',
                'type' => 'city',
                'overview' => 'Coastal city known for its medina (UNESCO), beaches, and vibrant nightlife.',
                'history' => 'Important Phoenician, Roman, and Byzantine port. Became a major tourist hub in the 20th century.',
                'things_to_do' => "Ribat fortress, Great Mosque, Boujaafar Beach, Port El Kantaoui marina, and shopping in the medina.",
                'best_restaurants' => "Restaurant Dar Soltane, Le Méditerranée, Chez Hattab.",
                'hotels' => "Mövenpick Resort & Marine Spa, Hotel Marhaba, Iberostar Selection Kantaoui Bay.",
                'weather' => 'Hot summers (30-38°C), mild winters (12-18°C).',
                'transportation' => 'Taxis, louage, train to Tunis, metro sahel to Monastir.',
                'best_season' => 'May to October (beach season).',
                'local_foods' => "Seafood couscous, brik (egg pastry), samsa, mloukhia.",
                'budget_estimate' => 'Budget: 40-70 TND/day, Mid-range: 100-180 TND/day.',
                'safety_info' => 'Tourist police present, very safe in resort areas.',
                'map_url' => null,
                'photo_gallery' => [],
                'faqs' => [
                    ['question' => 'Are there beaches near the city center?', 'answer' => 'Yes, Boujaafar Beach is a 10-min walk from medina.'],
                ],
                'nearby_attractions' => 'Monastir (20 min), El Jem (1 hour).',
                'latitude' => 35.8256,
                'longitude' => 10.6368,
                'meta_title' => 'Sousse Travel Guide – Beaches, Medina, Hotels',
                'meta_description' => 'Plan your trip to Sousse: top attractions, best restaurants, hotels, and local tips.',
                'is_published' => true,
            ],
            [
                'name' => 'Douz – Gateway to the Sahara',
                'type' => 'desert_area',
                'overview' => 'Known as the "Gateway to the Sahara", famous for date palms and camel treks.',
                'history' => 'Ancient caravan stop for trans-Saharan trade. Hosts the annual International Sahara Festival.',
                'things_to_do' => "Camel riding, 4x4 desert safaris, visit Ksar Ghilane hot springs, watch sunset over the dunes.",
                'best_restaurants' => "Restaurant El Madafa, Cafe des Amis.",
                'hotels' => "Hotel Sahara Douz, Campement Ksar Ghilane, El Mouradi Douz.",
                'weather' => 'Extreme desert climate – very hot summer days (40-48°C), cold nights in winter (near 0°C).',
                'transportation' => 'Louage from Gabès, private car, organized tours.',
                'best_season' => 'October to April (avoid June-August heat).',
                'local_foods' => "Mechoui (roasted lamb), dates varieties, couscous with vegetables.",
                'budget_estimate' => 'Budget: 60-90 TND/day, tours extra.',
                'safety_info' => 'Take guided desert tours, carry enough water, avoid traveling alone in dunes.',
                'map_url' => null,
                'photo_gallery' => [],
                'faqs' => [
                    ['question' => 'Can I camp overnight in the desert?', 'answer' => 'Yes, many tours offer Bedouin-style camps.'],
                ],
                'nearby_attractions' => 'Matmata troglodyte houses, Ksar Ghilane oasis.',
                'latitude' => 33.4631,
                'longitude' => 9.0214,
                'meta_title' => 'Douz Sahara – Camel Treks, Desert Camps, Tours',
                'meta_description' => 'Experience the Sahara desert from Douz. Camel rides, 4x4 safaris, and starry nights.',
                'is_published' => true,
            ],
            [
                'name' => 'Hammamet',
                'type' => 'beach',
                'overview' => 'Popular beach resort with white sand, gardens, and a charming medina.',
                'history' => 'First modern tourist resort in Tunisia (1960s). Once a Roman town called Pupput.',
                'things_to_do' => "Relax on Yasmine Hammamet beach, visit Carthage Land water park, explore the medina and fort.",
                'best_restaurants' => "Le Barberousse, La Bella Marina, Sidi Bou Said café.",
                'hotels' => "Hammamet Garden Resort, La Badira, Sentido Phenicia.",
                'weather' => 'Mediterranean, summers 28-34°C, winters 10-16°C.',
                'transportation' => 'Taxis, louage to Tunis (1h) and Sousse (45min).',
                'best_season' => 'June to September for swimming.',
                'local_foods' => "Grilled fish, chorba (soup), ojja (egg-tomato stew).",
                'budget_estimate' => 'Budget: 70-120 TND/day, Mid-range: 150-250 TND/day.',
                'safety_info' => 'Very safe tourist area.',
                'map_url' => null,
                'photo_gallery' => [],
                'faqs' => [
                    ['question' => 'Is Hammamet expensive?', 'answer' => 'Affordable compared to European resorts, but upscale hotels cost more.'],
                ],
                'nearby_attractions' => 'Nabeul (15 min), Tunis (1h).',
                'latitude' => 36.4000,
                'longitude' => 10.6167,
                'meta_title' => 'Hammamet Tunisia – Beaches, Hotels, Nightlife',
                'meta_description' => 'Best beach destination in Tunisia. Find hotels, restaurants, and activities in Hammamet.',
                'is_published' => true,
            ],
            [
                'name' => 'Carthage',
                'type' => 'historical_place',
                'overview' => 'Ancient Phoenician and Roman city, now a UNESCO site with stunning ruins overlooking the sea.',
                'history' => 'Founded by Queen Dido in 814 BC, destroyed by Rome in 146 BC, then rebuilt as a Roman capital.',
                'things_to_do' => "Antonine Baths, Byrsa Hill (Carthage Museum), Roman villas, Punic ports, Saint Louis Cathedral.",
                'best_restaurants' => "Café Sidi Bou Said (views), Le Restaurant du Musée.",
                'hotels' => "Tunis Carthage Hotel, Dar Said (Sidi Bou Said).",
                'weather' => 'Same as Tunis – mild winters, warm summers.',
                'transportation' => 'TGM train from Tunis Marine (20 min), taxi.',
                'best_season' => 'Spring (April-May) and autumn (Sep-Oct) for sightseeing.',
                'local_foods' => "Seafood at La Goulette port.",
                'budget_estimate' => 'Day trip cost: ~30-50 TND entry + transport.',
                'safety_info' => 'Safe, but watch for traffic when crossing roads.',
                'map_url' => null,
                'photo_gallery' => [],
                'faqs' => [
                    ['question' => 'How long to visit Carthage?', 'answer' => 'At least 3-4 hours to see main sites.'],
                ],
                'nearby_attractions' => 'Sidi Bou Said (1 km), Tunis (15 km).',
                'latitude' => 36.8531,
                'longitude' => 10.3308,
                'meta_title' => 'Carthage Ruins – History, Tickets, Tours',
                'meta_description' => 'Explore the ancient ruins of Carthage: Roman baths, museum, and top tips for visiting.',
                'is_published' => true,
            ],
        ];

        foreach ($destinations as $destData) {
            $destData['slug'] = Str::slug($destData['name']);
            $destData['created_by'] = $admin->id;
            Destination::create($destData);
        }
    }
}