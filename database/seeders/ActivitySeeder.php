<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        // Get admin user
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $admin = User::first();
        }
        if (!$admin) {
            $this->command->info('No users found. Run UserSeeder first.');
            return;
        }

        $activities = [
            [
                'title' => 'Camel Ride at Sunset in Douz',
                'category' => 'desert_tours',
                'price_range' => '40-60 TND per person',
                'duration' => '2 hours',
                'difficulty' => 'Easy',
                'location' => 'Douz',
                'description' => "Experience the magic of the Sahara as the sun sets over golden dunes. A local guide leads you on a gentle camel trek, followed by traditional mint tea. Perfect for photographers and families.",
                'booking_info' => "Book through hotels in Douz or at the tourist office. Tours depart daily at 4 PM. Wear comfortable clothes and bring a scarf for sand.",
                'meta_title' => 'Camel Ride Douz Sahara Sunset Tour',
                'meta_description' => 'Book a sunset camel ride in Douz. Traditional experience with guide and tea.',
                'is_published' => true,
                'photos' => [],
            ],
            [
                'title' => 'Roman Ruins of Dougga Full-Day Tour',
                'category' => 'roman_ruins',
                'price_range' => '70-90 TND (including transport from Tunis)',
                'duration' => '8 hours',
                'difficulty' => 'Moderate (walking on uneven terrain)',
                'location' => 'Dougga (near Beja)',
                'description' => "Dougga is one of the best-preserved Roman cities in Africa. Visit the Capitol, theater (seats 3,500), temples, and baths. UNESCO World Heritage site. Includes guide and lunch at a local farm.",
                'booking_info' => "Tours available from Tunis (depart 8 AM, return 5 PM). Private tours cost 150-200 TND. Entry ticket: 10 TND.",
                'meta_title' => 'Dougga Roman Ruins Tour from Tunis',
                'meta_description' => 'Explore the stunning Roman ruins of Dougga. UNESCO site with guide and lunch included.',
                'is_published' => true,
                'photos' => [],
            ],
            [
                'title' => 'Diving in Tabarka – Coral Reefs',
                'category' => 'diving',
                'price_range' => '120-180 TND per dive (including gear)',
                'duration' => '3 hours (1 dive)',
                'difficulty' => 'Moderate (certification required for deep dives)',
                'location' => 'Tabarka',
                'description' => "Tabarka has some of the Mediterranean's best coral reefs. Dive sites include Les Grottes (caves) and Le Tombant de Tabarka. Visibility up to 30 meters. Turtles, groupers, and octopus common.",
                'booking_info' => "Several PADI dive centers: Tabarka Plongée, Aqua Diving. Courses available for beginners. Best season: May-October.",
                'meta_title' => 'Scuba Diving Tabarka – Coral Reefs & Marine Life',
                'meta_description' => 'Dive in Tabarka, Tunisia’s premier coral reef destination. PADI courses and equipment rental.',
                'is_published' => true,
                'photos' => [],
            ],
            [
                'title' => 'Cooking Class: Traditional Tunisian Cuisine',
                'category' => 'food_tours',
                'price_range' => '80-120 TND per person',
                'duration' => '4 hours',
                'difficulty' => 'Easy',
                'location' => 'Tunis or Sousse',
                'description' => "Learn to make couscous, brik, harissa, and makroudh in a local home or cooking school. Includes market visit to buy fresh ingredients, then hands-on cooking and eating what you prepare.",
                'booking_info' => "Available in Tunis (Carthage Cooking School) or Sousse (Dar Amna). Book 2 days in advance. Vegetarian options available.",
                'meta_title' => 'Tunisian Cooking Class – Make Couscous & Brik',
                'meta_description' => 'Join a hands-on cooking class in Tunis or Sousse. Market tour, local recipes, and lunch included.',
                'is_published' => true,
                'photos' => [],
            ],
            [
                'title' => 'Hiking in Ichkeul National Park',
                'category' => 'hiking',
                'price_range' => '30-50 TND (park entry + guide)',
                'duration' => '3-5 hours',
                'difficulty' => 'Moderate',
                'location' => 'Ichkeul Lake (near Bizerte)',
                'description' => "Ichkeul is a UNESCO biosphere reserve and a major wetland for migratory birds (flamingos, herons, ducks). Hike the Jebel Ichkeul mountain for panoramic views of the lake and surrounding forests. Best from November to March.",
                'booking_info' => "Hire a local guide at the park entrance (around 20 TND). Bring binoculars, water, and sturdy shoes.",
                'meta_title' => 'Hiking Ichkeul National Park – Birdwatching & Views',
                'meta_description' => 'Explore Tunisia’s only UNESCO wetland park. See flamingos and hike Jebel Ichkeul.',
                'is_published' => true,
                'photos' => [],
            ],
            [
                'title' => 'Nightlife in Yasmine Hammamet',
                'category' => 'nightlife',
                'price_range' => 'Varies (club entry 20-40 TND)',
                'duration' => 'Evening',
                'difficulty' => 'Easy',
                'location' => 'Yasmine Hammamet',
                'description' => "Yasmine Hammamet is Tunisia's nightlife hub. Popular clubs: El Mouradi Club, Latina (Latin music), and New York Club. Also many beach bars and lounges. Dress code smart casual.",
                'booking_info' => "Most clubs open from 10 PM to 4 AM. Taxis available from Hammamet center (5-10 TND).",
                'meta_title' => 'Nightlife in Yasmine Hammamet – Best Clubs & Bars',
                'meta_description' => 'Guide to clubs, bars, and beach parties in Yasmine Hammamet. Where to go for a fun night out.',
                'is_published' => true,
                'photos' => [],
            ],
            [
                'title' => 'Shop at the Medina of Tunis',
                'category' => 'shopping',
                'price_range' => 'Free entry, items vary',
                'duration' => '2-4 hours',
                'difficulty' => 'Easy',
                'location' => 'Tunis Medina',
                'description' => "Wander through the labyrinthine souks: Souk El Attarine (perfumes), Souk El Leffa (carpets), Souk El Berka (jewelry). Haggle for copperware, pottery, leather babouche slippers, and textiles. Don't miss the Zitouna Mosque.",
                'booking_info' => "Open daily 9 AM – 7 PM (closed Friday afternoon for prayer). Best to go in morning. Wear comfortable shoes.",
                'meta_title' => 'Shopping in Tunis Medina – Souks & Bargains',
                'meta_description' => 'What to buy in Tunis: carpets, pottery, spices, and leather. Tips for bargaining.',
                'is_published' => true,
                'photos' => [],
            ],
            [
                'title' => 'Traditional Market – Sousse Souk',
                'category' => 'traditional_markets',
                'price_range' => 'Free entry',
                'duration' => '2 hours',
                'difficulty' => 'Easy',
                'location' => 'Sousse Medina',
                'description' => "The Sousse souk is smaller and less touristy than Tunis. Find wool carpets, olive wood crafts, and local wool cloaks (burnous). The fish market at the port is vibrant in the morning.",
                'booking_info' => "Open Saturday-Thursday 9 AM-7 PM. Friday only morning.",
                'meta_title' => 'Sousse Souk – Traditional Market Guide',
                'meta_description' => 'Shop like a local at Sousse’s traditional market. Carpets, crafts, and local wool.',
                'is_published' => true,
                'photos' => [],
            ],
            [
                'title' => 'Bardo Museum Tour – World’s Largest Mosaic Collection',
                'category' => 'museums',
                'price_range' => '11 TND entry (plus guide 20-30 TND)',
                'duration' => '2-3 hours',
                'difficulty' => 'Easy',
                'location' => 'Tunis',
                'description' => "The Bardo Museum houses the most important Roman mosaics in the world. Highlights include the 'Virgil Mosaic' and 'The Sea Creatures'. Also Punic and Islamic artifacts. The building itself is a former Ottoman palace.",
                'booking_info' => "Open 9:30 AM – 4:30 PM (closed Mondays). Audioguides available (5 TND). Photography without flash allowed.",
                'meta_title' => 'Bardo Museum Tunis – Mosaics & Roman Art',
                'meta_description' => 'Visit the Bardo Museum in Tunis: ticket prices, highlights, and tips.',
                'is_published' => true,
                'photos' => [],
            ],
            [
                'title' => 'Festival of the Sahara – Douz',
                'category' => 'festivals',
                'price_range' => 'Free or 5-10 TND for events',
                'duration' => '4 days',
                'difficulty' => 'Easy',
                'location' => 'Douz',
                'description' => "Held every year in late December. Features camel races, desert weddings, traditional music, and Bedouin crafts. The opening parade is spectacular. Book accommodation months in advance.",
                'booking_info' => "Check dates online (usually Dec 24-27). Tickets available at the festival ground.",
                'meta_title' => 'Festival of the Sahara Douz – Dates & Events',
                'meta_description' => 'Plan your visit to Douz Sahara Festival: camel racing, music, and cultural events.',
                'is_published' => true,
                'photos' => [],
            ],
        ];

        foreach ($activities as $activityData) {
            $activityData['slug'] = Str::slug($activityData['title']);
            $activityData['created_by'] = $admin->id;
            Activity::create($activityData);
        }
    }
}